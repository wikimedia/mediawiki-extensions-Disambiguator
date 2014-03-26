<?php
/**
 * Disambiguator extension
 * Enables the designation of disambiguation pages with the __DISAMBIG__
 * magic word. Also provides a Special Page listing all pages that link to
 * disambiguation pages.
 *
 * For more info see http://mediawiki.org/wiki/Extension:Disambiguator
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * This program is distributed WITHOUT ANY WARRANTY.
 *
 * @file
 * @ingroup Extensions
 * @author Ryan Kaldari
 * @license MIT "Expat" License
 */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Disambiguator',
	'author' => array(
		'Ryan Kaldari',
	),
	'version'  => '1.1',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Disambiguator',
	'descriptionmsg' => 'disambig-desc',
);

/* Setup */

$dir = __DIR__;

// Register files
$wgAutoloadClasses['DisambiguatorHooks'] = $dir . '/Disambiguator.hooks.php';
$wgAutoloadClasses['SpecialDisambiguationPages'] = $dir . '/specials/SpecialDisambiguationPages.php';
$wgAutoloadClasses['SpecialDisambiguationPageLinks'] = $dir . '/specials/SpecialDisambiguationPageLinks.php';
$wgMessagesDirs['Disambiguator'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['Disambiguator'] = $dir . '/Disambiguator.i18n.php';
$wgExtensionMessagesFiles['DisambiguatorAlias'] = $dir . '/Disambiguator.i18n.alias.php';
$wgExtensionMessagesFiles['DisambiguatorMagic'] = $dir . '/Disambiguator.i18n.magic.php';

// Register hooks
$wgHooks['GetDoubleUnderscoreIDs'][] = 'DisambiguatorHooks::onGetDoubleUnderscoreIDs';
$wgHooks['wgQueryPages'][] = 'DisambiguatorHooks::onwgQueryPages';
$wgHooks['LonelyPagesQuery'][] = 'DisambiguatorHooks::onLonelyPagesQuery';

// Register special pages
$wgSpecialPages['DisambiguationPages'] = 'SpecialDisambiguationPages';
$wgSpecialPageGroups['DisambiguationPages'] = 'pages';
$wgSpecialPages['DisambiguationPageLinks'] = 'SpecialDisambiguationPageLinks';
$wgSpecialPageGroups['DisambiguationPageLinks'] = 'pages';

/* Configuration */

// TODO: Allow disambiguation links to be assigned a unique class
#$wgDisambiguatorIndicateLinks = true;
