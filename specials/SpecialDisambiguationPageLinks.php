<?php
/**
 * DisambiguationPageLinks SpecialPage for Disambiguator extension
 * This page lists all pages that link to disambiguation pages.
 *
 * @file
 * @ingroup Extensions
 */

class SpecialDisambiguationPageLinks extends QueryPage {

	/**
	 * Initialize the special page.
	 */
	public function __construct() {
		parent::__construct( 'DisambiguationPageLinks' );
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
				'p1' => 'page',
				'p2' => 'page',
				'pagelinks',
				'page_props'
			),
			'fields' => array(
				'value' => 'pl_from',
				'namespace' => 'p2.page_namespace',
				'title' => 'p2.page_title',
				'to_id' => 'pp_page',
				'to_namespace' => 'p1.page_namespace',
				'to_title' => 'p1.page_title',
			),
			'conds' => array(
				'p1.page_id = pp_page',
				'pp_propname' => 'disambiguation',
				'pl_namespace = p1.page_namespace',
				'pl_title = p1.page_title',
				'p2.page_id = pl_from',
				'p2.page_namespace' => MWNamespace::getContentNamespaces()
			)
		);
	}

	/**
	 * Order the results by namespace, title, and ID of linked page (to_id).
	 * @return array
	 */
	function getOrderFields() {
		return array( 'namespace', 'title', 'to_id' );
	}

	function sortDescending() {
		return false;
	}

	function formatResult( $skin, $result ) {
		$fromTitle = Title::newFromID( $result->value );
		$toTitle = Title::newFromID( $result->to_id );

		$from = Linker::linkKnown( $fromTitle );
		$edit = Linker::link(
			$fromTitle,
			$this->msg( 'parentheses', $this->msg( 'editlink' )->text() )->escaped(),
			array(),
			array( 'redirect' => 'no', 'action' => 'edit' )
		);
		$arr = $this->getLanguage()->getArrow();
		$to = Linker::linkKnown( $toTitle );

		return "$from $edit $arr $to";
	}

	protected function getGroupName() {
		return 'pages';
	}
}
