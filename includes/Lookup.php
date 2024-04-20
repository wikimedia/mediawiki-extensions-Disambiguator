<?php

namespace MediaWiki\Extension\Disambiguator;

use MediaWiki\Title\Title;
use Wikimedia\Rdbms\IConnectionProvider;

class Lookup {

	private IConnectionProvider $dbProvider;

	/**
	 * @param IConnectionProvider $dbProvider
	 */
	public function __construct( IConnectionProvider $dbProvider ) {
		$this->dbProvider = $dbProvider;
	}

	/**
	 * Convenience function for testing whether or not a page is a disambiguation page
	 *
	 * @param Title $title object of a page
	 * @param bool $includeRedirects Whether to consider redirects to disambiguations as
	 *   disambiguations.
	 * @return bool
	 */
	public function isDisambiguationPage( Title $title, $includeRedirects = true ) {
		$res = $this->filterDisambiguationPageIds(
			[ $title->getArticleID() ], $includeRedirects );
		return (bool)count( $res );
	}

	/**
	 * Convenience function for testing whether or not pages are disambiguation pages
	 *
	 * @param int[] $pageIds
	 * @param bool $includeRedirects Whether to consider redirects to disambiguations as
	 *   disambiguations.
	 * @return int[] The page ids corresponding to pages that are disambiguations
	 */
	public function filterDisambiguationPageIds(
		array $pageIds, $includeRedirects = true
	) {
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
			$redirectsMap = [];
			if ( $includeRedirects ) {
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
			}
			$pageIdsWithRedirects = array_merge( array_keys( $redirectsMap ),
				array_diff( $pageIds, $redirects ) );
			$res = $dbr->newSelectQueryBuilder()
				->select( 'pp_page' )
				->from( 'page_props' )
				->where( [ 'pp_page' => $pageIdsWithRedirects, 'pp_propname' => 'disambiguation' ] )
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
