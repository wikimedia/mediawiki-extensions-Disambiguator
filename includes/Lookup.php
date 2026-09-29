<?php

namespace MediaWiki\Extension\Disambiguator;

use MediaWiki\Output\OutputPage;
use MediaWiki\Title\Title;
use Wikimedia\Rdbms\IConnectionProvider;

class Lookup {

	/**
	 * Name of the page property in the page_props table.
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

		if ( !$pageIds ) {
			return [];
		}

		$dbr = $this->dbProvider->getReplicaDatabase();

		// resolve redirects as well
		return $dbr->newSelectQueryBuilder()
			->select( 'page.page_id' )
			->from( 'page' )
			// JOIN with redirect to check if any given page ids are redirects
			->leftJoin( 'redirect', null, [
				'rd_from = page.page_id',
				'rd_interwiki' => '',
			] )
			// JOIN with page to find page ids of redirect targets
			->leftJoin( 'page', 'redirect_target', [
				'redirect_target.page_namespace = rd_namespace',
				'redirect_target.page_title = rd_title'
			] )
			// JOIN with page_props on page id of the redirect target or the page itself
			->join( 'page_props', null, [
				'pp_page = COALESCE(redirect_target.page_id, page.page_id)',
				'pp_propname' => self::DISAMBIGUATION_PROP
			] )
			->where( [ 'page.page_id' => $pageIds ] )
			->caller( __METHOD__ )
			->fetchFieldValues();
	}
}
