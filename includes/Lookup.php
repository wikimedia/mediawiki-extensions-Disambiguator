<?php

namespace MediaWiki\Extension\Disambiguator;

use MediaWiki\Output\OutputPage;
use MediaWiki\Title\Title;
use Wikimedia\Rdbms\IConnectionProvider;

class Lookup {

	/**
	 * Name if the page property in the page_props table.
	 *
	 * @internal Please use {@link isMarkedAsDisambiguationPage} if possible
	 */
	public const string DISAMBIGUATION_PROP = 'disambiguation';

	public function __construct(
		private readonly IConnectionProvider $dbProvider,
	) {
	}

	/**
	 * Convenience function for testing if a page is marked as being a disambiguation page via the
	 * __DISAMBIG__ magic word.
	 *
	 * Warning: Don't call this too early as it won't work before the OutputPageParserOutput hook.
	 * It's available in hook handlers like OutputPageBeforeHTML, BeforePageDisplay,
	 * SkinAfterContent, and AfterFinalPageOutput.
	 */
	public static function isMarkedAsDisambiguationPage( OutputPage $outputPage ): bool {
		return $outputPage->getProperty( self::DISAMBIGUATION_PROP ) !== null;
	}

	/**
	 * Convenience function for testing whether or not a page is a disambiguation page
	 *
	 * Warning: This considers redirects at the cost of being more expensive. Prefer
	 * {@link isMarkedAsDisambiguationPage} if possible.
	 */
	public function isDisambiguationPage( Title $title ): bool {
		return (bool)$this->filterDisambiguationPageIds( [ $title->getArticleID() ] );
	}

	/**
	 * Convenience function for testing whether or not pages are disambiguation pages
	 *
	 * @param int[] $pageIds
	 * @return int[] The page ids corresponding to pages that are disambiguations
	 */
	public function filterDisambiguationPageIds( array $pageIds ) {
		// Don't needlessly check non-existent and special pages
		$pageIds = array_filter(
			$pageIds,
			static function ( $id ) {
				return $id > 0;
			}
		);

		$output = [];
		if ( $pageIds ) {
			$dbr = $this->dbProvider->getReplicaDatabase();

			$redirects = [];
			/** @var array<int,int[]> $redirectsMap */
			$redirectsMap = [];
			// resolve redirects
			$res = $dbr->newSelectQueryBuilder()
				->select( [ 'page_id', 'rd_from' ] )
				->from( 'page' )
				->join( 'redirect', null, [
					'rd_namespace=page_namespace',
					'rd_title=page_title',
					'rd_interwiki' => '',
				] )
				->where( [ 'rd_from' => $pageIds ] )
				->caller( __METHOD__ )
				->fetchResultSet();
			foreach ( $res as $row ) {
				$redirects[] = $row->rd_from;
				// Key is the destination page ID, values are the source page IDs
				$redirectsMap[$row->page_id][] = $row->rd_from;
			}

			$pageIdsWithRedirects = array_merge( array_keys( $redirectsMap ),
				array_diff( $pageIds, $redirects ) );
			$res = $dbr->newSelectQueryBuilder()
				->select( 'pp_page' )
				->from( 'page_props' )
				->where( [ 'pp_page' => $pageIdsWithRedirects, 'pp_propname' => self::DISAMBIGUATION_PROP ] )
				->caller( __METHOD__ )
				->fetchResultSet();

			foreach ( $res as $row ) {
				$disambiguationPageId = $row->pp_page;
				if ( array_key_exists( $disambiguationPageId, $redirectsMap ) ) {
					$output = array_merge( $output, $redirectsMap[$disambiguationPageId] );
				}
				if ( in_array( $disambiguationPageId, $pageIds ) ) {
					$output[] = $disambiguationPageId;
				}
			}
		}

		return $output;
	}
}
