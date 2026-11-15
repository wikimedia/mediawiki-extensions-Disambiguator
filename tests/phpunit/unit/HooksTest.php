<?php

namespace MediaWiki\Extension\Disambiguator\Tests\Unit;

use MediaWiki\Config\HashConfig;
use MediaWiki\EditPage\EditPage;
use MediaWiki\Extension\Disambiguator\Hooks;
use MediaWiki\Extension\Disambiguator\Lookup;
use MediaWiki\Output\OutputPage;
use MediaWiki\Page\PageStore;
use MediaWikiUnitTestCase;
use MobileContext;

/**
 * @covers \MediaWiki\Extension\Disambiguator\Hooks
 * @group Disambiguator
 */
class HooksTest extends MediaWikiUnitTestCase {

	private function newHooks( ?MobileContext $mobileContext, bool $notifications = true ): Hooks {
		return new Hooks(
			$this->createMock( Lookup::class ),
			new HashConfig( [ 'DisambiguatorNotifications' => $notifications ] ),
			$this->createMock( PageStore::class ),
			$mobileContext
		);
	}

	private function newEditPage( string $contentModel = CONTENT_MODEL_WIKITEXT ): EditPage {
		$editor = $this->createMock( EditPage::class );
		$editor->contentModel = $contentModel;
		return $editor;
	}

	private function newOutputPage( bool $expectModule ): OutputPage {
		$out = $this->createMock( OutputPage::class );
		$out->expects( $expectModule ? $this->once() : $this->never() )
			->method( 'addModules' )
			->with( 'ext.disambiguator' );
		return $out;
	}

	private function newMobileContext( bool $isMobileView ): MobileContext {
		if ( !class_exists( MobileContext::class ) ) {
			$this->markTestSkipped( 'MobileFrontend is not installed' );
		}
		$context = $this->createMock( MobileContext::class );
		$context->method( 'shouldDisplayMobileView' )->willReturn( $isMobileView );
		return $context;
	}

	public function testEditFormAddsModuleWithoutMobileFrontend() {
		$this->newHooks( null )->onEditPage__showEditForm_initial(
			$this->newEditPage(),
			$this->newOutputPage( true )
		);
	}

	public function testEditFormAddsModuleOnDesktop() {
		$this->newHooks( $this->newMobileContext( false ) )->onEditPage__showEditForm_initial(
			$this->newEditPage(),
			$this->newOutputPage( true )
		);
	}

	public function testEditFormSkipsModuleOnMobile() {
		$this->newHooks( $this->newMobileContext( true ) )->onEditPage__showEditForm_initial(
			$this->newEditPage(),
			$this->newOutputPage( false )
		);
	}

	public function testEditFormSkipsModuleWhenNotificationsDisabled() {
		$this->newHooks( null, false )->onEditPage__showEditForm_initial(
			$this->newEditPage(),
			$this->newOutputPage( false )
		);
	}

	public function testEditFormSkipsModuleForNonWikitext() {
		$this->newHooks( null )->onEditPage__showEditForm_initial(
			$this->newEditPage( CONTENT_MODEL_JSON ),
			$this->newOutputPage( false )
		);
	}
}
