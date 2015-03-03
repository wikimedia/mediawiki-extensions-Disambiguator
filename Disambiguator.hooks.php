<?php
/**
 * Hooks for Disambiguator extension
 *
 * @file
 * @ingroup Extensions
 */

class DisambiguatorHooks {
	/**
	 * @param array &$doubleUnderscoreIDs
	 * @return bool
	 */
	public static function onGetDoubleUnderscoreIDs( &$doubleUnderscoreIDs ) {
		$doubleUnderscoreIDs[] = 'disambiguation';
		return true;
	}

	/**
	 * Add the Disambiguator special pages to the list of QueryPages. This
	 * allows direct access via the API.
	 * @param array &$queryPages
	 * @return bool
	 */
	public static function onwgQueryPages( &$queryPages ) {
		$queryPages[] = array( 'SpecialDisambiguationPages', 'DisambiguationPages' );
		$queryPages[] = array( 'SpecialDisambiguationPageLinks', 'DisambiguationPageLinks' );
		return true;
	}

	/**
	 * Modify the Special:LonelyPages query to ignore disambiguation pages
	 * @param array &$tables
	 * @param array &$conds
	 * @param array &$joinConds
	 * @return bool
	 */
	public static function onLonelyPagesQuery( &$tables, &$conds, &$joinConds ) {
		$tables[] = 'page_props';
		$conds['pp_page'] = null;
		$joinConds['page_props'] = array(
			'LEFT JOIN', array( 'page_id = pp_page', 'pp_propname' => 'disambiguation' )
		);
		return true;
	}

	/**
	 * Convenience function for testing whether or not a page is a disambiguation page
	 * @param Title $title object of a page
	 * @return bool
	 */
	public static function isDisambiguationPage( Title $title ) {
		$res = static::filterDisambiguationPageIds( array( $title->getArticleID() ) );
		return (bool)count( $res );
	}

	/**
	 * Convenience function for testing whether or not pages are disambiguation pages
	 * @param int[] $pageIds
	 * @return int[] The page ids corresponding to pages that are disambiguations
	 */
	private static function filterDisambiguationPageIds( array $pageIds ) {
		// Don't needlessly check non-existent and special pages
		$pageIds = array_filter( $pageIds, function ( $id ) { return $id > 0; } );

		$output = array();
		if ( $pageIds ) {
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				'page_props',
				'pp_page',
				array( 'pp_page' => $pageIds, 'pp_propname' => 'disambiguation' ),
				__METHOD__
			);

			foreach ( $res as $row ) {
				$output[] = $row->pp_page;
			}
		}

		return $output;
	}

	/**
	 * Add 'mw-disambig' CSS class to links to disambiguation pages.
	 * @param array $pageIdToDbKey Prefixed DB keys of the pages linked to, indexed by page_id
	 * @param array $colours CSS classes, indexed by prefixed DB keys
	 * @return bool true
	 */
	public static function onGetLinkColours( $pageIdToDbKey, &$colours ) {
		global $wgDisambiguatorIndicateLinks;
		if ( !$wgDisambiguatorIndicateLinks ) {
			return true;
		}

		$pageIds = static::filterDisambiguationPageIds( array_keys( $pageIdToDbKey ) );
		foreach ( $pageIds as $pageId ) {
			$colours[ $pageIdToDbKey[$pageId] ] = 'mw-disambig';
		}
		return true;
	}

	/**
	 * If VE is enabled, add our module so we can add a Disambiguation checkbox to the page settings dialog.
	 * @return bool
	 */
	public static function onSetupAfterCache() {
		if ( ExtensionRegistry::getInstance()->isLoaded( 'Disambiguator' ) ) {
			// Plugin already registered as an attribute
			return true;
		}
		global $wgVisualEditorPluginModules;
		if ( is_array( $wgVisualEditorPluginModules ) ) {
			$wgVisualEditorPluginModules[] = 'ext.disambiguator.visualEditor';
		}
		return true;
	}
}
