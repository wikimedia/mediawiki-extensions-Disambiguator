<?php
/**
 * DisambiguationPages SpecialPage for Disambiguator extension
 * This page lists all the disambiguation pages
 *
 * @file
 * @ingroup Extensions
 */

namespace MediaWiki\Extension\Disambiguator\Specials;

use MediaWiki\Cache\LinkBatchFactory;
use QueryPage;
use Title;
use Wikimedia\Rdbms\IDatabase;
use Wikimedia\Rdbms\ILoadBalancer;
use Wikimedia\Rdbms\IResultWrapper;

class SpecialDisambiguationPages extends QueryPage {

	/**
	 * @param LinkBatchFactory $linkBatchFactory
	 * @param ILoadBalancer $loadBalancer
	 */
	public function __construct(
		LinkBatchFactory $linkBatchFactory,
		ILoadBalancer $loadBalancer
	) {
		parent::__construct( 'DisambiguationPages' );
		$this->setLinkBatchFactory( $linkBatchFactory );
		$this->setDBLoadBalancer( $loadBalancer );
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

	public function execute( $par ) {
		$this->addHelpLink( 'Extension:Disambiguator' );
		parent::execute( $par );
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

	/**
	 * @param IDatabase $db
	 * @param IResultWrapper $res
	 */
	public function preprocessResults( $db, $res ) {
		$this->executeLBFromResultWrapper( $res );
	}

	public function formatResult( $skin, $result ) {
		$title = Title::makeTitle( $result->namespace, $result->title );
		return $this->getLinkRenderer()->makeKnownLink( $title );
	}

	protected function getGroupName() {
		return 'pages';
	}
}
