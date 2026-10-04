<?php

namespace MediaWiki\Extension\Disambiguator\Tests;

use MediaWiki\Extension\Disambiguator\Lookup;
use MediaWiki\Interwiki\ClassicInterwikiLookup;
use MediaWiki\Output\OutputPage;
use MediaWiki\Title\Title;
use MediaWikiIntegrationTestCase;
use Wikimedia\Rdbms\IConnectionProvider;

/**
 * @covers \MediaWiki\Extension\Disambiguator\Lookup
 * @group Database
 * @group Disambiguator
 */
class LookupTest extends MediaWikiIntegrationTestCase {

	private const PAGES = [
		'Disambig' => '__DISAMBIG__',
		'Normal' => 'Example text {{DEFAULTSORT:Unrelated page prop}}',
		'Redirect' => '#REDIRECT [[Disambig]]',
		'Other redirect' => '#REDIRECT [[Disambig]]',
		'Normal redirect' => '#REDIRECT [[Normal]]',
		'Broken redirect' => '#REDIRECT [[Missing]]',
		'Interwiki redirect' => '#REDIRECT [[otherwiki:Disambig]]',
		'Template:Normal' => '__DISAMBIG__',
		'Namespaced redirect' => '#REDIRECT [[Template:Normal]]',
	];

	protected function setUp(): void {
		parent::setUp();
		$this->overrideConfigValues( [
			'InterwikiScopes' => 2,
			'InterwikiCache' => ClassicInterwikiLookup::buildCdbHash( [ [
				'iw_prefix' => 'otherwiki',
				'iw_url' => 'https://example.org/wiki/$1',
				'iw_local' => 0,
			] ], 2 ),
		] );
	}

	public function addDBDataOnce() {
		foreach ( self::PAGES as $title => $text ) {
			$this->insertPage( $title, $text );
		}
	}

	private function newLookup(): Lookup {
		return new Lookup( $this->getServiceContainer()->getConnectionProvider() );
	}

	private function getPageIds( array $names ): array {
		return array_map(
			fn ( $name ) => $this->getExistingTestPage( $name )->getId(),
			$names
		);
	}

	/** @dataProvider provideFilterDisambiguationPageIds */
	public function testFilterDisambiguationPageIds( array $input, array $expected ) {
		$this->assertEqualsCanonicalizing(
			$this->getPageIds( $expected ),
			$this->newLookup()->filterDisambiguationPageIds( $this->getPageIds( $input ) )
		);
	}

	public static function provideFilterDisambiguationPageIds() {
		yield 'filter out non-disambiguation pages' => [
			[ 'Disambig', 'Normal' ],
			[ 'Disambig' ]
		];
		yield 'redirect returns source ID' => [
			[ 'Redirect', 'Normal' ],
			[ 'Redirect' ]
		];
		yield 'redirect to ordinary page' => [
			[ 'Normal redirect' ],
			[]
		];
		yield 'broken redirect' => [
			[ 'Broken redirect' ],
			[]
		];
		yield 'interwiki target must not match local page' => [
			[ 'Interwiki redirect' ],
			[]
		];
		yield 'target namespace is respected' => [
			[ 'Namespaced redirect' ],
			[ 'Namespaced redirect' ]
		];
		yield 'multiple redirects to one target' => [
			[ 'Redirect', 'Other redirect' ],
			[ 'Redirect', 'Other redirect' ]
		];
		yield 'disambig and redirect to non-dismabig page' => [
			[ 'Disambig', 'Normal redirect' ],
			[ 'Disambig' ],
		];
		yield 'source and target both requested' => [
			[ 'Redirect', 'Disambig' ],
			[ 'Redirect', 'Disambig' ]
		];
		yield 'duplicate input' => [
			[ 'Disambig', 'Disambig' ],
			[ 'Disambig' ]
		];
		yield 'mixed batch' => [
			array_keys( self::PAGES ),
			[ 'Disambig', 'Redirect', 'Other redirect', 'Template:Normal', 'Namespaced redirect' ]
		];
	}

	/** @dataProvider provideInvalidPageIds */
	public function testInvalidPageIdsDoNotAccessDatabase( array $ids ) {
		$provider = $this->createNoOpMock( IConnectionProvider::class );
		$this->assertSame( [], ( new Lookup( $provider ) )->filterDisambiguationPageIds( $ids ) );
	}

	public static function provideInvalidPageIds() {
		yield 'empty' => [ [] ];
		yield 'nonexistent and special pages' => [ [ 0, -1 ] ];
	}

	/** @dataProvider provideIsDisambiguationPage */
	public function testIsDisambiguationPage( string $title, bool $expected ) {
		$this->assertSame( $expected, $this->newLookup()->isDisambiguationPage( Title::newFromText( $title ) ) );
	}

	public static function provideIsDisambiguationPage() {
		yield 'disambiguation' => [ 'Disambig', true ];
		yield 'ordinary page' => [ 'Normal', false ];
		yield 'redirect' => [ 'Redirect', true ];
		yield 'missing page' => [ 'Missing', false ];
		yield 'special page' => [ 'Special:Version', false ];
	}

	/** @dataProvider provideIsMarkedAsDisambiguationPage */
	public function testIsMarkedAsDisambiguationPage( $value, bool $expected ) {
		$output = $this->createMock( OutputPage::class );
		$output->method( 'getProperty' )->with( Lookup::DISAMBIGUATION_PROP )->willReturn( $value );
		$this->assertSame( $expected, Lookup::isMarkedAsDisambiguationPage( $output ) );
	}

	public static function provideIsMarkedAsDisambiguationPage() {
		yield 'absent' => [ null, false ];
		yield 'empty value' => [ '', true ];
		yield 'nonempty value' => [ '1', true ];
	}
}
