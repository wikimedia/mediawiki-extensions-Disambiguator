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
		wfProfileIn( __METHOD__ );
		// Exclude disambiguation templates
		if ( $title->getNamespace() === NS_TEMPLATE ) {
			wfProfileOut( __METHOD__ );
			return false;
		}
		$pageId = $title->getArticleID();
		if ( $pageId ) {
			$dbr = wfGetDB( DB_SLAVE );
			$isDisambiguationPage = $dbr->selectField(
				'page_props',
				'pp_propname',
				array( 'pp_page' => $pageId, 'pp_propname' => 'disambiguation' )
			);
			if ( $isDisambiguationPage ) {
				wfProfileOut( __METHOD__ );
				return true;
			}
		}
		wfProfileOut( __METHOD__ );
		return false;
	}
}
