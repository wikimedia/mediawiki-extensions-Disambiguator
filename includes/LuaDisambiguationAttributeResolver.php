<?php

namespace MediaWiki\Extension\Disambiguator;

use MediaWiki\Extension\Scribunto\Engines\LuaCommon\TitleAttributeResolver;
use MediaWiki\Linker\LinkTarget;
use MediaWiki\Title\Title;

class LuaDisambiguationAttributeResolver extends TitleAttributeResolver {

	public function __construct(
		private readonly Lookup $lookup,
	) {
	}

	/**
	 * @param LinkTarget $target
	 * @return bool
	 */
	public function resolve( LinkTarget $target ) {
		$title = Title::newFromLinkTarget( $target );
		if ( !$title->canExist() ) {
			return false;
		}
		$this->incrementExpensiveFunctionCount();
		$this->addTemplateLink( $title );

		return $this->lookup->isDisambiguationPage( $title );
	}
}
