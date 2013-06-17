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

/** Asturian (asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'disambig-desc' => 'Amiesta la etiqueta <code><nowiki>__DISAMBIG__</nowiki></code> pa marcar les [[Special:DisambiguationPages|páxines de dixebra]].',
	'disambiguationpages' => 'Páxines de dixebra',
	'disambiguationpages-summary' => 'La siguiente ye una llista de toles páxines de dixebra de {{SITENAME}}.<br />
Una páxina tratase como páxina de dixebra si contién la etiqueta <code><nowiki>__DISAMBIG__</nowiki></code> (o un alcuñu equivalente).',
	'disambiguationpagelinks' => "Páxines qu'enllacen con páxines de dixebra",
	'disambiguationpagelinks-summary' => 'Les siguientes páxines contienen, polo menos, un enllaz a una páxina de dixebra.
Seique, necesiten enllazar con una páxina más axeitada.<br />
Una páxina tratase como de dixebra si contién la etiqueta <code><nowiki>__DISAMBIG__</nowiki></code> (o un alcuñu equivalente).',
);

/** Breton (brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'disambig-desc' => 'Ouzhpennañ ar balizenn <code><nowiki>__DISAMBIG__</nowiki></code> evit merkañ [[Special:DisambiguationPages|ar pajennoù disheñvelout]].',
	'disambiguationpages' => 'Pajennoù disheñvelout',
	'disambiguationpagelinks' => 'Pajennoù enno liammoù war-zu pajennoù disheñvelout',
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

/** Spanish (español)
 * @author Fitoschido
 */
$messages['es'] = array(
	'disambig-desc' => 'Añade la etiqueta <code><nowiki>__DISAMBIG__</nowiki></code> para marcar las [[Special:DisambiguationPages|páginas de desambiguación]]',
	'disambiguationpages' => 'Páginas de desambiguación',
	'disambiguationpagelinks' => 'Páginas que enlazan a páginas de desambiguación',
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

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'disambig-desc' => 'Engade a etiqueta <code><nowiki>__DISAMBIG__</nowiki></code> para marcar as [[Special:DisambiguationPages|páxinas de homónimos]].',
	'disambiguationpages' => 'Páxinas de homónimos',
	'disambiguationpages-summary' => 'A seguinte é unha lista de todas as páxinas de homónimos de {{SITENAME}}.<br />
Unha páxina considérase de homónimos se contén a etiqueta <code><nowiki>__DISAMBIG__</nowiki></code> (ou un pseudónimo equivalente).',
	'disambiguationpagelinks' => 'Páxinas que ligan con páxinas de homónimos',
	'disambiguationpagelinks-summary' => 'As seguintes páxina conteñen, polo menos, unha ligazón a unha páxina de homónimos.
Se cadra, deberían ligar cunha páxina máis axeitada.<br />
Unha páxina considérase de homónimos se contén a etiqueta <code><nowiki>__DISAMBIG__</nowiki></code> (ou un pseudónimo equivalente).',
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

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'disambig-desc' => 'Brängk dä Befähl <code><nowiki>__DISAMBIG__</nowiki></code> en et Wiki, öm [[Special:DisambiguationPages|„Watt eß dat?“ Sigge]] ze beschtemme.',
	'disambiguationpages' => '„Watt eß dat?“ Sigge',
	'disambiguationpages-summary' => 'Heh küdd en Leß met alle „Watt eß dat?“ Sigge {{GRAMMAR:em Dativ|{{ucfirst:{{SITENAME}}}}}}, dat sin Sigge, woh <code><nowiki>__DISAMBIG__</nowiki></code> dren schteiht, udder jät zom sällve Efäk.',
	'disambiguationpagelinks' => 'Sigge, di op „Watt eß dat?“ Sigge verlengke donn',
	'disambiguationpagelinks-summary' => 'Di Sigge en heh dä Leß han alle winneschsdens eine Lenk ob_en „Watt eß dat?“ Sigg.
Et künnt sin, dat se bäßer ob_en Sigg lenke dähte, di mieh zopaß kütt.

En Sigg med_enem <code><nowiki>__DISAMBIG__</nowiki></code> Befähl dren, udder jät, wad_et sellve bedügg udder enföösch, zällt als en  „Watt eß dat?“ Sigg.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'disambig-desc' => 'Setzt den Tag <code><nowiki>__DISAMBIG__</nowiki></code> derbäi fir [[Special:DisambiguationPages|Homonynie-Säiten]] ze markéieren',
	'disambiguationpages' => 'Homonymie-Säiten',
	'disambiguationpages-summary' => "Hei ass d'Lëscht vun allen Homonymiesäiten op {{SITENAME}}.<br />
Eng Säit gëtt als Homonymiesäit betruecht wann op der Säit den Tag<code><nowiki>__DISAMBIG__</nowiki></code> (oder en equivalenten Alias) drop steet.",
	'disambiguationpagelinks' => 'Säiten déi op Homonymie-Säite linken',
	'disambiguationpagelinks-summary' => 'Op dëse Säiten ass mindestens ee Link op eng Homonymie Säit.
Déi sollten op eng Säit déi besser passt verlinkt ginn.<br />
Eng Säit gëtt als Homonynie-Säit behandelt wann den Tag <code><nowiki>__DISAMBIG__</nowiki></code> (oder en equivalenten Alias) dran ass.',
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

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'disambig-desc' => "Voegt de tag <code><nowiki>__DISAMBIG__</nowiki></code> toe om [[Special:DisambiguationPages|doorverwijspagina's]] te markeren",
	'disambiguationpages' => "Doorverwijspagina's",
	'disambiguationpages-summary' => "Hier volgt een lijst met alle doorverwijspagina's op de site {{SITENAME}}.<br />
Een pagina wordt gezien als doorverwijspagina als deze de tag <code><nowiki>__DISAMBIG__</nowiki></code> bevat (of een equivalent alias).",
	'disambiguationpagelinks' => "Pagina's die een koppeling hebben naar doorverwijspagina's",
	'disambiguationpagelinks-summary' => "De volgende pagina's bevatten tenminste één koppeling naar een doorverwijspagina.
Wellicht moeten ze koppelen naar een meer passende pagina.<br />
Een pagina wordt gezien als doorverwijspagina als deze de tag <code><nowiki>__DISAMBIG__</nowiki></code> bevat (of een equivalent alias).",
);

/** Polish (polski)
 * @author Chrumps
 * @author WTM
 */
$messages['pl'] = array(
	'disambig-desc' => 'Dodaje wyrażenie <code><nowiki>__DISAMBIG__</nowiki></code> w celu oznaczenia[[Special:DisambiguationPages|stron ujednoznaczniających]]',
	'disambiguationpages' => 'Strony ujednoznaczniające',
	'disambiguationpages-summary' => 'Poniżej znajduje się lista wszystkich stron ujednoznaczniających na {{grammar:6sg|{{SITENAME}}}}.<br />Strona jest uważana za ujednoznaczniającą gdy zawiera wyrażenie <code><nowiki>__DISAMBIG__</nowiki></code> (bądź równoważny alias).',
	'disambiguationpagelinks' => 'Stron linkujące do stron ujednoznaczniających',
	'disambiguationpagelinks-summary' => 'Poniższe strony zawierają co najmniej jeden link prowadzący do jakiejś strony ujednoznaczniającej.
Najprawdopodobniej powinny linkować do bardziej konkretnej strony docelowej.<br />
Strona jest uważana za ujednoznaczniającą gdy zawiera wyrażenie <code><nowiki>__DISAMBIG__</nowiki></code> (bądź równoważny alias).',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'disambig-desc' => "Aggiugne 'u tag <code><nowiki>__DISAMBIG__</nowiki></code> pe signà le [[Special:DisambiguationPages|pàggende de disambbiguazione]].",
	'disambiguationpages' => 'Pàggene de disambbiguazione',
	'disambiguationpages-summary' => "'u seguende jè 'n'elenghe de tutte le pàggene de disambbiguazione de {{SITENAME}}.<br />
'Na pàgene jè trattate cumme 'na pàgene de disambbiguazione ce 'a pàgene tène 'u tag <code><nowiki>__DISAMBIG__</nowiki></code> (o une equivalende).",
	'disambiguationpagelinks' => 'Pàggene collegate a le pàggene de disambbiguazione',
	'disambiguationpagelinks-summary' => "Le pàggene seguende tènene almene 'na pàgene de disambbiguazione.
Lore ponne avè abbesogne de collegarse a cchiù pàggene appropriate.<br />
'Na pàgene jè trattate cumme a 'na pàgene de disambbiguazione ce 'a pàgene tène 'u tag <code><nowiki>__DISAMBIG__</nowiki></code> (o 'nu nome equivalende).",
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author Милан Јелисавчић
 */
$messages['sr-ec'] = array(
	'disambig-desc' => 'Додаје ознаку <code><nowiki>__DISAMBIG__</nowiki></code> за обележавање [[Special:DisambiguationPages|вишезначних одредница]]',
	'disambiguationpages' => 'Вишезначне одреднице',
	'disambiguationpagelinks' => 'Странице до вишезначних одредница',
);

/** Swedish (svenska)
 * @author Jopparn
 */
$messages['sv'] = array(
	'disambiguationpages' => 'Särskiljningssidor',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'disambiguationpages' => 'అయోమయ నివృత్తి పేజీలు',
	'disambiguationpagelinks' => 'అయోమయ నివృత్తి పుటలకు లంకెలున్న పుటలు',
);

/** Ukrainian (українська)
 * @author Ата
 */
$messages['uk'] = array(
	'disambiguationpages' => 'Сторінки виправлення неоднозначності',
	'disambiguationpagelinks' => 'Сторінки, що посилаються на сторінки неоднозначності.',
);

/** Urdu (اردو)
 * @author Noor2020
 */
$messages['ur'] = array(
	'disambig-desc' => 'ٹیگ کا اضافہ کرتا ہے <code><nowiki>__واضح رہے__</nowiki></code> [[Special:DisambiguationPages|صفحات کو واضح]] کے نشان زد کرنا',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'disambig-desc' => 'Thêm từ khóa <code><nowiki>__DISAMBIG__</nowiki></code> để đánh dấu các [[Special:DisambiguationPages|trang định hướng]]',
	'disambiguationpages' => 'Trang định hướng',
	'disambiguationpages-summary' => 'Đây là danh sách các trang định hướng trên {{SITENAME}}.<br />
Các trang định hướng có từ khóa <code><nowiki>__DISAMBIG__</nowiki></code> (hoặc một từ khóa tương tự).',
	'disambiguationpagelinks' => 'Trang liên kết đến trang định hướng',
	'disambiguationpagelinks-summary' => 'Các trang bên dưới chứa ít nhất một liên kết đến một trang định hướng.
Chúng có thể cần liên kết đến một trang dứt khoát hơn.<br />
Các trang định hướng có từ khóa <code><nowiki>__DISAMBIG__</nowiki></code> (hoặc một từ khóa tương tự).',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Cwek
 * @author Xiaomingyan
 */
$messages['zh-hans'] = array(
	'disambiguationpages' => '消歧义页面',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Justincheng12345
 * @author Simon Shek
 */
$messages['zh-hant'] = array(
	'disambig-desc' => '加入<code><nowiki>__DISAMBIG__</nowiki></code>標記以標示[[Special:DisambiguationPages|消歧義頁]]',
	'disambiguationpages' => '消歧義頁',
	'disambiguationpages-summary' => '以下是{{SITENAME}}上所以消歧義頁的列表。

若頁面含有<code><nowiki>__DISAMBIG__</nowiki></code>或相同標記則視為消歧義頁。',
	'disambiguationpagelinks' => '鏈接到消歧義頁的頁面',
	'disambiguationpagelinks-summary' => '下列頁面含有最下一個連往消歧義頁的連結，他們或應連至更準確的頁面。

若頁面含有<code><nowiki>__DISAMBIG__</nowiki></code>或相同標記則視為消歧義頁。',
);
