<?php
/**
 * Hooks for Disambiguator extension
 *
 * @file
 * @ingroup Extensions
 */

namespace MediaWiki\Extension\Disambiguator;

use MediaWiki\Extension\Disambiguator\Specials\SpecialDisambiguationPageLinks;
use MediaWiki\Extension\Disambiguator\Specials\SpecialDisambiguationPages;
use MediaWiki\MediaWikiServices;
use Title;

class Hooks {
	/**
	 * @param array &$doubleUnderscoreIDs
	 */
	public static function onGetDoubleUnderscoreIDs( &$doubleUnderscoreIDs ) {
		$doubleUnderscoreIDs[] = 'disambiguation';
	}

	/**
	 * Add the Disambiguator special pages to the list of QueryPages. This
	 * allows direct access via the API.
	 * @param array &$queryPages
	 */
	public static function onwgQueryPages( &$queryPages ) {
		$queryPages[] = [ SpecialDisambiguationPages::class, 'DisambiguationPages' ];
		$queryPages[] = [ SpecialDisambiguationPageLinks::class, 'DisambiguationPageLinks' ];
	}

	/**
	 * Modify query parameters to ignore disambiguation pages
	 * @param array &$tables
	 * @param array &$conds
	 * @param array &$joinConds
	 */
	private static function excludeDisambiguationPages( &$tables, &$conds, &$joinConds ) {
		$tables['disambig_props'] = 'page_props';
		$conds['disambig_props.pp_page'] = null;
		$joinConds['disambig_props'] = [
			'LEFT JOIN', [
				'page_id = disambig_props.pp_page',
				'disambig_props.pp_propname' => 'disambiguation'
			]
		];
	}

	/**
	 * Modify the Special:AncientPages query to ignore disambiguation pages
	 * @param array &$tables
	 * @param array &$conds
	 * @param array &$joinConds
	 */
	public static function onAncientPagesQuery( &$tables, &$conds, &$joinConds ) {
		self::excludeDisambiguationPages( $tables, $conds, $joinConds );
	}

	/**
	 * Modify the Special:LonelyPages query to ignore disambiguation pages
	 * @param array &$tables
	 * @param array &$conds
	 * @param array &$joinConds
	 */
	public static function onLonelyPagesQuery( &$tables, &$conds, &$joinConds ) {
		self::excludeDisambiguationPages( $tables, $conds, $joinConds );
	}

	/**
	 * Modify the Special:ShortPages query to ignore disambiguation pages
	 * @param array &$tables
	 * @param array &$conds
	 * @param array &$joinConds
	 * @param array &$options
	 */
	public static function onShortPagesQuery( &$tables, &$conds, &$joinConds, &$options ) {
		self::excludeDisambiguationPages( $tables, $conds, $joinConds );
	}

	/**
	 * Modify the Special:Random query to ignore disambiguation pages
	 * @param array &$tables
	 * @param array &$conds
	 * @param array &$joinConds
	 */
	public static function onRandomPageQuery( &$tables, &$conds, &$joinConds ) {
		self::excludeDisambiguationPages( $tables, $conds, $joinConds );
	}

	/**
	 * Convenience function for testing whether or not a page is a disambiguation page
	 *
	 * @deprecated Use DisambiguatorLookup service
	 *
	 * @param Title $title object of a page
	 * @param bool $includeRedirects Whether to consider redirects to disambiguations as
	 *   disambiguations.
	 * @return bool
	 */
	public static function isDisambiguationPage( Title $title, $includeRedirects = true ) {
		return MediaWikiServices::getInstance()->getService( 'DisambiguatorLookup' )
			->isDisambiguationPage( $title, $includeRedirects );
	}

	/**
	 * Add 'mw-disambig' CSS class to links to disambiguation pages.
	 * @param array $pageIdToDbKey Prefixed DB keys of the pages linked to, indexed by page_id
	 * @param array &$colours CSS classes, indexed by prefixed DB keys
	 */
	public static function onGetLinkColours( $pageIdToDbKey, &$colours ) {
		global $wgDisambiguatorIndicateLinks;
		if ( !$wgDisambiguatorIndicateLinks ) {
			return;
		}

		$pageIds = MediaWikiServices::getInstance()->getService( 'DisambiguatorLookup' )
			->filterDisambiguationPageIds( array_keys( $pageIdToDbKey ) );

		foreach ( $pageIds as $pageId ) {
			if ( isset( $colours[ $pageIdToDbKey[$pageId] ] ) ) {
				$colours[ $pageIdToDbKey[$pageId] ] .= ' mw-disambig';
			} else {
				$colours[ $pageIdToDbKey[$pageId] ] = 'mw-disambig';
			}
		}
	}
}

class_alias( Hooks::class, 'DisambiguatorHooks' );
