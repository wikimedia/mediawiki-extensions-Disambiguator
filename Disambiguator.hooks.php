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
}
