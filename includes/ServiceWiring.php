<?php

use MediaWiki\Extension\Disambiguator\Lookup;
use MediaWiki\MediaWikiServices;

// PHP unit does not understand code coverage for this file
// as the @covers annotation cannot cover a specific file
// This is fully tested in ServiceWiringTest.php
// @codeCoverageIgnoreStart

return [
	'DisambiguatorLookup' => static function ( MediaWikiServices $services ): Lookup {
		return new Lookup(
			$services->getConnectionProvider()
		);
	}
];

// @codeCoverageIgnoreEnd
