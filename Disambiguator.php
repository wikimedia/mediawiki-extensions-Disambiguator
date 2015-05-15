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

/**
 * This PHP entry point is deprecated. Please use wfLoadExtension() and the extension.json file instead.
 * See https://www.mediawiki.org/wiki/Manual:Extension_registration for more details.
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
	'license-name' => 'MIT',
);

/* Setup */

// Register files
$wgAutoloadClasses['DisambiguatorHooks'] = __DIR__ . '/Disambiguator.hooks.php';
$wgAutoloadClasses['SpecialDisambiguationPages'] = __DIR__ . '/specials/SpecialDisambiguationPages.php';
$wgAutoloadClasses['SpecialDisambiguationPageLinks'] = __DIR__ . '/specials/SpecialDisambiguationPageLinks.php';
$wgMessagesDirs['Disambiguator'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['Disambiguator'] = __DIR__ . '/Disambiguator.i18n.php';
$wgExtensionMessagesFiles['DisambiguatorAlias'] = __DIR__ . '/Disambiguator.i18n.alias.php';
$wgExtensionMessagesFiles['DisambiguatorMagic'] = __DIR__ . '/Disambiguator.i18n.magic.php';

// Register hooks
$wgHooks['GetDoubleUnderscoreIDs'][] = 'DisambiguatorHooks::onGetDoubleUnderscoreIDs';
$wgHooks['wgQueryPages'][] = 'DisambiguatorHooks::onwgQueryPages';
$wgHooks['LonelyPagesQuery'][] = 'DisambiguatorHooks::onLonelyPagesQuery';
$wgHooks['SetupAfterCache'][] = 'DisambiguatorHooks::onSetupAfterCache';
$wgHooks['GetLinkColours'][] = 'DisambiguatorHooks::onGetLinkColours';

// Register special pages
$wgSpecialPages['DisambiguationPages'] = 'SpecialDisambiguationPages';
$wgSpecialPages['DisambiguationPageLinks'] = 'SpecialDisambiguationPageLinks';

$wgResourceModules['ext.disambiguator.visualEditor'] = array(
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'Disambiguator',
	'scripts' => array( 'visualEditorIntegration.js' ),
	'messages' => array( 'visualeditor-dialog-meta-settings-disambiguation-label' ),
	'dependencies' => array( 'ext.visualEditor.mwmeta', 'ext.visualEditor.mediawiki' ),
	'targets' => array( 'desktop', 'mobile' )
);

/* Configuration */

// Whether to add a 'mw-disambig' CSS class to links to disambiguation pages
$wgDisambiguatorIndicateLinks = true;
