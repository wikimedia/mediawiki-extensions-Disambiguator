<?php
/**
 * DisambiguationPages SpecialPage for Disambiguator extension
 * This page lists all the disambiguation pages
 *
 * @file
 * @ingroup Extensions
 */

class SpecialDisambiguationPages extends QueryPage {

	/**
	 * Initialize the special page.
	 */
	public function __construct() {
		parent::__construct( 'DisambiguationPages' );
	}

	public function isExpensive() {
		return false;
	}

	public function isSyndicated() {
		return false;
	}

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

	public function formatResult( $skin, $result ) {
		$title = Title::newFromID( $result->value );
		return $this->getLinkRenderer()->makeKnownLink( $title );
	}

	protected function getGroupName() {
		return 'pages';
	}
}
