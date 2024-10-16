<?php
/**
 * DisambiguationPageLinks SpecialPage for Disambiguator extension
 * This page lists all pages that link to disambiguation pages.
 *
 * @file
 * @ingroup Extensions
 */

namespace MediaWiki\Extension\Disambiguator\Specials;

use Exception;
use MediaWiki\Cache\LinkBatchFactory;
use MediaWiki\Content\IContentHandlerFactory;
use MediaWiki\Linker\LinksMigration;
use MediaWiki\SpecialPage\QueryPage;
use MediaWiki\Title\NamespaceInfo;
use MediaWiki\Title\Title;
use Wikimedia\Rdbms\DBError;
use Wikimedia\Rdbms\IConnectionProvider;
use Wikimedia\Rdbms\IDatabase;
use Wikimedia\Rdbms\IResultWrapper;
use Wikimedia\Rdbms\SelectQueryBuilder;

class SpecialDisambiguationPageLinks extends QueryPage {

	/** @var NamespaceInfo */
	private $namespaceInfo;

	/** @var LinkBatchFactory */
	private $linkBatchFactory;

	/** @var IContentHandlerFactory */
	private $contentHandlerFactory;
	private IConnectionProvider $dbProvider;
	private LinksMigration $linksMigration;

	/**
	 * @param NamespaceInfo $namespaceInfo
	 * @param LinkBatchFactory $linkBatchFactory
	 * @param IContentHandlerFactory $contentHandlerFactory
	 * @param IConnectionProvider $dbProvider
	 * @param LinksMigration $linksMigration
	 */
	public function __construct(
		NamespaceInfo $namespaceInfo,
		LinkBatchFactory $linkBatchFactory,
		IContentHandlerFactory $contentHandlerFactory,
		IConnectionProvider $dbProvider,
		LinksMigration $linksMigration
	) {
		parent::__construct( 'DisambiguationPageLinks' );
		$this->namespaceInfo = $namespaceInfo;
		$this->linkBatchFactory = $linkBatchFactory;
		$this->contentHandlerFactory = $contentHandlerFactory;
		$this->dbProvider = $dbProvider;
		$this->linksMigration = $linksMigration;
	}

	public function isExpensive(): bool {
		return true;
	}

	public function isSyndicated(): bool {
		return false;
	}

	/** @inheritDoc */
	public function getQueryInfo() {
		[ $blNamespace, $blTitle ] = $this->linksMigration->getTitleFields( 'pagelinks' );
		$queryInfo = $this->linksMigration->getQueryInfo( 'pagelinks', 'pagelinks' );
		return [
			'tables' => array_merge( $queryInfo['tables'], [
				'p1' => 'page',
				'p2' => 'page',
				'page_props'
			] ),
			// The fields we are selecting correspond with fields in the
			// querycachetwo table so that the results are cachable.
			'fields' => [
				'value' => 'pl_from',
				'namespace' => 'p2.page_namespace',
				'title' => 'p2.page_title',
				'to_namespace' => 'p1.page_namespace',
				'to_title' => 'p1.page_title',
			],
			'conds' => [
				'pp_propname' => 'disambiguation',
				'p2.page_namespace' => $this->namespaceInfo->getContentNamespaces(),
				'p2.page_is_redirect != 1'
			],
			'join_conds' => array_merge( $queryInfo['joins'], [
				'p1' => [ 'JOIN', [ "$blNamespace = p1.page_namespace", "$blTitle = p1.page_title" ] ],
				'page_props' => [ 'JOIN', [ 'p1.page_id = pp_page' ] ],
				'p2' => [ 'JOIN', [ 'p2.page_id = pl_from' ] ]
			] )
		];
	}

	/**
	 * Order the results by ID of the linking page (value), namespace of the
	 * linked page, and title of the linked page. This function only affects
	 * ordering when not using $wgMiserMode.
	 *
	 * @return array
	 */
	public function getOrderFields() {
		return [ 'value', 'to_namespace', 'to_title' ];
	}

	public function sortDescending(): bool {
		return false;
	}

	/** @inheritDoc */
	public function formatResult( $skin, $result ) {
		$fromTitle = Title::makeTitle( $result->namespace, $result->title );
		$toTitle = Title::makeTitle( $result->to_namespace, $result->to_title );

		$linkRenderer = $this->getLinkRenderer();
		$from = $linkRenderer->makeKnownLink( $fromTitle );
		$arr = $this->getLanguage()->getArrow();
		$to = $linkRenderer->makeKnownLink( $toTitle );

		// Check if user is allowed to edit
		if (
			$this->getAuthority()->isAllowed( 'edit' ) &&
			$this->contentHandlerFactory->getContentHandler( $fromTitle->getContentModel() )->supportsDirectEditing()
		) {
			$edit = $linkRenderer->makeLink(
				$fromTitle,
				$this->msg( 'parentheses', $this->msg( 'editlink' )->text() )->text(),
				[],
				[ 'redirect' => 'no', 'action' => 'edit' ]
			);
			return "$from $edit $arr $to";
		}

		return "$from $arr $to";
	}

	/** @inheritDoc */
	protected function getGroupName() {
		return 'pages';
	}

	/**
	 * Clear the cache and save new results
	 *
	 * @param int|bool $limit Limit for SQL statement
	 * @param bool $ignoreErrors Whether to ignore database errors
	 * @return bool|int
	 * @throws DBError|Exception
	 */
	public function recache( $limit, $ignoreErrors = true ) {
		if ( !$this->isCacheable() ) {
			return 0;
		}

		$fname = get_class( $this ) . '::recache';
		$dbw = $this->dbProvider->getPrimaryDatabase();

		try {
			// Do query
			$res = $this->reallyDoQuery( $limit, false );
			$num = false;
			if ( $res ) {
				$num = $res->numRows();
				// Fetch results
				$vals = [];
				foreach ( $res as $row ) {
					if ( isset( $row->value ) ) {
						if ( $this->usesTimestamps() ) {
							$value = wfTimestamp( TS_UNIX, $row->value );
						} else {
							$value = intval( $row->value );
						}
					} else {
						$value = 0;
					}

					$vals[] = [
						'qcc_type' => $this->getName(),
						'qcc_value' => $value,
						'qcc_namespace' => $row->namespace,
						'qcc_title' => $row->title,
						'qcc_namespacetwo' => $row->to_namespace,
						'qcc_titletwo' => $row->to_title,
					];
				}

				$dbw->startAtomic( __METHOD__ );
				// Clear out any old cached data
				$dbw->newDeleteQueryBuilder()
					->deleteFrom( 'querycachetwo' )
					->where( [ 'qcc_type' => $this->getName() ] )
					->caller( $fname )
					->execute();
				// Save results into the querycachetwo table on the master
				if ( count( $vals ) ) {
					$dbw->newInsertQueryBuilder()
						->insertInto( 'querycachetwo' )
						->rows( $vals )
						->caller( $fname )
						->execute();
				}
				// Update the querycache_info record for the page
				$dbw->newDeleteQueryBuilder()
					->deleteFrom( 'querycache_info' )
					->where( [ 'qci_type' => $this->getName() ] )
					->caller( $fname )
					->execute();
				$dbw->newInsertQueryBuilder()
					->insertInto( 'querycache_info' )
					->row( [ 'qci_type' => $this->getName(), 'qci_timestamp' => $dbw->timestamp() ] )
					->caller( $fname )
					->execute();
				$dbw->endAtomic( __METHOD__ );
			}
		} catch ( DBError $e ) {
			if ( !$ignoreErrors ) {
				// Report query error
				throw $e;
			}
			// Set result to false to indicate error
			$num = false;
		}

		return $num;
	}

	/**
	 * @param string|null $par
	 */
	public function execute( $par ) {
		$this->addHelpLink( 'Extension:Disambiguator' );
		parent::execute( $par );
	}

	/**
	 * Fetch the query results from the query cache
	 *
	 * @param int|bool $limit Numerical limit or false for no limit
	 * @param int|bool $offset Numerical offset or false for no offset
	 * @return IResultWrapper
	 */
	public function fetchFromCache( $limit, $offset = false ) {
		$dbr = $this->dbProvider->getReplicaDatabase();

		$queryBuilder = $dbr->newSelectQueryBuilder()
			->select( [
				'value' => 'qcc_value',
				'namespace' => 'qcc_namespace',
				'title' => 'qcc_title',
				'to_namespace' => 'qcc_namespacetwo',
				'to_title' => 'qcc_titletwo',
			] )
			->from( 'querycachetwo' )
			->where( [ 'qcc_type' => $this->getName() ] )
			->caller( __METHOD__ );

		if ( $limit !== false ) {
			$queryBuilder->limit( intval( $limit ) );
		}
		if ( $offset !== false ) {
			$queryBuilder->offset( intval( $offset ) );
		}
		// Set sort order. This should match the ordering in getOrderFields().
		$queryBuilder->orderBy( [ 'qcc_value', 'qcc_namespacetwo' ] );
		if ( $this->sortDescending() ) {
			$queryBuilder->orderBy( 'qcc_titletwo', SelectQueryBuilder::SORT_DESC );
		} else {
			$queryBuilder->orderBy( 'qcc_titletwo', SelectQueryBuilder::SORT_ASC );
		}

		return $queryBuilder->fetchResultSet();
	}

	/**
	 * Cache page content model for performance
	 *
	 * @param IDatabase $db
	 * @param IResultWrapper $res
	 */
	public function preprocessResults( $db, $res ) {
		if ( !$res->numRows() ) {
			return;
		}

		$batch = $this->linkBatchFactory->newLinkBatch();
		foreach ( $res as $row ) {
			$batch->add( $row->namespace, $row->title );
			$batch->add( $row->to_namespace, $row->to_title );
		}
		$batch->execute();

		$res->seek( 0 );
	}
}
