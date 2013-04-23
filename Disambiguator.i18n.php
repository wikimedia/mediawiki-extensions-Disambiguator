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
	'disambig-desc' => 'Adds the tag <code><nowiki>__DISAMBIG__</nowiki></code> to mark [[Special:DisambiguationPages|disambiguation pages]]',
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
 * @author Shirayuki
 */
$messages['qqq'] = array(
	'disambig-desc' => '{{desc}}',
	'disambiguationpages' => '{{doc-special|DisambiguationPages}}
The special page shows all disambiguation pages.',
	'disambiguationpages-summary' => 'Header text explaining the purpose of the [[Special:DisambiguationPages]] page. It is not necessary to translate "<nowiki>__DISAMBIG__</nowiki>".

See also:
* {{msg-mw|Disambiguationpagelinks-summary}}',
	'disambiguationpagelinks' => '{{doc-special|DisambiguationPageLinks}}
The special page shows all pages with links needing disambiguation.',
	'disambiguationpagelinks-summary' => 'Header text explaining the purpose of the [[Special:DisambiguationPageLinks]] page. It is not necessary to translate "<nowiki>__DISAMBIG__</nowiki>".

See also:
* {{msg-mw|Disambiguationpages-summary}}',
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

/** Italian (italiano)
 * @author Beta16
 */
$messages['it'] = array(
	'disambig-desc' => 'Aggiunge il tag <code><nowiki>__DISAMBIG__</nowiki></code> per marcare le [[Special:DisambiguationPages|pagine di disambiguazione]].',
	'disambiguationpages' => 'Pagine di disambiguazione',
	'disambiguationpages-summary' => 'Di seguito è riportato un elenco di tutte le pagine di disambiguazione su {{SITENAME}}.<br />
Una pagina è considerata come una pagina di disambiguazione se la pagina contiene il tag <code><nowiki>__DISAMBIG__</nowiki></code> (o un alias equivalente).',
	'disambiguationpagelinks' => 'Pagine che si collegano a pagine di disambiguazione',
	'disambiguationpagelinks-summary' => 'Le pagine riportate di seguito contengono almeno un collegamento a una pagina di disambiguazione.
Potresti modificare il collegamento affinché punti ad una pagina più appropriata.<br />
Una pagina è considerata come una pagina di disambiguazione se la pagina contiene il tag <code><nowiki>__DISAMBIG__</nowiki></code> (o un alias equivalente).',
);

/** Japanese (日本語)
 * @author Shirayuki
 */
$messages['ja'] = array(
	'disambig-desc' => '[[Special:DisambiguationPages|曖昧さ回避ページ]]の印として使用する <code><nowiki>__DISAMBIG__</nowiki></code> タグを追加する',
	'disambiguationpages' => '曖昧さ回避ページ',
	'disambiguationpages-summary' => '{{SITENAME}}上の曖昧さ回避ページを以下に列挙します。<br />
タグ <code><nowiki>__DISAMBIG__</nowiki></code> (または同等の別名) を含むページを、曖昧さ回避ページと見なしています。',
	'disambiguationpagelinks' => '曖昧さ回避ページにリンクしているページ',
	'disambiguationpagelinks-summary' => '以下のページには、曖昧さ回避ページへのリンクが 1 つ以上あります。
これらのページでは、より適切なページにリンクする必要がある可能性があります。<br />
タグ <code><nowiki>__DISAMBIG__</nowiki></code> (または同等の別名) を含むページを、曖昧さ回避ページと見なしています。',
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'disambig-desc' => 'Ја става ознаката <code><nowiki>__DISAMBIG__</nowiki></code> со која ги означува [[Special:DisambiguationPages|појаснителните страници]].',
	'disambiguationpages' => 'Појаснителни страници',
	'disambiguationpages-summary' => 'Ова е список на појаснителни страници на {{SITENAME}}.<br />
Една страница се смета за појаснителна ако ја содржи ознаката <code><nowiki>__DISAMBIG__</nowiki></code> (или нејзин алијас).',
	'disambiguationpagelinks' => 'Страници што водат до појаснителни страници',
	'disambiguationpagelinks-summary' => 'Следниве страници содржат барем по една врска до појаснителна страница.
Веројатно ќе треба да ставите врска до посоодветна (поконкретна) страница.<br />
Една страница се смета за појаснителна доколку ја содржи ознаката <code><nowiki>__DISAMBIG__</nowiki></code> (или нејзин алијас).',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'disambig-desc' => "Aggiugne 'u tag <code><nowiki>__DISAMBIG__</nowiki></code> pe signà le [[Special:DisambiguationPages|pàggende de disambbiguazione]].",
	'disambiguationpages' => 'Pàggene de disambbiguazione',
	'disambiguationpagelinks' => 'Pàggene collegate a le pàggene de disambbiguazione',
	'disambiguationpagelinks-summary' => "Le pàggene seguende tènene almene 'na pàgene de disambbiguazione.
Lore ponne avè abbesogne de collegarse a cchiù pàggene appropriate.<br />
'Na pàgene jè trattate cumme a 'na pàgene de disambbiguazione ce 'a pàgene tène 'u tag <code><nowiki>__DISAMBIG__</nowiki></code> (o 'nu nome equivalende).",
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'disambiguationpages' => 'అయోమయ నివృత్తి పేజీలు',
	'disambiguationpagelinks' => 'అయోమయ నివృత్తి పుటలకు లంకెలున్న పుటలు',
);
