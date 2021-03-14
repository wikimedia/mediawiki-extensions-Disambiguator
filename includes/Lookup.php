<?php

namespace MediaWiki\Extension\Disambiguator;

use Title;

class Lookup {
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
			$dbr = wfGetDB( DB_REPLICA );

			$redirects = [];
			if ( $includeRedirects ) {
				// resolve redirects
				$res = $dbr->select(
					[ 'page', 'redirect' ],
					[ 'page_id', 'rd_from' ],
					[ 'rd_from' => $pageIds ],
					__METHOD__,
					[],
					[ 'page' => [ 'INNER JOIN', [
						'rd_namespace=page_namespace',
						'rd_title=page_title'
					] ] ]
				);

				foreach ( $res as $row ) {
					// Key is the destination page ID, value is the source page ID
					$redirects[$row->page_id] = $row->rd_from;
				}
			}
			$pageIdsWithRedirects = array_merge( array_keys( $redirects ),
				array_diff( $pageIds, array_values( $redirects ) ) );
			$res = $dbr->select(
				'page_props',
				'pp_page',
				[ 'pp_page' => $pageIdsWithRedirects, 'pp_propname' => 'disambiguation' ],
				__METHOD__
			);

			foreach ( $res as $row ) {
				$disambiguationPageId = $row->pp_page;
				if ( array_key_exists( $disambiguationPageId, $redirects ) ) {
					$output[] = $redirects[$disambiguationPageId];
				}
				if ( in_array( $disambiguationPageId, $pageIds ) ) {
					$output[] = $disambiguationPageId;
				}
			}
		}

		return $output;
	}
}
