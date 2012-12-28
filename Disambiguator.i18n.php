<?php
/**
 * Internationalisation file for the Disambiguator extension
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 */
$messages['en'] = array(
	'disambig-desc' => 'Adds the tag <code><nowiki>__DISAMBIG__</nowiki></code> to mark [[Special:DisambiguationPages|disambiguation pages]].',
	# Special:DisambiguationPages
	'disambiguationpages' => 'Disambiguation pages',
	'disambiguationpages-summary' => "The following is a list of all disambiguation pages on {{SITENAME}}.<br />
A page is treated as a disambiguation page if the page contains the tag <code><nowiki>__DISAMBIG__</nowiki></code> (or an equivalent alias).",
	# Special:DisambiguationPageLinks
	'disambiguationpagelinks' => 'Pages linking to disambiguation pages',
	'disambiguationpagelinks-summary'  => "The following pages contain at least one link to a disambiguation page.
They may need to link to a more appropriate page instead.<br />
A page is treated as a disambiguation page if the page contains the tag <code><nowiki>__DISAMBIG__</nowiki></code> (or an equivalent alias).",
);

/** Message documentation (Message documentation)
 */
$messages['qqq'] = array(
	'disambig-desc' => '{{desc}}',
	'disambiguationpages' => 'Title of the Special Page that shows all disambiguation pages',
	'disambiguationpages-summary'  => 'Header text explaining the purpose of the Special:DisambiguationPages page. It is not necessary to translate "<nowiki>__DISAMBIG__</nowiki>".',
	'disambiguationpagelinks' => 'Title of the Special Page that shows all pages with links needing disambiguation',
	'disambiguationpagelinks-summary' => 'Header text explaining the purpose of the Special:DisambiguationPageLinks page. It is not necessary to translate "<nowiki>__DISAMBIG__</nowiki>".',
);
