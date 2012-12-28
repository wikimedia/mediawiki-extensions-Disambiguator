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

	function isExpensive() {
		return true;
	}

	function isSyndicated() {
		return false;
	}

	function getQueryInfo() {
		return array (
			'tables' => array(
				'page',
				'page_props'
			),
			'fields' => array(
				'value' => 'page.page_id',
				'namespace' => 'page.page_namespace',
				'title' => 'page.page_title',
			),
			'conds' => array(
				'page_id = pp_page',
				'pp_propname' => 'disambiguation',
				// Exclude disambiguation templates
				'page_namespace != ' . NS_TEMPLATE
			)
		);
	}

	/**
	 * Order the results by namespace and title.
	 * @return array
	 */
	function getOrderFields() {
		return array( 'namespace', 'title' );
	}

	function sortDescending() {
		return false;
	}

	function formatResult( $skin, $result ) {
		$title = Title::newFromID( $result->value );
		$link = Linker::linkKnown( $title );
		return $link;
	}

	protected function getGroupName() {
		return 'pages';
	}
}
