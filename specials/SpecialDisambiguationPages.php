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
		return false;
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
				'value' => 'page_props.pp_page',
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
	 * Order the results by page ID.
	 * We don't sort by namespace and title since this would trigger a filesort.
	 * @return array
	 */
	function getOrderFields() {
		return array( 'value' );
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
