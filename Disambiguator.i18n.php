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
	'disambiguationpages-summary' => 'Header text explaining the purpose of the Special:DisambiguationPages page. It is not necessary to translate "<nowiki>__DISAMBIG__</nowiki>".',
	'disambiguationpagelinks' => 'Title of the Special Page that shows all pages with links needing disambiguation',
	'disambiguationpagelinks-summary' => 'Header text explaining the purpose of the Special:DisambiguationPageLinks page. It is not necessary to translate "<nowiki>__DISAMBIG__</nowiki>".',
);

/** Czech (česky)
 * @author Mormegil
 */
$messages['cs'] = array(
	'disambig-desc' => 'Přidává značku <code><nowiki>__DISAMBIG__</nowiki></code> k označení [[Special:DisambiguationPages|rozcestníků]].',
	'disambiguationpages' => 'Rozcestníky',
	'disambiguationpages-summary' => 'Toto je seznam všech rozcestníků na {{grammar:6sg|{{SITENAME}}}}.<br />Stránka je považována za rozcestník, pokud obsahuje značku <code><nowiki>__DISAMBIG__</nowiki></code> (nebo její synonymum).',
	'disambiguationpagelinks' => 'Stránky odkazující na rozcestníky',
	'disambiguationpagelinks-summary' => 'Následující stránky obsahují nejméně jeden odkaz na rozcestník. Možná by měly obsahovat na konkrétnější stránku.<br />Stránka je považována za rozcestník, pokud obsahuje značku <code><nowiki>__DISAMBIG__</nowiki></code> (nebo její synonymum).',
);

/** German (Deutsch)
 * @author Metalhead64
 */
$messages['de'] = array(
	'disambig-desc' => 'Ergänzt das Tag <code><nowiki>__DISAMBIG__</nowiki></code> zum Markieren von [[Special:DisambiguationPages|Begriffsklärungsseiten]].',
	'disambiguationpages' => 'Begriffsklärungsseiten',
	'disambiguationpages-summary' => 'Es folgt eine Liste aller Begriffsklärungsseiten auf {{SITENAME}}.<br />
Eine Seite wird als Begriffsklärungsseite behandelt, wenn sie das Tag <code><nowiki>__DISAMBIG__</nowiki></code> oder einen entsprechenden Alias enthält.',
	'disambiguationpagelinks' => 'Seiten, die auf Begriffsklärungsseiten verlinken',
	'disambiguationpagelinks-summary' => 'Die folgenden Seiten enthalten mindestens einen Link auf eine Begriffsklärungsseite.
Sie sollten stattdessen auf eine passendere Seite verlinken.<br />
Eine Seite wird als Begriffsklärungsseite behandelt, wenn sie das Tag <code><nowiki>__DISAMBIG__</nowiki></code> oder einen entsprechenden Alias enthält.',
);

/** French (français)
 * @author Gomoko
 */
$messages['fr'] = array(
	'disambig-desc' => 'Ajoute la balise <code><nowiki>__DISAMBIG__</nowiki></code> pour marquer [[Special:DisambiguationPages|les pages d’ambiguïté]].',
	'disambiguationpages' => 'Pages d’ambiguïté',
	'disambiguationpages-summary' => 'Ce qui suit est une liste de toutes les pages d’ambiguïté de {{SITENAME}}.<br />Une page est traitée comme page d’ambiguïté si la page contient la balise <code><nowiki>__DISAMBIG__</nowiki></code> (ou un alias équivalent).',
	'disambiguationpagelinks' => 'Pages menant vers des pages d’ambiguïté',
	'disambiguationpagelinks-summary' => 'Les pages suivantes contiennent au moins un lien vers une page d’ambiguïté. Elles peuvent devoir plutôt être liées à une page plus appropriée.<br />Une page est traitée comme page d’ambiguïté si la page contient la balise <code><nowiki>__DISAMBIG__</nowiki></code> (ou un alias équivalent).',
);
