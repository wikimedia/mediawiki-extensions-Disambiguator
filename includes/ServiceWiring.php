<?php

use MediaWiki\Extension\Disambiguator\Lookup;

return [
	'DisambiguatorLookup' => static function () {
		return new Lookup();
	}
];
