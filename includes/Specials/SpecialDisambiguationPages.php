<?php
/**
 * DisambiguationPages SpecialPage for Disambiguator extension
 * This page lists all the disambiguation pages
 *
 * @file
 * @ingroup Extensions
 */

namespace MediaWiki\Extension\Disambiguator\Specials;

use MediaWiki\Cache\LinkBatchFactory;
use MediaWiki\SpecialPage\QueryPage;
use MediaWiki\Title\Title;
use Wikimedia\Rdbms\IConnectionProvider;
use Wikimedia\Rdbms\IDatabase;
use Wikimedia\Rdbms\IResultWrapper;

class SpecialDisambiguationPages extends QueryPage {

	/**
	 * @param LinkBatchFactory $linkBatchFactory
	 * @param IConnectionProvider $dbProvider
	 */
	public function __construct(
		LinkBatchFactory $linkBatchFactory,
		IConnectionProvider $dbProvider
	) {
		parent::__construct( 'DisambiguationPages' );
		$this->setLinkBatchFactory( $linkBatchFactory );
		$this->setDatabaseProvider( $dbProvider );
	}

	public function isExpensive(): bool {
		return false;
	}

	public function isSyndicated(): bool {
		return false;
	}

	/** @inheritDoc */
	public function getQueryInfo() {
		return [
			'tables' => [
				'page',
				'page_props'
			],
			'fields' => [
				'value' => 'pp_page',
				'namespace' => 'page_namespace',
				'title' => 'page_title',
			],
			'conds' => [
				'page_id = pp_page',
				'pp_propname' => 'disambiguation',
			]
		];
	}

	/**
	 * @param string|null $par
	 */
	public function execute( $par ) {
		$this->addHelpLink( 'Extension:Disambiguator' );
		parent::execute( $par );
	}

	/**
	 * Order the results by page ID.
	 * We don't sort by namespace and title since this would trigger a filesort.
	 * @return array
	 */
	public function getOrderFields() {
		return [ 'value' ];
	}

	public function sortDescending() {
		return false;
	}

	/**
	 * @param IDatabase $db
	 * @param IResultWrapper $res
	 */
	public function preprocessResults( $db, $res ) {
		$this->executeLBFromResultWrapper( $res );
	}

	/** @inheritDoc */
	public function formatResult( $skin, $result ) {
		$title = Title::makeTitle( $result->namespace, $result->title );
		return $this->getLinkRenderer()->makeKnownLink( $title );
	}

	/** @inheritDoc */
	protected function getGroupName() {
		return 'pages';
	}
}
