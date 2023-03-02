<?php

use MediaWiki\Extension\Disambiguator\Lookup;

// PHP unit does not understand code coverage for this file
// as the @covers annotation cannot cover a specific file
// This is fully tested in ServiceWiringTest.php
// @codeCoverageIgnoreStart

return [
	'DisambiguatorLookup' => static function () {
		return new Lookup();
	}
];

// @codeCoverageIgnoreEnd
