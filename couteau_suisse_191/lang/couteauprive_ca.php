<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de https://www.spip.net/trad-lang/
// ** ne pas modifier le fichier **

if (!defined("_ECRIRE_INC_VERSION")) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// 2
	'2pts_non' => '&nbsp;:&nbsp;no',
	'2pts_oui' => '&nbsp;:&nbsp;si',

	// S
	'SPIP_liens:description' => '@puce@ Tout els enlla&ccedil;os del lloc s\'obren per defecte a la mateixa finestra de navegaci&oacute; que esteu. Per&ograve; pot ser &uacute;til obrir els enlla&ccedil;os externs al lloc en una nova finestra --es pot aconseguir afegint {target="_blank"} a totes les etiquetes &lt;a&gt; dotades per SPIP de les classes {spip_out}, {spip_url} o {spip_glossaire}. A vegades pot ser &uacute;til afegir una d\'aquestes classes als enlla&ccedil;os de l\'esquelet del lloc (fitxers html) per tal d\'ampliar al m&agrave;xim aquesta funcionalitat.[[%radio_target_blank3%]]

@puce@ SPIP permet lligar paraules amb la seva definici&oacute; gr&agrave;cies a la drecera tipogr&agrave;fica <code>[?mot]</code>. Per defecte (o si deixeu buida la casella de m&eacute;s avall), el glossari extern us envia cap a l\'enciclop&egrave;dia lliure wikipedia.org. Us toca a vosaltres decidir quina adre&ccedil;a voleu utilitzar. <br />Enlla&ccedil; de prova: [?SPIP][[%url_glossaire_externe2%]]',
	'SPIP_liens:description1' => '@puce@ SPIP ha previst un estil CSS pels enlla&ccedil;os &laquo;~mailto:~&raquo;: un petit sobre hauria d\'apar&egrave;ixer al davant de cada enlla&ccedil; lligat a un correu electr&ograve;nic; per&ograve; com que tots els navegadors no el poden mostrar (sobretot IE6, IE7 i SAF3), us toca a vosaltres decidir si &eacute;s necessari conservar aquest afegit.
_ Enlla&ccedil; de test: [->test@test.com] (recarregueu la p&agrave;gina completament).[[%enveloppe_mails%]]',
	'SPIP_liens:nom' => 'SPIP i els enlla&ccedil;os externs',

	// A
	'acces_admin' => 'Acc&eacute;s administradors:',
	'action_rapide' => 'Acci&oacute; r&agrave;pida, nom&eacute;s si sabeu qu&egrave; us feu! ',
	'action_rapide_non' => 'Acci&oacute; r&agrave;pida, disponible un cop aquesta eina siga activada :',
	'admins_seuls' => 'Nom&eacute;s els administradors',
	'attente' => 'Espera...',
	'auteur_forum:description' => 'Incita a tots els autors de missatges p&uacute;blics a omplir (amb una lletra com a m&iacute;nim!) el camp &laquo;@_CS_FORUM_NOM@&raquo; per tal d\'evitar les contribucions totalment an&ograve;nimes.',
	'auteur_forum:nom' => 'No als f&ograve;rums an&ograve;nims',
	'auteurs:description' => 'Aquesta eina configura l\'aparen&ccedil;a de [la p&agrave;gina autors->./?exec=auteurs], a la part privada.

@puce@ Defineix aqu&iacute; el nombre m&agrave;xim d\'autors a mostrar en el quadre central de la p&agrave;gina d\'autors. M&eacute;s enll&agrave;, trobem una paginaci&oacute;.[[%max_auteurs_page%]]

@puce@ Quins estats d\'autors es poden llistar en aquesta p&agrave;gina? 
[[%auteurs_tout_voir%]][[->%auteurs_0%]][[->%auteurs_1%]][[->%auteurs_5%]][[->%auteurs_6%]][[->%auteurs_n%]]',
	'auteurs:nom' => 'P&agrave;gina d\'autors',

	// B
	'basique' => 'B&agrave;sic',
	'blocs:aide' => 'Blocs Desplegables: <b>&lt;bloc&gt;&lt;/bloc&gt;</b> (&agrave;lies: <b>&lt;invisible&gt;&lt;/invisible&gt;</b>) i <b>&lt;visible&gt;&lt;/visible&gt;</b>',
	'blocs:description' => 'Us permet crear blocs que, amb el t&iacute;tol clicable, els pot tornar visibles o invisibles.

@puce@ {{En els textos SPIP}}: els redactors tenen disponibles les noves etiquetes &lt;bloc&gt; (o &lt;invisible&gt;) i &lt;visible&gt; per utilitzar en el seus textos d\'aquesta manera: 

<quote><code>
<bloc>
 Un t&iacute;tol que esdevindr&agrave; clicable
 
 El text a amagar/mostrar, despr&eacute;s de dos salts de l&iacute;nia...
 </bloc>
</code></quote>

@puce@ {{En els esquelets}}: teniu disponibles les noves etiquetes #BLOC_TITRE, #BLOC_DEBUT i #BLOC_FIN per utilitzar d\'aquesta manera: 
<quote><code> #BLOC_TITRE o #BLOC_TITRE{mon_URL}
 El meu t&iacute;tol
 #BLOC_RESUME    (facultatiu)
 una versi&oacute; resumida del bloc seg&uuml;ent
 #BLOC_DEBUT
 El meu bloc desplegable (que contindr&agrave; el URL al que apunta si &eacute;s necessari)
 #BLOC_FIN</code></quote>
 
@puce@ Marcant amb una creu &laquo;si&raquo; m&eacute;s avall, l\'obertura d\'un bloc provocar&agrave; el tancament de tots els altres blocs de la p&agrave;gina, per tal de tenir-ne nom&eacute;s un d\'obert a la vegada.[[%bloc_unique%]]

@puce@ Marcant amb una creu &laquo;si&raquo; m&eacute;s avall, l\'estat dels blocs enumerats ser&agrave; emmagatzemat a una galeta el temps de la sessi&oacute;, per tal de conservar l\'aspecte de la p&agrave;gina en cas de retorn.[[%blocs_cookie%]]

@puce@ El Ganivet Su&iacute;s utilitza, per defecte, l\'etiqueta HTML &lt;h4&gt; pel t&iacute;tol dels blocs desplegables. Escolliu aqu&iacute; una altra etiqueta &lt;hN&gt;&nbsp;:[[%bloc_h4%]]',
	'blocs:nom' => 'Blocs Desplegables',
	'boites_privees:description' => 'Tots els quadres descrits m&eacute;s avall apareixen aqu&iacute; o a la part privada.[[%cs_rss%]][[->%format_spip%]][[->%stat_auteurs%]][[->%qui_webmasters%]][[->%bp_urls_propres%]][[->%bp_tri_auteurs%]]
- {{Les revisions del Ganivet Su&iacute;s}}: un quadre a la p&agrave;gina actual de configuraci&oacute;, indicant les &uacute;ltimes modificacions aportades al codi del plugin ([Source->@_CS_RSS_SOURCE@]).
- {{Els articles en format SPIP}}: un quadre desplegable suplementari pels vostres articles que permet con&egrave;ixer el codi font utilitzat pels seus autors.
- {{Els autors en estat}}: un quadre desplegable sobre [la page des auteurs->./?exec=auteurs] que indica els 10 &uacute;ltims connectats i les inscripcions no confirmades. Aquestes informacions nom&eacute;s les veuen els administradors.
- {{Els Webmestres SPIP}}: un quadre desplegable a [la page des auteurs->./?exec=auteurs] que indica els administradors que tenen el nivell de Webmestre SPIP. Nom&eacute;s els administradors veuen aquestes informacions. Si tu mateix ets Webmestre, mira tamb&eacute; l\'eina &laquo;&nbsp;[.->webmestres]&nbsp;&raquo;.
- {{Els URLs propis}}: un quadre desplegable per cada objecte de contingut (article, secci&oacute;, autor,...) indicant el URL propi associat aix&iacute; com el seu &agrave;lies eventual. L\'eina &laquo;&nbsp;[.->type_urls]&nbsp;&raquo; us permet una configuraci&oacute; dels URLs del vostre lloc Web. - {{Les classificacions d\'autors}}: un quadre desplegable pels articles que contenen m&eacute;s d\'un autor i que permet simplement ajustar-ne l\'ordre de visualitzaci&oacute;. ',
	'boites_privees:nom' => 'Requadres privats',
	'bp_tri_auteurs' => 'Les classificacions d\'autors',
	'bp_urls_propres' => 'Els URLs propis',
	'brouteur:description' => 'Utilitzar el selector de secci&oacute; a AJAX a partir de %rubrique_brouteur% secci&oacute;(seccions)',
	'brouteur:nom' => 'Regulaci&oacute; del selector de secci&oacute;',

	// C
	'cache_controle' => 'Control de la mem&ograve;ria cau',
	'cache_nornal' => '&Uacute;s normal',
	'cache_permanent' => 'Mem&ograve;ria cau permanent',
	'cache_sans' => 'Sense mem&ograve;ria cau',
	'categ:admin' => '1. Administraci&oacute;',
	'categ:divers' => '60. Divers',
	'categ:interface' => '10. Interf&iacute;cie privada',
	'categ:public' => '40. Visualitzaci&oacute; p&uacute;blica',
	'categ:spip' => '50. Etiquetes, filtres, criteris',
	'categ:typo-corr' => '20. Millora dels textos',
	'categ:typo-racc' => '30. Dreceres tipogr&agrave;fiques',
	'certaines_couleurs' => 'Nom&eacute;s les etiquetes definides m&eacute;s avall@_CS_ASTER@ :',
	'chatons:aide' => 'Emoticones: @liste@',
	'chatons:description' => 'Insereix imatges (o emoticones pels {xats}) en tots els textos on apareix una cadena del tipus <code>:nom</code>.
_ Aquesta eina substitueix aquestes dreceres per les imatges del mateix nom que troba a dins de la vostra carpeta <code>mon_squelette_toto/img/chatons/</code>, o per defecte, la carpeta <code>couteau_suisse/img/chatons/</code>.',
	'chatons:nom' => 'Emoticones',
	'class_spip:description1' => 'Aqu&iacute; podeu definir algunes dreceres d\'SPIP. Un valor buit equival a utilitzar el valor per defecte.[[%racc_hr%]]',
	'class_spip:description2' => '@puce@ {{Les dreceres d\'SPIP}}.

Aqu&iacute; podeu definir algunes dreceres d\'SPIP. Un valor buit equival a fer servir el valor per defecte.[[%racc_hr%]][[%puce%]]',
	'class_spip:description3' => '

{Atenci&oacute;: si l\'eina &laquo;&nbsp;[.->pucesli]&nbsp;&raquo; est&agrave; activada, la substituci&oacute; del guionet &laquo;&nbsp;-&nbsp;&raquo; no es far&agrave;; al seu lloc s\'utilitzar&agrave; una llista del tipus &lt;ul>&lt;li>.}

SPIP utilitza habitualment l\'etiqueta &lt;h3&gt; pels subt&iacute;tols. Escolliu aqu&iacute; un altre empla&ccedil;ament:[[%racc_h1%]][[->%racc_h2%]]',
	'class_spip:description4' => '

SPIP ha escollit utilitzar l\'etiqueta &lt;strong> per transcriure les negretes. Per&ograve; &lt;b> tamb&eacute; hauria pogut anar b&eacute;, amb o sense estil. Vosaltres decidiu:[[%racc_g1%]][[->%racc_g2%]]

SPIP ha escollit utilitzar l\'etiqueta &lt;i> per transcriure les it&agrave;liques. Per&ograve; &lt;em> tamb&eacute; hauria pogut anar b&eacute;, amb o sense estil. Vosaltres decidiu: [[%racc_i1%]][[->%racc_i2%]]

 Podeu tamb&eacute; definir el codi obrint i tancant per les crides de notas a peu de p&agrave;gina (Atenci&oacute;! Les modificacions nom&eacute;s seran visibles a l\'espai p&uacute;blic: [[%ouvre_ref%]][[->%ferme_ref%]]
 
 Podeu definir el codi obrint i tancant per les notes de peu de p&agrave;gina: [[%ouvre_note%]][[->%ferme_note%]]

@puce@ {{Els estils d\'SPIP per defecte}}. Fins a la versi&oacute; 1.92 d\'SPIP, les dreceres tipogr&agrave;fiques produeixen etiquetes sistem&agrave;ticament vestides de l\'estil "spip". Per exemple: <code><p class="spip"></code>. Aqu&iacute; podeu definir l\'estil d\'aquestes etiquetes en funci&oacute; dels vostres fulls d\'estil. Una caixa buida significa que no s\'aplicar&agrave; cap estil en particular.

{Atenci&oacute;: si algunes dreceres (l&iacute;nia horitzontal, subt&iacute;tol, it&agrave;lica, negreta) s\'han modificat m&eacute;s amunt, els estils posteriors no s\'aplicaran.}

<q1>
_ {{1.}} Etiquetes &lt;p&gt;, &lt;i&gt;, &lt;strong&gt; :[[%style_p%]]
_ {{2.}} Etiquetes &lt;tables&gt;, &lt;hr&gt;, &lt;h3&gt;, &lt;blockquote&gt; i les llistes (&lt;ol&gt;, &lt;ul&gt;, etc.) :[[%style_h%]]

Anoteu: modificant aquest segon estil, tamb&eacute; perdeu els estils est&agrave;ndards d\'SPIP associats a aquestes etiquetes.</q1>',
	'class_spip:nom' => 'SPIP i les seves dreceres…',
	'code_css' => 'CSS',
	'code_fonctions' => 'Funcions',
	'code_jq' => 'jQuery',
	'code_js' => 'JavaScript',
	'code_options' => 'Opcions',
	'code_spip_options' => 'Opcions SPIP',
	'contrib' => 'M&eacute;s informacions: @url@',
	'corbeille:description' => 'SPIP suprimeix autom&agrave;ticament els objectes llen&ccedil;ats a la paperera les &uacute;ltimes 24 hores, en general des de les 4 de la matinada, gr&agrave;cies a una tasca &laquo;CRON&raquo; (llan&ccedil;ament peri&ograve;dic i/o autom&agrave;tic dels processos programats pr&egrave;viament). Aqu&iacute; podeu impedir aquest proc&eacute;s per tal de gestionar millor la vostra paperera. [[%arret_optimisation%]]',
	'corbeille:nom' => 'La paperera',
	'corbeille_objets' => '@nb@ objecte(s) a la paperera. ',
	'corbeille_objets_lies' => '@nb_lies@ enlla&ccedil;(os) detectat(s).',
	'corbeille_objets_vide' => 'Cap objecte a la paperera',
	'corbeille_objets_vider' => 'Suprimir els objectes seleccionats',
	'corbeille_vider' => 'Buidar la paperera:',
	'couleurs:aide' => 'Acolorir el text: <b>[coul]text[/coul]</b>@fond@ amb <b>coul</b> = @liste@',
	'couleurs:description' => 'Permet aplicar f&agrave;cilment colors a tots els textos del lloc (articles, breus, t&iacute;tols, f&ograve;rum, …) utilitzant etiquetes en dreceres.

Dos exemples id&egrave;ntics per canviar el color del text:@_CS_EXEMPLE_COULEURS2@

&Iacute;dem per canviar el fons, si la opci&oacute; de m&eacute;s avall ho permet:@_CS_EXEMPLE_COULEURS3@

[[%couleurs_fonds%]]
[[%set_couleurs%]][[->%couleurs_perso%]]
@_CS_ASTER@El format d\'aquestes etiquetes personalitzades ha de llistar colors existents o definir parelles &laquo;balise=couleur&raquo;, separats tots per comes. Exemples: &laquo;gris, vermell&raquo;, &laquo;flux=groc, fort=vermell&raquo;, &laquo;baix=#99CC11, alt=marr&oacute;&raquo; o fins i tot    &laquo;gris=#DDDDCC, vermell=#EE3300&raquo;. Pel primer i l\'&uacute;ltim exemple, les etiquetes autoritzades s&oacute;n: <code>[gris]</code> et <code>[rouge]</code> (<code>[fond gris]</code> et <code>[fond rouge]</code> si els fons s&oacute;n permesos).',
	'couleurs:nom' => 'Tot en colors',
	'couleurs_fonds' => ', <b>[fond&nbsp;coul]text[/coul]</b>, <b>[bg&nbsp;coul]text[/coul]</b>',
	'cs_comportement:description' => '@puce@ {{Logs.}} Obtingueu molta informaci&oacute; sobre el funcionament del Ganivet Su&iacute;s als fitxers {spip.log} que es poden trobar a dins del directori: {@_CS_DIR_TMP@}[[%log_couteau_suisse%]]

@puce@ {{Opcions SPIP.}} SPIP ordena els plugins en un ordre espec&iacute;fic. Per tal d\'estar segurs que el Ganivet Su&iacute;s estigui al capdamunt i gestioni abans certes opcions d\'SPIP, marqueu la seg&uuml;ent opci&oacute;. Si els drets del vostre servidor ho permeten, el fitxer {@_CS_FILE_OPTIONS@} ser&agrave; modificat autom&agrave;ticament per incloure el fitxer {@_CS_DIR_TMP@couteau-suisse/mes_spip_options.php}.
[[%spip_options_on%]]

@puce@ {{Peticions externes.}} El Ganivet Su&iacute;s verifica regularment si existeix una versi&oacute; m&eacute;s recent del seu codi i informa a la seva p&agrave;gina de configuraci&oacute; que hi ha disponible una actualitzaci&oacute;. Si les peticions externes del vostre servidor us donen problemes, marqueu la seg&uuml;ent casella.[[%distant_off%]]',
	'cs_comportement:nom' => 'Comportaments del Ganivet Su&iacute;s',
	'cs_distant_off' => 'Les verificacions de versions distants',
	'cs_log_couteau_suisse' => 'Els logs detallats del Ganivet Su&iacute;s',
	'cs_reset' => 'Est&agrave; segur de voler reinicialitzar totalment el Gavinet Su&iacute;s?',
	'cs_reset2' => 'Totes les eines actives actualment seran desactivades i els seus par&agrave;metres reinicialitzats.',
	'cs_spip_options_on' => 'Les opcions SPIP a &laquo;@_CS_FILE_OPTIONS@&raquo;',

	// D
	'decoration:aide' => 'Decoraci&oacute;: <b>&lt;etiqueta&gt;test&lt;/etiqueta&gt;</b>, amb <b>etiqueta</b> = @liste@',
	'decoration:description' => 'De nou estils parametrables a dins dels vostres textos i accessibles gr&agrave;cies a les etiquetes &agrave; chevrons. Exemple: 
&lt;lamevaetiqueta&gt;text&lt;/lamevaetiqueta&gt; o : &lt;lamevaetiqueta/&gt;.<br />Definiu m&eacute;s avall els estils CSS que necessiteu, una etiqueta per l&igrave;nia, segons les seg&uuml;ents sintaxis:
- {tipus.lamevaetiqueta = el meu estil CSS}
- {tipus.lamevaetiqueta.class = la meva  classe CSS}
- {tipus.lamevaetiqueta.lang = la meva llengua (ex: ca)}
- {unalies = lamevaetiqueta}

El par&agrave;metre {tipus} de m&eacute;s amunt pot agafar tres valors:
- {span}: etiqueta a l\'interior d\'un par&agrave;graf (tipus Inline)
- {div}: etiqueta que crea un par&agrave;graf nou (tipus Block)
- {auto}: etiqueta determinada autom&agrave;ticament pel plugin

[[%decoration_styles%]]',
	'decoration:nom' => 'Decoraci&oacute;',
	'decoupe:aide' => 'Bloc de pestanyes: <b>&lt;pestanyes>&lt;/pestanyes></b><br/>Separador  de p&agrave;gines o de pestanyes: @sep@',
	'decoupe:aide2' => '&Agrave;lies:&nbsp;@sep@',
	'decoupe:description' => '@puce@ Talla la visualitzaci&oacute; p&uacute;blica d\'un article en diverses p&agrave;gines gr&agrave;cies a una paginaci&oacute; autom&agrave;tica. Situeu simplement a dins del vostre article quatre signes m&eacute;s consecutius (<code>++++</code>) a l\'indret on s\'hagi de realitzar el tall.

Per defecte, el Ganivet Su&iacute;s insereix la paginaci&oacute; al capdamunt i al peu de l\'article autom&agrave;ticament. Per&ograve; teniu la possibilitat de situar aquesta paginaci&oacute; all&agrave; on us interessi del vostre esquelet gr&agrave;cies a una etiqueta #CS_DECOUPE que podeu activar aqu&iacute;:
[[%balise_decoupe%]]

@puce@ Si feu servir aquest separador a l\'interior d\'etiquetes &lt;onglets&gt; i &lt;/onglets&gt; obtindreu aleshores un joc de pestanyes.

A dins dels esquelets: teniu a la vostra disposici&oacute; les noves etiquetes #ONGLETS_DEBUT, #ONGLETS_TITRE i #ONGLETS_FIN.

Aquesta eina es pot acompanyar amb &laquo;&nbsp;[.->sommaire]&nbsp;&raquo;.',
	'decoupe:nom' => 'Talla en p&agrave;gines i pestanyes',
	'desactiver_flash:description' => 'Suprimeix els objectes flash de les p&agrave;gines del vostre lloc i les substitueix pel contingut alternatiu associat.',
	'desactiver_flash:nom' => 'Desactiva els objectes flash',
	'detail_balise_etoilee' => '{{Atenci&oacute;}}: Verifiqueu b&eacute; l\'&uacute;s fet pels vostres esquelets d\'etiquetes estrellades. Els tractaments d\'aquesta eina no s\'aplicaran pas a: @bal@.',
	'detail_fichiers' => 'Fitxers:',
	'detail_inline' => 'Codi inserit:',
	'detail_jquery1' => '{{Atenci&oacute;}}: aquesta eina necessita el plugin {jQuery} per funcionar amb aquesta versi&oacute; d\'SPIP.',
	'detail_jquery2' => 'Aquesta eina necessita la llibreria {jQuery}.',
	'detail_jquery3' => '{{Atenci&oacute;}} : aquesta eina necessita el plugin [jQuery per SPIP 1.92->https://files.spip.net/spip-zone/jquery_192.zip] per funcionar correctament amb aquesta versi&oacute; d\'SPIP.',
	'detail_pipelines' => 'Pipelines :',
	'detail_traitements' => 'Tractaments :',
	'dossier_squelettes:description' => 'Modifica la carpeta de l\'esquelet utilitzat. Per exemple: "esquelets/elmeuesquelet". Podeu inscriure diverses carpetes separant-les pels dos punts <html>&laquo;&nbsp;:&nbsp;&raquo;</html>. Deixar buida la caixa que segueix (o teclejant "dist"), &eacute;s l\'esquelet original "dist" subministrat per SPIP el que es far&agrave; servir.[[%dossier_squelettes%]]',
	'dossier_squelettes:nom' => 'Carpeta de l\'esquelet',

	// E
	'effaces' => 'Esborrats',
	'en_travaux:description' => 'Permet mostrar un missatge personalitzat durant una fase de manteniment a tot el lloc p&uacute;blic, eventualment a la part privada.
[[%message_travaux%]][[%titre_travaux%]][[%admin_travaux%]][[%prive_travaux%]]',
	'en_travaux:nom' => 'Lloc en manteniment',
	'erreur:bt' => '<span style=\\"color:red;\\">Atenci&oacute;:</span> la barra tipogr&agrave;fica (version @version@) semble ancienne.<br />El Ganivet Su&iacute;s &eacute;s compatible amb una versi&oacute; superior o igual a @mini@.',
	'erreur:description' => 'id absent en la definici&oacute; de l\'eina!',
	'erreur:distant' => 'servidor distant',
	'erreur:jquery' => '{{Nota}}: la llibreria {jQuery} sembla inactiva en aquesta p&agrave;gina. Consulteu [aqu&iacute;->https://contrib.spip.net/?article2166] el par&agrave;graf sobre les depend&egrave;ncies del plugin o recarregar aquesta p&agrave;gina.',
	'erreur:js' => 'Sembla que s\'ha produ&iuml;t un error JavaScript en aquesta p&agrave;gina i impedeix el seu bon funcionament. Vulgueu activar JavaScript al vostre navegador o desactivar alguns plugins SPIP del vostre lloc.',
	'erreur:nojs' => 'Aquesta p&agrave;gina t&eacute; el JavaScript desactivat.',
	'erreur:nom' => 'Error!',
	'erreur:probleme' => 'Problema a: @pb@',
	'erreur:traitements' => 'El Ganivet Su&iacute;s - Error de compilaci&oacute; dels tractaments: barreja \'typo\' i \'propre\' prohibit!',
	'erreur:version' => 'Aquesta eina &eacute;s indispensable en aquesta versi&oacute; d\'SPIP.',
	'etendu' => 'Est&egrave;s',

	// F
	'f_jQuery:description' => 'Impedeix la instal&middot;laci&oacute; de {jQuery} a la part p&uacute;blica per tal d\'economitzar una mica de &laquo;temps m&agrave;quina&raquo;. Aquesta llibreria ([->http://jquery.com/]) aporta nombroses comoditats a la programaci&oacute; de JavaScript i pot ser utilitzada per certs plugins. SPIP l\'utilitza a la seva part privada.

Atenci&oacute;: certes eines del Ganivet Su&iacute;s necessiten les funcions de {jQuery}. ',
	'f_jQuery:nom' => 'Desactiva jQuery',
	'filets_sep:aide' => 'L&iacute;nies de Separaci&oacute;: <b>__i__</b> o <b>i</b> &eacute;s un nombre.<br />Altres l&iacute;nies disponibles: @liste@',
	'filets_sep:description' => 'Insereix l&iacute;nies de separaci&oacute;, que es poden personalitzar per fulls d\'estil, a tots els textos d\'SPIP.
_ La sintaxi &eacute;s: "__code__", o "code" representa o b&eacute; el n&uacute;mero d\'identificaci&oacute; (de 0 a 7) de la l&iacute;nia a inserir en relaci&oacute; directa amb els estils corresponents, o b&eacute; el nom d\'una imatge situada a dins de la carpeta plugins/couteau_suisse/img/filets.',
	'filets_sep:nom' => 'L&iacute;nies de Separaci&oacute;',
	'filtrer_javascript:description' => 'Per gestionar la inserci&oacute; de JavaScript a dins dels articles, podem fer-ho de tres maneres:
- <i>mai</i> : el JavaScript &eacute;s rebutjat a tot arreu
- <i>defecte</i> : el JavaScript s\'assenyala en vermell a l\'espai privat
- <i>sempre</i> : el JavaScript s\'accepta a tot arreu.

Atenci&oacute;: a dins dels f&ograve;rums, peticions, flux sindicats, etc., la gesti&oacute; del JavaScript &eacute;s <b>sempre</b> segura.[[%radio_filtrer_javascript3%]]',
	'filtrer_javascript:nom' => 'Gesti&oacute; del JavaScript',
	'flock:description' => 'Desactiva el sistema bloqueig de fitxers neutralitzant la funci&oacute; PHP {flock()}. Alguns hostatjadors posen problemes greus fruit d\'un sistema de fitxers inadaptat o a una manca de sincronitzaci&oacute;. No activeu aquesta eina si el vostre lloc funciona normalment. ',
	'flock:nom' => 'Cap bloqueig de fitxers',
	'fonds' => 'Fons:',
	'forcer_langue:description' => 'Imposa el context de llengua pels jocs d\'esquelets multiling&uuml;es que disposen d\'un formulari o d\'un men&uacute; de lleng&uuml;es que sap gestionar la galeta de lleng&uuml;es.

T&egrave;cnicament, aquesta eina t&eacute; com efecte:
- desactivar la cerca del esquelet en funci&oacute; de la llengua de l\'objecte,
- desactivar el criteri <code>{lang_select}</code> autom&agrave;tic en els objectes cl&agrave;ssics (articles, breus, seccions... ).

Aleshores, els blocs multi es mostren sempre en la llengua demanada pel visitant.',
	'forcer_langue:nom' => 'Imposa la llengua',
	'format_spip' => 'Els articles en format SPIP',
	'forum_lgrmaxi:description' => 'Per defecte, els missatges de f&ograve;rum no tenen l&iacute;mits de mida. Si aquesta eina est&agrave; activada, es mostrar&agrave; un missatge d\'error quan alg&uacute; vulgui enviar un missatge d\'una mida superior al valor especificat, i el missatge es rebutjar&agrave;. Un valor buit o igual a 0 significa, no obstant, que no s\'aplica cap l&iacute;mit.[[%forum_lgrmaxi%]]',
	'forum_lgrmaxi:nom' => 'Mida dels f&ograve;rums',

	// G
	'glossaire:aide' => 'Un text sense glossari: <b>@_CS_SANS_GLOSSAIRE@</b>',
	'glossaire:description' => '@puce@ Gesti&oacute; d\'un glossari intern lligat a un o diversos grups de paraules clau. Inscriviu aqu&iacute; el nom dels grups separant-los per dos punts &laquo;&nbsp;:&nbsp;&raquo;. Deixant buida la casella que segueix (o teclejant "Glossari"), &eacute;s el grup "Glossari" el que es far&agrave; servir.[[%glossaire_groupes%]]

@puce@ Per cada paraula, teniu la possibilitat d\'escollir el n&uacute;mero m&agrave;xim d\'enlla&ccedil;os creats als vostres textos. Tot valor nul o negatiu implica que es tractaran totes les paraules reconegudes. [[%glossaire_limite% par mot-cl&eacute;]]

@puce@ S\'ofereixen dues solucions per gestionar la petita finestra autom&agrave;tica que apareix quan hi passes per sobre el ratol&iacute;.  [[%glossaire_js%]]',
	'glossaire:nom' => 'Glossari intern',
	'glossaire_css' => 'Soluci&oacute; CSS',
	'glossaire_js' => 'Soluci&oacute; JavaScript',
	'guillemets:description' => 'Substitueix autom&agrave;ticament les cometes (") per les cometes tipogr&agrave;fiques de la llengua de composici&oacute;. La substituci&oacute;, transparent per l\'usuari, no modifica el text original sin&oacute; nom&eacute;s la seva publicaci&oacute; final. ',
	'guillemets:nom' => 'Cometes tipogr&agrave;fiques',

	// H
	'help' => '{{Aquesta p&agrave;gina nom&eacute;s &eacute;s accessible pels responsables del lloc.}}<p>Permet la configuraci&oacute; de les diferents funcions suplement&agrave;ries aportades pel plugin &laquo;{{Le&nbsp;Couteau&nbsp;Suisse}}&raquo;.',
	'help2' => 'Versi&oacute; local: @version@',
	'help3' => '<p>Enlla&ccedil;os de documentaci&oacute;:<br/>•[Le&nbsp;Couteau&nbsp;Suisse->https://contrib.spip.net/?article2166]@contribs@</p><p>Reiniciacions:
_ • [Eines amagades|Tornar a l\'aparen&ccedil;a inicial d\'aquesta p&agrave;gina->@hide@]
_ • [De tot el plugin|Tornar a l\'estat inicial del plugin->@reset@]@install@
</p></p>',
	'horloge:description' => 'Eina en curs de desenvolupament. Us ofereix un rellotge JavaScript. Etiqueta: <code>#HORLOGE{format,utc,id}</code>. Model: <code><horloge></code>',
	'horloge:nom' => 'Rellotge',

	// I
	'icone_visiter:description' => 'Substitueix la imatge del bot&oacute; est&agrave;ndard &laquo;&nbsp;Visitar&nbsp;&raquo; (a dalt a la dreta d\'aquesta p&agrave;gina) pel logotip del lloc, si existeix.

Per definir aquest logotip, dirigiu-vos a la p&agrave;gina &laquo;&nbsp;Configuraci&oacute; del lloc&nbsp;&raquo; fent un clic damunt del bot&oacute; &laquo;&nbsp;Configuraci&oacute;&nbsp;&raquo;.',
	'icone_visiter:nom' => 'Bot&oacute; &laquo;&nbsp;Visitar&nbsp;&raquo;',
	'insert_head:description' => 'Activa autom&agrave;ticament l\'etiqueta [#INSERT_HEAD->https://www.spip.net/fr_article1902.html] a tots els esquelets, tinguin o no aquesta etiqueta entre &lt;head&gt; i &lt;/head&gt;. Gr&agrave;cies a aquesta opci&oacute;, els plugins podran inserir JavaScript (.js) o fulls d\'estil (.css).',
	'insert_head:nom' => 'Etiqueta #INSERT_HEAD',
	'insertions:description' => 'ATENCI&Oacute;: eina en curs de desenvolupament!! [[%insertions%]]',
	'insertions:nom' => 'Correccions autom&agrave;tiques',
	'introduction:description' => 'Aquesta etiqueta que cal posar a dins dels esquelets serveix, en general a la p&agrave;gina principal o a les seccions, per fer un resum dels articles, de les notes breus, etc..</p>
<p>{{Atenci&oacute;}}: Abans d\'activar aquesta funcionalitat, verifiqueu b&eacute; que no existeix ja cap funci&oacute; {balise_INTRODUCTION()} al vostre esquelet o als vostres plugins. La sobrec&agrave;rrega produ&iuml;ra un error de compilaci&oacute;.</p>
@puce@ Podeu precisar (en percentatge per relaci&oacute; al valor utilitzat per defecte) la llargada del text a retornar per l\'etiqueta #INTRODUCTION. Cap valor o igual a 100 no modifica l\'aspecte de la introducci&oacute; i utilitza, per tant, els valors per defecte seg&uuml;ents: 500 car&agrave;cters pels articles, 300 per les notes breus i 600 pels f&ograve;rums i les seccions.
[[%lgr_introduction%&nbsp;%]]
@puce@ Per defecte, els punts de continuaci&oacute; afegits al resultat de l\'etiqueta #INTRODUCTION si el text &eacute;s massa llarg s&oacute;n: <html>&laquo;&amp;nbsp;(…)&raquo;</html>. Aqu&iacute; podeu precisar la vostra pr&ograve;pia cadena de car&agrave;cters que indiqui al lector que el text tallat t&eacute; una continuaci&oacute;.
[[%suite_introduction%]]
@puce@ Si l\'etiqueta #INTRODUCTION es fa servir per resumir un article, llavors el Ganivet Su&iacute;s pot fabricar un hipervincle al damunt dels punts de continuaci&oacute; definits m&eacute;s amunt per tal portar al lector cap al text original. Per exemple: &laquo;Llegir la continuaci&oacute; de l\'article…&raquo;
[[%lien_introduction%]]
',
	'introduction:nom' => 'Etiqueta #INTRODUCTION',

	// J
	'jcorner:description' => '&laquo;&nbsp;Jolis Coins&nbsp;&raquo; &eacute;s una eina que permet modificar f&agrave;cilment l\'aspecte de les cantonades dels vostres {{requadres acolorits}} a la part p&uacute;blica del vostre lloc. Tot &eacute;s possible, o gaireb&eacute; tot!
_ Podeu veure\'n el resultat a la p&agrave;gina seg&uuml;ent: [->http://www.malsup.com/jquery/corner/].

Llisteu m&eacute;s avall els objectes del vostre esquelet que cal arrodonir utilitzant la sintaxi CSS (.class, #id, etc. ). Feu servir el signe &laquo;&nbsp;=&nbsp;&raquo; per especificar el comandament jQuery que s\'ha de fer servir i una doble barra inclinada (&laquo;&nbsp;//&nbsp;&raquo;) pels comentaris. En abs&egrave;ncia del signe igual, s\'aplicaran les cantonades rodones (equivalent a: <code>.ma_classe = .corner()</code>).[[%jcorner_classes%]]

Atenci&oacute;, aquesta eina necessita per funcionar el plugin {jQuery}: {Round Corners}. El Ganivet Su&iacute;s es pot instal&middot;lar directament si marqueu amb una creu la casella seg&uuml;ent. [[%jcorner_plugin%]]',
	'jcorner:nom' => 'Jolis Coins',
	'jcorner_plugin' => '&laquo;&nbsp;Round Corners plugin&nbsp;&raquo;',
	'jq_localScroll' => 'jQuery.LocalScroll ([demo->http://demos.flesler.com/jquery/localScroll/])',
	'jq_scrollTo' => 'jQuery.ScrollTo ([demo->http://demos.flesler.com/jquery/scrollTo/])',
	'js_defaut' => 'Per defecte',
	'js_jamais' => 'Mai',
	'js_toujours' => 'Sempre',

	// L
	'label:admin_travaux' => 'Tancar el lloc p&uacute;blic per:',
	'label:arret_optimisation' => 'Impedir que SPIP buidi la paperera autom&agrave;ticament:',
	'label:auteurs_tout_voir' => '@_CS_CHOIX@',
	'label:auto_sommaire' => 'Creaci&oacute; sistem&agrave;tica del sumari:',
	'label:balise_decoupe' => 'Activar l\'etiqueta #CS_DECOUPE :',
	'label:balise_sommaire' => 'Activar l\'etiqueta #CS_SOMMAIRE :',
	'label:bloc_h4' => 'Etiqueta pels t&iacute;tols:',
	'label:bloc_unique' => 'Nom&eacute;s un bloc obert a la p&agrave;gina:',
	'label:blocs_cookie' => 'Utilitzaci&oacute; de galetes:',
	'label:couleurs_fonds' => 'Permetre els fons:',
	'label:cs_rss' => 'Activar:',
	'label:debut_urls_libres' => '<:label:debut_urls_propres:>',
	'label:debut_urls_propres' => 'Inici dels URLs :',
	'label:debut_urls_propres2' => '<:label:debut_urls_propres:>',
	'label:decoration_styles' => 'Les vostres etiquetes d\'estil personalitzat:',
	'label:derniere_modif_invalide' => 'Tornar a calcular despr&eacute;s d\'una modificaci&oacute;:',
	'label:distant_off' => 'Desactivar:',
	'label:dossier_squelettes' => 'Carpeta(es) a utilitzar:',
	'label:duree_cache' => 'Durada de la mem&ograve;ria cau local:',
	'label:duree_cache_mutu' => 'Durada de la mem&ograve;ria cau en mutualitzaci&oacute;:',
	'label:enveloppe_mails' => 'Petit sobre davant dels correus electr&ograve;nics:',
	'label:expo_bofbof' => 'Escriptura com exponents de: <html>St(e)(s), Bx, Bd(s) et Fb(s)</html>',
	'label:forum_lgrmaxi' => 'Valor (en car&agrave;cters):',
	'label:glossaire_groupes' => 'Grup(s) utilitzat(s):',
	'label:glossaire_js' => 'T&egrave;cnica utilitzada:',
	'label:glossaire_limite' => 'N&uacute;mero m&agrave;xim d\'enlla&ccedil;os creats:',
	'label:insertions' => 'Correccions autom&agrave;tiques:',
	'label:jcorner_classes' => 'Millorar les cantonades dels seg&uuml;ents selectors:',
	'label:jcorner_plugin' => 'Instal&middot;lar el plugin {jQuery} seg&uuml;ent:',
	'label:lgr_introduction' => 'Llargada del resum:',
	'label:lgr_sommaire' => 'Llargada del sumari (9 a 99):',
	'label:lien_introduction' => 'Punts de continuaci&oacute; clicables:',
	'label:liens_interrogation' => 'Protegir els URLs: ',
	'label:liens_orphelins' => 'Enlla&ccedil;os clicables:',
	'label:log_couteau_suisse' => 'Activar:',
	'label:marqueurs_urls_propres' => 'Afegir els marcadors dissociant els objectes (SPIP>=2.0) :<br/>(ex.: &laquo;&nbsp;-&nbsp;&raquo; per -Ma-rubrique-, &laquo;&nbsp;@&nbsp;&raquo; per @Mon-site@) ',
	'label:marqueurs_urls_propres2' => '<:label:marqueurs_urls_propres:>',
	'label:marqueurs_urls_propres_qs' => '<:label:marqueurs_urls_propres:>',
	'label:max_auteurs_page' => 'Autors per p&agrave;gina:',
	'label:message_travaux' => 'El vostre missatge de manteniment:',
	'label:moderation_admin' => 'Validar autom&agrave;ticament els missatges de: ',
	'label:ouvre_note' => 'Obertura i tancament de les notes a peu de p&agrave;gina',
	'label:ouvre_ref' => 'Obertura i tancament de les crides de les notes a peu de p&agrave;gina',
	'label:paragrapher' => 'Sempre par&agrave;grafs:',
	'label:prive_travaux' => 'Accessibilitat de l\'espai privat per:',
	'label:puce' => 'Car&agrave;cter p&uacute;blic &laquo;<html>-</html>&raquo; :',
	'label:quota_cache' => 'Valor de la quota :',
	'label:racc_g1' => 'Entrada i sortida de la posada en &laquo;<html>{{negreta}}</html>&raquo;:',
	'label:racc_h1' => 'Entrada i sortida d\'un &laquo;<html>{{{subt&iacute;tol}}}</html>&raquo; :',
	'label:racc_hr' => 'L&iacute;nia horitzontal &laquo;<html>----</html>&raquo;:',
	'label:racc_i1' => 'Entrada i sortida de la posada en &laquo;<html>{cursiva}</html>&raquo; :',
	'label:radio_desactive_cache3' => 'Utilitzaci&oacute; de la mem&ograve;ria cau:',
	'label:radio_desactive_cache4' => 'Utilitzaci&oacute; de la mem&ograve;ria cau: ',
	'label:radio_filtrer_javascript3' => '@_CS_CHOIX@',
	'label:radio_set_options4' => '@_CS_CHOIX@',
	'label:radio_suivi_forums3' => '@_CS_CHOIX@',
	'label:radio_target_blank3' => 'Nova finestra pels enlla&ccedil;os externs:',
	'label:radio_type_urls3' => 'Format dels URLs:',
	'label:scrollTo' => 'Instal&middot;lar els plugins {jQuery} seg&uuml;ents:',
	'label:separateur_urls_page' => 'Car&agrave;cter de separaci&oacute; \'type-id\'<br/>(ex. : ?article-123) :',
	'label:set_couleurs' => 'Set per utilitzar:',
	'label:spam_mots' => 'Seq&uuml;&egrave;ncies prohibides:',
	'label:spip_options_on' => 'Incloure :',
	'label:spip_script' => 'Script de crida:',
	'label:style_h' => 'El vostre estil:',
	'label:style_p' => 'El vostre estil:',
	'label:suite_introduction' => 'Punts de continuaci&oacute;:',
	'label:terminaison_urls_arbo' => '<:label:terminaison_urls_page:>',
	'label:terminaison_urls_libres' => '<:label:terminaison_urls_page:>',
	'label:terminaison_urls_page' => 'Terminacions dels URls (ex : &laquo;&nbsp;.html&nbsp;&raquo;) :',
	'label:terminaison_urls_propres' => '<:label:terminaison_urls_page:>',
	'label:terminaison_urls_propres_qs' => '<:label:terminaison_urls_page:>',
	'label:titre_travaux' => 'T&iacute;tol del missatge:',
	'label:titres_etendus' => 'Activar la utilitzaci&oacute; &agrave;mplia d\'etiquetes #TITRE_XXX&nbsp;:',
	'label:tri_articles' => 'La vostra elecci&oacute;:',
	'label:url_arbo_minuscules' => 'Conservar els tipus dels t&iacute;tols en els URLs:',
	'label:url_arbo_sep_id' => 'Car&agrave;cter de separaci&oacute; \'titre-id\' en cas de doublon :<br/>(no utilitzar \'/\')',
	'label:url_glossaire_externe2' => 'Enlla&ccedil; al glossari extern:',
	'label:urls_arbo_sans_type' => 'Mostrar el tipus d\'objecte SPIP als URLs:',
	'label:urls_avec_id' => 'Un id sistem&agrave;tic, per&ograve;...',
	'label:urls_minuscules' => '@_CS_CHOIX@',
	'label:webmestres' => 'Llista dels webmestres del lloc:',
	'liens_en_clair:description' => 'Posa a la vostra disposici&oacute; el filtre: \'liens_en_clair\'. El vostre text cont&eacute; probablement enlla&ccedil;os que no s&oacute;n visibles durant la impressi&oacute;. Aquest filtre afegeix entre claud&agrave;tors el dest&iacute; de cada enlla&ccedil; clicable (enlla&ccedil;os externs o correus electr&ograve;nics). Atenci&oacute;: en mode impressi&oacute; (par&agrave;metre \'cs=print\' o \'page=print\' al url de la p&agrave;gina), aquesta funcionalitat s\'aplica autom&agrave;ticament.',
	'liens_en_clair:nom' => 'Enlla&ccedil;os visibles',
	'liens_orphelins:description' => 'Aquesta eina t&eacute; dues funcions:

@puce@ {{Enlla&ccedil;os correctes}}.

SPIP t&eacute; per costum inserir un espai abans dels interrogants o dels signes d\'exclamaci&oacute;, la tipografia francesa obliga. Aqu&iacute; teniu una eina que protegeix l\'interrogant als URLs dels vostres textos.[[%liens_interrogation%]]

@puce@ {{Enlla&ccedil;os orfes}}.

Substitueix sistem&agrave;ticament tots els URLs deixats en text pels usuaris (sobretot als f&ograve;rums), i que no s&oacute;n clicables, `per enlla&ccedil;os en format SPIP. Per exemple: {<html>www.spip.net</html>} queda substitu&iuml;t per [->www.spip.net].

Podeu escollir el tipus de substituci&oacute;:
_ • {B&agrave;sic}: s&oacute;n substitu&iuml;ts els enlla&ccedil;os del tipus {<html>http://spip.net</html>} (tot protocol) o {<html>www.spip.net</html>}.
_ • {Extens}: s&oacute;n substitu&iuml;ts a m&eacute;s els enlla&ccedil;os del tipus {<html>moi@spip.net</html>}, {<html>mailto:monmail</html>} o {<html>news:mesnews</html>}.
[[%liens_orphelins%]]_ • {Par defecte): substituci&oacute; autom&agrave;tica d\'origen (a partir de la versi&oacute; 2.0 d\'SPIP).
[[%liens_orphelins%]]',
	'liens_orphelins:nom' => 'URLs bonics',

	// M
	'mailcrypt:description' => 'Amaga tots els enlla&ccedil;os de correus presents als vostres textos substituint-los per un enlla&ccedil; JavaScript que permet malgrat tot activar la missatgeria del lector. Aquesta eina antispam impedeix que els robots recullin les adreces electr&ograve;niques deixades visibles als f&ograve;rums o a les etiquetes dels vostres esquelets.',
	'mailcrypt:nom' => 'MailCrypt',
	'message_perso' => 'Moltes gr&agrave;cies als traductors que passaran per aqu&iacute;. Pat ;-)',
	'moderation_admins' => 'administradors autenticats',
	'moderation_message' => 'Aquest f&ograve;rum est&agrave; moderat a priori: la vostra contribuci&oacute; no apareixer&agrave; fins que hagi estat validada per un administrador del lloc, excepte si esteu identificats i autoritzats per publicar-hi directament.',
	'moderation_moderee:description' => 'Permet moderar la moderaci&oacute; dels f&ograve;rums p&uacute;blics <b>configurats a priori</b> pels usuaris inscrits. <br />Exemple : Jo s&oacute;c el webmestre del meu lloc, i jo responc un missatge d\'un usuari, per qu&egrave; he de validar el meu propi missatge? Moderaci&oacute; moderada ho fa per mi! [[%moderation_admin%]][[-->%moderation_redac%]][[-->%moderation_visit%]]',
	'moderation_moderee:nom' => 'Moderaci&oacute; moderada ',
	'moderation_redacs' => 'redactors autenticats',
	'moderation_visits' => 'visitants autenticats',
	'modifier_vars' => 'Modificar aquests @nb@ par&agrave;metres',
	'modifier_vars_0' => 'Modificar aquests par&agrave;metres',

	// N
	'no_IP:description' => 'Desactiva el mecanisme d\'enregistrament autom&agrave;tic de les adreces IP dels visitants del vostre lloc per motius de confidencialitat: SPIP no conservar&agrave; m&eacute;s cap n&uacute;mero IP, ni temporalment, de les persones que us puguin visitar (per gestionar les estad&iacute;stiques o alimentar spip.log), ni en els f&ograve;rums (responsabilitat).',
	'no_IP:nom' => 'No emmagatzemar la IP',
	'nouveaux' => 'Nou',

	// O
	'orientation:description' => '3 nous criteris pels vostres esquelets: <code>{portrait}</code>, <code>{carre}</code> et <code>{paysage}</code>. Ideal per la classificaci&oacute; de les fotografies en funci&oacute; de la seva forma. ',
	'orientation:nom' => 'Orientaci&oacute; de les imatges',
	'outil_actif' => 'Eina activa',
	'outil_activer' => 'Activar',
	'outil_activer_le' => 'Activar l\'eina',
	'outil_cacher' => 'No visualitzar m&eacute;s',
	'outil_desactiver' => 'Desactivar',
	'outil_desactiver_le' => 'Desactivar l\'eina',
	'outil_inactif' => 'Eina inactiva',
	'outil_intro' => 'Aquesta p&agrave;gina llista les funcionalitats del plugin que teniu disponibles.<br /><br />Fent un clic damunt del nom de les eines que hi ha m&eacute;s avall, seleccioneu aquells als que podreu canviar l\'estat amb l\'ajuda del bot&oacute; central: les eines activades es desactivaran i <i>viceversa</i>. A cada clic, la descripci&oacute; apareix a sota de les llistes. Les categories s&oacute;n plegables i les eines es poden amagar.  El doble-clic permet de canviar l\'ordre r&agrave;pidament d\'una eina.<br /><br />Quan s\'usa per primer cop, &eacute;s recomanable activar les eines una a una, per si apareixen algunes incompatibilitats amb el vostre esquelet, amb SPIP o amb altres plugins.<br /><br />Nota: la simple c&agrave;rrega d\'aquesta p&agrave;gina torna a compilar el conjunt d\'eines del Ganivet Su&iacute;s.',
	'outil_intro_old' => 'Aquesta interf&iacute;cie &eacute;s antiga.<br /><br />Si trobeu problemes en l\'&uacute;s de la <a href=\'./?exec=admin_couteau_suisse\'>nova interf&iacute;cie</a>, no dubteu de dir-nos-ho al f&ograve;rum de <a href=\'https://contrib.spip.net/?article2166\'>Spip-Contrib</a>.',
	'outil_nb' => '@pipe@: @nb@ eina',
	'outil_nbs' => '@pipe@: @nb@ eines',
	'outil_permuter' => 'Intercanviar l\'eina: &laquo;@text@&raquo;?',
	'outils_actifs' => 'Eines actives:',
	'outils_caches' => 'Eines amagades:',
	'outils_cliquez' => 'Feu un clic sobre el nom de les eines que hi ha m&eacute;s amunt per mostrar aqu&iacute; la seva descripci&oacute;. ',
	'outils_inactifs' => 'Eines inactives:',
	'outils_liste' => 'Llista d\'eines del Ganivet Su&iacute;s',
	'outils_non_parametrables' => 'No paarametrable:',
	'outils_permuter_gras1' => 'Intercanviar les eines en negreta',
	'outils_permuter_gras2' => 'Intercanviar les @nb@ eines en negreta?',
	'outils_resetselection' => 'Reiniciar la selecci&oacute;',
	'outils_selectionactifs' => 'Seleccionar totes les eines actives',
	'outils_selectiontous' => 'TOTS',

	// P
	'pack_actuel' => 'Paquet @date@',
	'pack_actuel_avert' => 'Atenci&oacute;, les sobrec&agrave;rregues pels  define() o els globales no s\'especifiquen aqu&iacute;',
	'pack_actuel_titre' => 'PAQUET ACTUAL DE CONFIGURACI&Oacute; DEL GANIVET SU&Iacute;S',
	'pack_alt' => 'Veure els par&agrave;metres de configuraci&oacute; en curs',
	'pack_descrip' => 'El vostre &laquo;Pack de configuraci&oacute; actual&raquo; reuneix el conjunt dels par&agrave;metres de configuraci&oacute; en curs pel que fa al Ganivet Su&iacute;s: l\'activaci&oacute; d\'eines i el valor de les seves eventuals variables.

Si els drets d\'escriptura ho permeten, el codi PHP que hi ha m&eacute;s avall es podr&agrave; situar a dins del fitxer {{/config/mes_options.php}} i afegir&agrave; un enlla&ccedil; de tornar a carregar en aquesta p&agrave;gina del pack &laquo;&nbsp;{@pack@}&nbsp;&raquo;. Evidentment, podreu canviar el seu nom.

Si torneu a carregar el plugin fent un clic sobre un pack, el Ganivet Su&iacute;s es tornar&agrave; a configurar autom&agrave;ticament en funci&oacute; dels par&agrave;metres definits pr&egrave;viament en aquest pack.',
	'pack_du' => '• del pack @pack@',
	'pack_installe' => 'Instal&middot;laci&oacute; d\'un pack de configuraci&oacute;',
	'pack_installer' => 'Est&agrave; segur de voler reinicialitzar el Gavinet Su&iacute;s i d\'instal&middot;lar el pack &laquo;&nbsp;@pack@&nbsp;&raquo; ?',
	'pack_nb_plrs' => 'Actualment hi ha @nb@ &laquo;paquets de configuraci&oacute;&raquo; disponibles.',
	'pack_nb_un' => 'Actualment hi ha un &laquo;paquet de configuraci&oacute;&raquo; disponible',
	'pack_nb_zero' => 'No hi ha cap &laquo;paquet de configuraci&oacute;&raquo; disponible actualment.',
	'pack_outils_defaut' => 'Instal&middot;laci&oacute; d\'eines per defecte',
	'pack_sauver' => 'Salvar la configuraci&oacute; actual',
	'pack_sauver_descrip' => 'El bot&oacute; que hi ha m&eacute;s avall us permet inserir directament en el vostre fitxer <b>@file@</b> els par&agrave;metres necessaris per afegir un &laquo;paquet de configuraci&oacute;&raquo; al men&uacute; de l\'esquerre. Aix&ograve; us permetr&agrave; posteriorment tornar a configurar en un clic el vostre Ganivet Su&iacute;s en l\'estat en qu&egrave; es troba actualment. ',
	'pack_titre' => 'Configuraci&oacute; Actual',
	'pack_variables_defaut' => 'Instal&middot;laci&oacute; de variables per defecte',
	'par_defaut' => 'Per defecte',
	'paragrapher2:description' => 'La funci&oacute; SPIP <code>paragrapher()</code> insereix etiquetes &lt;p&gt; i &lt;/p&gt; a tots els textos que estan desprove&iuml;ts de par&agrave;grafs. Per tal de gestionar m&eacute;s finament els vostres estils i les vostres compaginacions, teniu la possibilitat d\'uniformitzar l\'aspecte dels textos del vostre lloc.[[%paragrapher%]]',
	'paragrapher2:nom' => 'Par&agrave;graf',
	'pipelines' => 'Pipelines utilitzades:',
	'pucesli:description' => 'Substitueix els car&agrave;cters &laquo;-&raquo; (guionet simple) dels articles per llistes numerades &laquo;-*&raquo; (tradu&iuml;des en HTML per: &lt;ul>&lt;li>…&lt;/li>&lt;/ul>) dels que l\'estil es pot personalitzar amb CSS.',
	'pucesli:nom' => 'Car&agrave;cters bonics',

	// Q
	'qui_webmestres' => 'Els Webmestres SPIP',

	// R
	'raccourcis' => 'Dreceres tipogr&agrave;fiques actives del Ganivet Su&iacute;s:',
	'raccourcis_barre' => 'Les dreceres tipogr&agrave;fiques del Ganivet Su&iacute;s',
	'reserve_admin' => 'Acc&eacute;s reservat als administradors.',
	'rss_actualiser' => 'Actualitzar',
	'rss_attente' => 'Esperant RSS...',
	'rss_desactiver' => 'Desactivar les &laquo;Revisions del Ganivet Su&iacute;s&raquo;',
	'rss_edition' => 'Flux RSS actualitzat el:',
	'rss_source' => 'Font RSS',
	'rss_titre' => '&laquo;El Ganivet Su&iacute;s&raquo; en desenvolupament:',
	'rss_var' => 'Les revisions del Ganivet Su&iacute;s',

	// S
	'sauf_admin' => 'Tots, excepte els administradors',
	'set_options:description' => 'Selecciona d\'entrada el tipus d\'interf&iacute;cie privada (simple o avan&ccedil;ada) per tots els redactors ja existents o per aquells que poden venir i suprimeix el bot&oacute; corresponent de la banda on hi ha les icones petites.[[%radio_set_options4%]]',
	'set_options:nom' => 'Tipus d\'interf&iacute;cie privada',
	'sf_amont' => 'M&eacute;s amunt',
	'sf_tous' => 'Tots',
	'simpl_interface:description' => 'Desactiva el men&uacute; de canvi r&agrave;pid de l\'estat d\'un article passant pel damunt del seu car&agrave;cter acolorit. Aix&ograve; &eacute;s &uacute;til si busqueu obtenir una interf&iacute;cie privada el m&eacute;s simple possible per tal d\'optimitzar les prestacions del client. ',
	'simpl_interface:nom' => 'Alleugeriment de la interf&iacute;cie privada',
	'smileys:aide' => 'Emoticones: @liste@',
	'smileys:description' => 'Insereix emoticones en tots els textos on apareix una drecera del tipus <acronym>:-)</acronym>. Ideal pels f&ograve;rums.
_ Hi ha una etiqueta per mostrar una taula d\'emoticones als vostres esquelets: #SMILEYS.
_ Dibuixos: [Sylvain Michel->http://www.guaph.net/]',
	'smileys:nom' => 'Emoticones',
	'soft_scroller:description' => 'Ofereix al vostre lloc p&uacute;blic un avan&ccedil;ament endolcit de la p&agrave;gina quan el visitant fa un clic damunt d\'un enlla&ccedil; que apunta a una &agrave;ncora: molt &uacute;til per evitar perdre\'s en una p&agrave;gina complexa o en un text molt llarg...

Alerta, aquesta eina necessita per funcionar p&agrave;gines al &laquo;DOCTYPE XHTML&raquo; (no HTML!) i dos plugins {jQuery}: {ScrollTo} i {LocalScroll}. El Ganivet Su&iacute;s els pot instal&middot;lar directament si marqueu les caselles seg&uuml;ents. [[%scrollTo%]][[->%LocalScroll%]]
@_CS_PLUGIN_JQUERY192@',
	'soft_scroller:nom' => '&Agrave;ncores suaus',
	'sommaire:description' => 'Construeix un sumari pel text dels vostres articles i les vostres seccions per tal d\'accedir r&agrave;pidament als titulars (balises HTML &lt;h3>Un subt&iacute;tol&lt;/h3> o dreceres SPIP: subt&iacute;tols del tipus:<code>{{{Un gran t&iacute;tol}}}</code>).

@puce@ Podeu definir aqu&iacute; el nombre m&agrave;xim de car&agrave;cters que es retindran dels subt&iacute;tols a l\'hora de construir el sumari:[[%lgr_sommaire% car&agrave;cters]]

@puce@ Tamb&eacute; podeu fixar el comportament del plugin en refer&egrave;ncia a la creaci&oacute; del sumari: 
_ • Sistem&agrave;ticament per cada article (una etiqueta <code>@_CS_SANS_SOMMAIRE@</code> situada a qualsevol lloc o a l\'interior del text de l\'article crear&agrave; una excepci&oacute;).
_ • Nom&eacute;s pels articles que continguin l\'etiqueta <code>@_CS_AVEC_SOMMAIRE@</code>.

[[%auto_sommaire%]]

@puce@ Per defecte, el Ganivet Su&iacute;s insereix el sumari a la cap&ccedil;alera de l\'article de forma autom&agrave;tica. Per&ograve; vosaltres teniu la possibilitat de situar-lo a qualsevol indret a dins del vostre esquelet gr&agrave;cies a una etiqueta #CS_SOMMAIRE que podeu activar aqu&iacute;:
[[%balise_sommaire%]]

Aquest sumari pot ser acoblat amb: &laquo;&nbsp;[.->decoupe]&nbsp;&raquo;.',
	'sommaire:nom' => 'Un sumari autom&agrave;tic',
	'sommaire_avec' => 'Un text amb sumari:  <b>@_CS_AVEC_SOMMAIRE@</b>',
	'sommaire_sans' => 'Un text sense sumari: <b>@_CS_SANS_SOMMAIRE@</b>',
	'spam:description' => 'Intenta lluitar contra els enviaments de missatges autom&agrave;tics i mal&egrave;vols a la part p&uacute;blica. Algunes paraules, com les etiquetes en clar &lt;a>&lt;/a>, estan prohibides: animeu als vostres redactors a fer servir les dreceres d\'enlla&ccedil;os SPIP.

Llisteu aqu&iacute; les seq&uuml;&egrave;ncies prohibides separant-les per espais. [[%spam_mots%]]
• Per una expressi&oacute; amb espais, poseu-la entre cometes.
_ • Per especificar una paraula sencera, poseu-la entre par&egrave;ntesi. Exemple~:~{(asses)}.
_ • Per una expressi&oacute; regular, verifiqueu b&eacute; la sintaxi i poseu-la entre barres inclinades i entre cometes. Exemple~:~{<html>"/@test\\.(com|fr)/"</html>}.',
	'spam:nom' => 'Lluita contra l\'SPAM',
	'spam_test_ko' => 'Aquest missatge ser&agrave; bloquejat pel filtre anti-SPAM!',
	'spam_test_ok' => 'Aquest missatge ser&agrave; acceptat pel filtre anti-SPAM.',
	'spam_tester' => 'Llen&ccedil;ar el test!',
	'spam_tester_label' => 'Verifiqueu aqu&iacute; la vostra llista de seq&uuml;&egrave;ncies prohibides:',
	'spip_cache:description' => '@puce@ La mem&ograve;ria cau ocupa un cert espai de disc i SPIP pot limitar-me la import&agrave;ncia. Un valor buit o igual a 0 significa que no s\'aplica cap quota.[[%quota_cache% Mo]]

@puce@ Quan s\'ha fet una modificaci&oacute; del lloc, SPIP invalida immediatament la mem&ograve;ria cau sense esperar el c&agrave;lcul peri&ograve;dic seg&uuml;ent. Si el vostre lloc t&eacute; problemes de presentaci&oacute; com a conseq&uuml;&egrave;ncia d\'una c&agrave;rrega molt elevada, podeu marcar &laquo;&nbsp;non&nbsp;&raquo; en aquesta opci&oacute;. [[%derniere_modif_invalide%]]

@puce@ Si l\'etiqueta #CACHE no es troba als vostres esquelets locals, SPIP considera per defecte que la mem&ograve;ria cau d\'una p&agrave;gina t&eacute; una validesa de 24 hores abans de tornar-la a calcular. Per tal de gestionar millor la c&agrave;rrega del vostre servidor, podeu modificar aqu&iacute; aquest valor.[[%duree_cache% heures]]

@puce@ Si teniu diversos llocs mutualitzats, podeu especificar aqu&iacute; el valor per defecte que es tindr&agrave; en compte per tots els llocs locals (SPIP 2.0 mini).[[%duree_cache_mutu% heures]]',
	'spip_cache:description1' => '@puce@ Per defecte, SPIP calcula totes les p&agrave;gines p&uacute;bliques i les col&middot;loca a la mem&ograve;ria cau per tal d\'accelerar-ne la consulta. Desactivar temporalment la mem&ograve;ria cau pot ajudar al desenvolupament del lloc Web. @_CS_CACHE_EXTENSION@[[%radio_desactive_cache3%]]',
	'spip_cache:description2' => '@puce@ Quatre opcions per orientar el funcionament de la mem&ograve;ria cau d\'SPIP : <q1>
_ • {&Uacute;s normal}: SPIP calcula totes les p&agrave;gines publiques i les posa a la mem&ograve;ria cau per tal d\'accelerar-ne la consulta. Despr&eacute;s d\'un cert termini, la mem&ograve;ria cau es calcula de nou i s\'emmagatzema.
_ • {Mem&ograve;ria cau permanent}: els terminis d\'invalidaci&oacute; de la mem&ograve;ria cau s\'ignoren.
_ • {Sense mem&ograve;ria cau}: desactivar temporalment la mem&ograve;ria cau pot ajudar al desenvolupament del lloc Web. Aqu&iacute;, no s\'emmagatzema res al disc.
_ • {Control de la mem&ograve;ria cau}: opci&oacute; id&egrave;ntica a l\'anterior, amb una escriptura al disc de tots els resultats per tal de poder, eventualment, controlar-los.</q1>[[%radio_desactive_cache4%]]',
	'spip_cache:nom' => 'SPIP i la mem&ograve;ria cau…',
	'stat_auteurs' => 'Els autors en stat',
	'statuts_spip' => 'Nom&eacute;s els statuts SPIP seg&uuml;ents:',
	'statuts_tous' => 'Tots els statuts',
	'suivi_forums:description' => 'Un autor d\'un article est&agrave; sempre informat quan es publica un missatge al f&ograve;rum que aquest t&eacute; associat. Per&ograve;, a m&eacute;s, tamb&eacute; es possible advertir a: tots els participants al f&ograve;rum o nom&eacute;s als autors dels missatges en endavant.[[%radio_suivi_forums3%]]',
	'suivi_forums:nom' => 'Seguiment dels f&ograve;rums p&uacute;blics',
	'supprimer_cadre' => 'Suprimir aquest quadre',
	'supprimer_numero:description' => 'Aplica la funci&oacute; SPIP supprimer_numero() al conjunt dels {{t&iacute;tols}}, dels {{noms}} i dels {{tipus}} (de paraules-clau) del lloc p&uacute;blic, sense que el filtre supprimer_numero estigui present als esquelets.<br />Heus aqu&iacute; la sintaxis que cal utilitzar en el marc d\'un lloc multilingue : <code>1. <multi>My Title[fr]Mon Titre[de]El Meu T&iacute;tol</multi></code>',
	'supprimer_numero:nom' => 'Suprimeix el n&uacute;mero',

	// T
	'titre' => 'El Ganivet Su&iacute;s',
	'titre_parent:description' => 'Al si d\'un bucle, &eacute;s corrent voler mostrar el t&iacute;tol del parent de l\'objecte en curs. Tradicionalment, n\'hi hauria prou utilitzant un segon bucle, per&ograve; aquesta nova etiqueta #TITRE_PARENT alleugerar&agrave; l\'escriptura dels vostres esquelets. El resultat que torna &eacute;s: el t&iacute;tol del grup d\'una paraula clau o el de la secci&oacute; parenta (si existeix) de qualsevol altre objecte (article, secci&oacute;, breu, etc.).

Anoteu: Per les paraules clau, un &agrave;lies de #TITRE_PARENT &eacute;s #TITRE_GROUPE. El tractament SPIP d\'aquestes noves etiquetes &eacute;s similar al de #TITRE.

@puce@ Si treballeu sota SPIP 2.0, llavors teniu aqu&iacute;, a la vostra disposici&oacute;, tot un conjunt d\'etiquetes #TITRE_XXX que podran donar-vos el t&iacute;tol de l\'objecte \'xxx\', a condici&oacute; que el camp \'id_xxx\' estigui present a la taula en curs (#ID_XXX utilitzable en el bucle en curs).

Per exemple, en un bucle sobre (ARTICLES), #TITRE_SECTEUR donar&agrave; el t&iacute;tol del sector en el que est&agrave; situat l\'article en curs, ja que l\'identificador #ID_SECTEUR (o el camp \'id_secteur\') est&agrave; disponible en aquest cas.

La sintaxi <html>#TITRE_XXX{yy}</html> se suporta igualment. Exemple: <html>#TITRE_ARTICLE{10}</html> retornar&agrave; el t&iacute;tol de l\'article #10.[[%titres_etendus%]]',
	'titre_parent:nom' => 'Etiqueta #TITRE_PARENT/OBJET',
	'titre_tests' => 'El Ganivet Su&iacute;s - P&agrave;gina de proves…',
	'tous' => 'Tots',
	'toutes_couleurs' => 'Els 36 colors dels estils CSS :@_CS_EXEMPLE_COULEURS@',
	'toutmulti:aide' => 'Blocs multiling&uuml;es&nbsp;: <b><:trad:></b>',
	'toutmulti:description' => 'De manera semblant al que ja podeu fer en els vostres esquelets, aquesta eina us permet utilitzar lliurement les cadenes de lleng&uuml;es (d\'SPIP o dels vostres esquelets) en tots els continguts del vostre lloc Web (articles, t&iacute;tols, missatges, etc.) amb l\'ajuda de la drecera <code><:chaine:></code>.
 
Consulteu [aqu&iacute; ->https://www.spip.net/ca_article2191.html] la documentaci&oacute; d\'SPIP que fa refer&egrave;ncia a aquest tema.

Aquesta eina accepta igualment els arguments introdu&iuml;ts per SPIP 2.0. Per exemple, la drecera <:ma_chaine{nom=Charles Martin, age=37}:></code> permet passar dos par&agrave;metres a la seg&uuml;ent cadena: <code>\'ma_chaine\'=>"Bonjour, je suis @nom@ et j\'ai @age@ ans\\"</code>.

La funci&oacute; SPIP utilitzada en PHP &eacute;s <code>_T(\'chaine\')</code> sense argument, i <code>_T(\'chaine\', array(\'arg1\'=>\'un texte\', \'arg2\'=>\'un autre texte\'))</code> amb arguments.
 
Per tant, no oblideu verificar que la clau  <code>\'chaine\'</code> est&agrave; ben definida en els fitxers de lleng&uuml;es. ',
	'toutmulti:nom' => 'Blocs multiling&uuml;es',
	'travaux_nom_site' => '@_CS_NOM_SITE@',
	'travaux_prochainement' => 'Aquest lloc es restablir&agrave; ben aviat.
_ Gr&agrave;cies per la vostra comprensi&oacute;.',
	'travaux_titre' => '@_CS_TRAVAUX_TITRE@',
	'tri_articles:description' => 'Navegant pel lloc a la part privada ([->./?exec=auteurs]), escolliu aqu&iacute; la tria que es far&agrave; servir per mostrar els vostres articles a dins de les vostres seccions.

Les propostes que hi han m&eacute;s avall estan basades en la funcionalitat SQL \'ORDER BY\': nom&eacute;s utilitzeu la opci&oacute; personalitzada si sabeu qu&egrave; feu (camps disponibles: {id_article, id_rubrique, titre, soustitre, surtitre, statut, date_redac, date_modif, lang, etc.})
[[%tri_articles%]][[->%tri_perso%]]',
	'tri_articles:nom' => 'Opcions dels articles',
	'tri_modif' => 'Tria sobre la data de modificaci&oacute; (ORDER BY date_modif DESC)',
	'tri_perso' => 'Tria SQL personalitzada, ORDER BY seguit de:',
	'tri_publi' => 'Tria sobre la data de publicaci&oacute; (ORDER BY date DESC)',
	'tri_titre' => 'Tria sobre el t&iacute;tol (ORDER BY 0+titre,titre)',
	'trousse_balises:description' => 'Eina en curs de desenvolupament. Us ofereix algunes etiquetes molt simples i pr&agrave;ctiques per millorar la llegibilitat dels vostres esquelets.

@puce@ {{#BOLO}}: genere un text fals d\'uns 3000 car&agrave;cters ("bolo" ou "lorem ipsum") a l\'esquelet mentre el posem a punt. L\'argument opcional d\'aquesta funci&oacute; especifica la llargada que volem del text. Exemple: <code>#BOLO{300}</code>. Aquesta etiqueta accepta tots els filtres d\'SPIP. Exemple : <code>[(#BOLO|majuscules)]</code>.
_ Tamb&eacute; teniu un model disponible pels vostres continguts: situeu <code><bolo300></code> a qualsevol zona del text (cap&ccedil;alera, descripci&oacute;, text, etc.) per obtenir 300 car&agrave;cters de text fals.

@puce@ {{#MAINTENANT}} (o {{#NOW}}): torna simplement la data del moment, com: <code>#EVAL{date(\'Y-m-d H:i:s\')}</code>. L\'argument opcional d\'aquesta funci&oacute; especifica el format. Exemple : <code>#MAINTENANT{Y-m-d}</code>. Tal i com amb #DATE, personalitzeu la publicaci&oacute; gr&agrave;cies als filtres d\'SPIP. Exemple: <code>[(#MAINTENANT|affdate)]</code>.

- {{#CHR<html>{XX}</html>}}: etiqueta equivalent a <code>#EVAL{"chr(XX)"}</code> i pr&agrave;ctica per codificar car&agrave;cters especials (el canvi de l&iacute;nia, per exemple) o dels car&agrave;cters reservats pel compilador d\'SPIP (els claud&agrave;tors o les claus).

@puce@ {{#LESMOTS}}: ',
	'trousse_balises:nom' => 'Joc d\'etiquetes',
	'type_urls:description' => '@puce@ SPIP ofereix la possibilitat d\'escollir entre diversos jocs d\'URLs per fabricar els enlla&ccedil;os d\'acc&eacute;s a les p&agrave;gines del vostre lloc:

M&eacute;s informacions a: [->https://www.spip.net/ca_article2237.html]. L\'eina &laquo;&nbsp;[.->boites_privees]&raquo; us permet veure a la p&agrave;gina de cada objecte SPIP el URL propi associat.
[[%radio_type_urls3%]]
<q3>@_CS_ASTER@per utilitzar els formats {html}, {propre}, {propre2}, {libres} o {arborescentes}, torneu a copiar el fitxer "htaccess.txt" del directori de base del lloc SPIP amb el nom ".htaccess" (alerta a no esborrar altres ajustos que pogu&eacute;ssiu haver posat a dins d\'aquest fitxer) ; si el vostre lloc est&agrave; en un "subdirectori", haureu tamb&eacute; d\'editar la l&iacute;nia "RewriteBase" a aquest fitxer. Els URLs definit seran dirigits llavors cap els fitxer d\'SPIP.</q3>

<radio_type_urls3 valeur="page">@puce@ {{URLs &laquo;page&raquo;}} : aquests s&oacute;n els enlla&ccedil;os per defecte que utilitza SPIP a partir de la seva versi&oacute; 1.9x.
_ Exemple : <code>/spip.php?article123</code>[[%terminaison_urls_page%]][[%separateur_urls_page%]]</radio_type_urls3>

<radio_type_urls3 valeur="html">@puce@ {{URLs &laquo;html&raquo;}} : els enlla&ccedil;os tenen la forma de les p&agrave;gines html cl&agrave;siques.
_ Exemple : <code>/article123.html</code></radio_type_urls3>

<radio_type_urls3 valeur="propres">@puce@ {{URLs &laquo;propres&raquo;}} : els enlla&ccedil;os es calculen gr&agrave;cies al t&iacute;tol dels objectes demananats. Marcadors (_, -, +, @, etc.) emmarquen els t&iacute;tols en funci&oacute; del tipus d\'objecte.
_ Exemples : <code>/Mon-titre-d-article</code> ou <code>/-Ma-rubrique-</code> ou <code>/@Mon-site@</code>[[%terminaison_urls_propres%]][[%debut_urls_propres%]][[%marqueurs_urls_propres%]]</radio_type_urls3>

<radio_type_urls3 valeur="propres2">@puce@ {{URLs &laquo;propres2&raquo;}} : l\'extensi&oacute; \'.html\' s\'afegeix als enlla&ccedil;os {&laquo;propis&raquo;}.
_ Exemple : <code>/Mon-titre-d-article.html</code> ou <code>/-Ma-rubrique-.html</code>
[[%debut_urls_propres2%]][[%marqueurs_urls_propres2%]]</radio_type_urls3>

<radio_type_urls3 valeur="libres">@puce@ {{URLs &laquo;libres&raquo;}}: els enlla&ccedil;os s&oacute;n {&laquo;propis&raquo;}, per&ograve; sense marcadors que dissoci&iuml;n els objectes (_, -, +, @, etc.).
_ Exemple : <code>/Mon-titre-d-article</code> ou <code>/Ma-rubrique</code>
[[%terminaison_urls_libres%]][[%debut_urls_libres%]]</radio_type_urls3>

<radio_type_urls3 valeur="arbo">@puce@ {{URLs &laquo;arborescentes&raquo;}} : els enlla&ccedil;os s&oacute;n {&laquo;propis&raquo;}, per&ograve; del tipus arborescent.
_ Exemple : <code>/secteur/rubrique1/rubrique2/Mon-titre-d-article</code>
[[%url_arbo_minuscules%]][[%urls_arbo_sans_type%]][[%url_arbo_sep_id%]][[%terminaison_urls_arbo%]]</radio_type_urls3>

<radio_type_urls3 valeur="propres-qs">@puce@ {{URLs &laquo;propres-qs&raquo;}} : aquest sistema funciona en "Query-String", &eacute;s a dir sense utilitzar d\'.htaccess; els enlla&ccedil;os s&oacute;n {&laquo;propis&raquo;}.
_ Exemple : <code>/?Mon-titre-d-article</code>
[[%terminaison_urls_propres_qs%]]</radio_type_urls3>

<radio_type_urls3 valeur="propres_qs">@puce@ {{URLs &laquo;propres_qs&raquo;}} : aquest sistema funciona en "Query-String", &eacute;s a dir sense la utilitzaci&oacute; d\'.htaccess ; els enlla&ccedil;os s&oacute;n {&laquo;propis&raquo;}.
_ Exemple : <code>/?Mon-titre-d-article</code>
[[%terminaison_urls_propres_qs%]][[%marqueurs_urls_propres_qs%]]</radio_type_urls3>

<radio_type_urls3 valeur="standard">@puce@ {{URLs &laquo;standard&raquo;}} : aquests enlla&ccedil;os, a partir d\'ara obsolets, eren utilitzats per SPIP fins a la seva versi&oacute; 1.8.
_ Exemple : <code>article.php3?id_article=123</code>
</radio_type_urls3>

@puce@ Si utilitzeu el format {page} que hi ha m&eacute;s amunt o si l\'objecte demanat no &eacute;s reconegut, &eacute;s possible llavors escollir {{l\'script de crida}} a SPIP. Per defecte, SPIP escull {spip.php}, per&ograve; {index.php} (exemple de format : <code>/index.php?article123</code>) o un valor buit (format: <code>/?article123</code>) tamb&eacute; funcionen. Per qualsevol altre valor, heu de crear for&ccedil;osament el fitxer corresponent a l\'arrel d\'SPIP, semblant al que ja existeix: {index.php}.
[[%spip_script%]]',
	'type_urls:description1' => '@puce@ Si voleu fer servir un format a base d\'URLs &laquo;pr&ograve;pies&raquo; ({propres}, {propres2}, {libres}, {arborescentes} o {propres_qs}), el Ganivet Su&iacute;s pot:
 <q1>• Assegurar-se que l\'URL produ&iuml;da estigui totalment {{en min&uacute;scules}}.</q1>[[%urls_minuscules%]]
<q1>• Provocar l\'afegit sistem&agrave;tic de {{l\'id de l\'objecte}} al seu URL (en sufix, en prefix, etc.).
_ (exemples: <code>/El-meu-t&iacute;tol-d-article,457</code> o <code>/457-El-meu-t&iacute;tol-d-article</code>)</q1>',
	'type_urls:nom' => 'Format dels URLs',
	'typo_exposants:description' => '((Textos francesos)): millora el retorn tipogr&agrave;fic de les abreviacions corrents, exposant els elements necessaris (aix&iacute;, {<acronym>Mme</acronym>} esdev&eacute; {M<sup>me</sup>}) i corregint-ne els errors normals ({<acronym>2&egrave;me</acronym>} o  {<acronym>2me</acronym>}, per exemple, esdevenen {2<sup>e</sup>}, &uacute;nica abreviaci&oacute; correcta).

Les abreviacions obtingudes s\'ajusten a les de la Impremta nacional tal com s\'indiquen al {L&egrave;xic de les regles tipogr&agrave;fiques en &uacute;s a la Impremta nacional} (article &laquo;&nbsp;Abr&eacute;viations&nbsp;&raquo;, presses de l\'Imprimerie nationale, Paris, 2002).

Tamb&eacute; es tracten les seg&uuml;ents expressions: : <html>Dr, Pr, Mgr, m2, m3, Mn, Md, St&eacute;, &Eacute;ts, Vve, Cie, 1o, 2o, etc.</html> 

Podeu escollir aqu&iacute; de posar en exponent algunes dreceres suplement&agrave;ries, malgrat la opini&oacute; desfavorable de la Impremta nacional:[[%expo_bofbof%]]

 {{Textos anglesos}} : posar en exponent els n&uacute;meros ordinals: <html>1st, 2nd</html>, etc.',
	'typo_exposants:nom' => 'Super&iacute;ndexs',

	// U
	'url_arbo' => 'arborescents@_CS_ASTER@',
	'url_html' => 'html@_CS_ASTER@',
	'url_libres' => 'libres@_CS_ASTER@',
	'url_page' => 'p&agrave;gina',
	'url_propres' => 'propres@_CS_ASTER@',
	'url_propres-qs' => 'propres-qs',
	'url_propres2' => 'propres2@_CS_ASTER@',
	'url_propres_qs' => 'propres_qs',
	'url_standard' => 'est&agrave;ndard',
	'urls_3_chiffres' => 'Imposar un m&iacute;nim de 3 xifres',
	'urls_avec_id' => 'Posar-la en sufix ',
	'urls_avec_id2' => 'Posar-la en prefix',
	'urls_base_total' => 'Actualment hi ha @nb@ URL(s) a la base',
	'urls_base_vide' => 'La base dels URLs est&agrave; buida',
	'urls_choix_objet' => 'Edici&oacute; en la base del URL d\'un objecte espec&iacute;fic:',
	'urls_edit_erreur' => 'El format actual dels URLs (&laquo;&nbsp;@type@&nbsp;&raquo;) no permet l\'edici&oacute;.',
	'urls_enregistrer' => 'Enregistrar aquest URL a la base',
	'urls_id_sauf_rubriques' => 'Excloure les seccions',
	'urls_minuscules' => 'Lletres min&uacute;scules',
	'urls_nouvelle' => 'Editar el URL &laquo;propis&raquo;:',
	'urls_num_objet' => 'N&uacute;mero:',
	'urls_purger' => 'Buidar-ho tot',
	'urls_purger_tables' => 'Buidar les taules seleccionades',
	'urls_purger_tout' => 'Iniciar altre cop els URLs emmagatzemats a la base:',
	'urls_rechercher' => 'Cercar aquest objecte a la base',
	'urls_titre_objet' => 'T&iacute;tol enregistrat:',
	'urls_type_objet' => 'Objecte:',
	'urls_url_calculee' => 'URL p&uacute;blica &laquo;&nbsp;@type@&nbsp;&raquo;&nbsp;:',
	'urls_url_objet' => 'URL &laquo;propis&raquo; enregistrat:',
	'urls_valeur_vide' => '(Un valor buit provoca que es torni a calcular l\'URL)',

	// V
	'validez_page' => 'Per accedir a les modificacions:',
	'variable_vide' => '(Buit)',
	'vars_modifiees' => 'Les dades s\'han modificat correctament',
	'version_a_jour' => 'La vostra versi&oacute; est&agrave; al dia.',
	'version_distante' => 'Versi&oacute; distant...',
	'version_distante_off' => 'Verificaci&oacute; distant desactivada',
	'version_nouvelle' => 'Nova versi&oacute;: @version@',
	'version_revision' => 'R&eacute;visi&oacute;: @revision@',
	'version_update' => 'Actualitzaci&oacute; autom&agrave;tica',
	'version_update_chargeur' => 'Desc&agrave;rrega autom&agrave;tica',
	'version_update_chargeur_title' => 'Descarrega la darrera versi&oacute; del plugin gr&agrave;cies al plugin &laquo;Descarregador&raquo;',
	'version_update_title' => 'Descarrega l\'&uacute;ltima versi&oacute; del plugin i comen&ccedil;ar la seva actualitzaci&oacute; autom&agrave;tica',
	'verstexte:description' => '2 filtres pels vostres esquelets, permetent produir p&agrave;gines m&eacute;s lleugeres.
_ version_texte: extreu el contingut text d\'una p&agrave;gina html excepte algunes etiquetes elementals.
_ version_plein_texte : extreu el contingut text d\'una p&agrave;gina html per retornar text brut. ',
	'verstexte:nom' => 'Versi&oacute; text',
	'visiteurs_connectes:description' => 'Ofereix una petita eina pel vostre esquelet que mostra el n&uacute;mero de visitants que hi ha connectats al vostre lloc p&uacute;blic.

Afegiu simplement <code><INCLURE{fond=fonds/visiteurs_connectes}></code> a les vostres p&agrave;gines.',
	'visiteurs_connectes:nom' => 'Visitants connectats',
	'voir' => 'Veure: @voir@',
	'votre_choix' => 'La vostre elecci&oacute;:',

	// W
	'webmestres:description' => 'Un {{webmestre}} en el sentit d\'SPIP &eacute;s un {{administrador}} que t&eacute; acc&eacute;s a l\'espai FTP. Per defecte i a partir d\'SPIP 2.0, &eacute;s l\'administrador <code>id_auteur=1</code> del lloc. Els webmestres definitis aqu&iacute; tenen el privilegi de no estar obligats a passar pel FTP per validar les operacions sensibles del lloc, com l\'actualitzaci&oacute; de la base de dades o la restauraci&oacute; d\'un dump.

Webmestre(s) actual(s): {@_CS_LISTE_WEBMESTRES@}.
_ Administrador(s) elegible(s): {@_CS_LISTE_ADMINS@}.

Vosaltres mateixos, com a webmestres, teniu els drets de modificar aquesta llista d\'ids -- separats pels dos punts &laquo;&nbsp;:&nbsp;&raquo; si s&oacute;n diversos. Exemple: &laquo;1:5:6&raquo;.[[%webmestres%]]',
	'webmestres:nom' => 'Llista de webmestres',

	// X
	'xml:description' => 'Activa el validador xml per l\'espai p&uacute;blic tal i com est&agrave; descrit a la [documentaci&oacute;->https://www.spip.net/ca_article3577.html]. Un bot&oacute; anomenat &laquo;&nbsp;An&agrave;lisi XML&nbsp;&raquo; s\'afegeix als altres botons d\'administraci&oacute;.',
	'xml:nom' => 'Validador XML'
);

?>
