<?php

#---------------------------------------------------#
#  Plugin  : Tweak SPIP                             #
#  Auteur  : Patrice Vanneufville, 2006             #
#  Contact : patrice�.!vanneufville�@!laposte�.!net #
#  Licence : GPL                                    #
#  Infos : http://www.spip-contrib.net/?article1554 #
#---------------------------------------------------#

global $tweaks, $tweaks_pipelines, $tweaks_css, $tweak_exclude;
$tweaks = $tweaks_pipelines = $tweaks_css = $tweak_exclude = array();

//-----------------------------------------------------------------------------//
//                               options                                       //
//-----------------------------------------------------------------------------//

add_tweak( array(
	'nom'			=> 'D&eacute;sactiver le cache',
	'description' 	=> 'Inhibition du cache de SPIP pour le d&eacute;veloppement du site.',
	'auteur' 		=> '[Cedric MORIN->mailto:cedric.morin@yterium.com]',
	'include' 		=> 'desactiver_cache',
	'categorie'		=> _T('tweak:admin'),
	// tweak a inserer dans les options
	'options'		=> 1,
));

add_tweak( array(
	'nom'			=> 'Supprimer le num&eacute;ro',
	'description' 	=> "Applique la fonction SPIP supprimer_numero() &agrave; l'ensemble des titres du site, sans qu'elle soit pr&eacute;sente dans les squelettes.",
	'include' 		=> 'supprimer_numero',
	'categorie'		=> _T('tweak:admin'),
	// tweak a inserer dans les options
	'options'		=> 1
));

add_tweak( array(
	'nom'			=> 'Paragrapher',
	'description' 	=> "Applique la fonction SPIP paragrapher() aux textes qui sont d&eacute;pourvus de paragraphes en ins�rant des balises &lt;p&gt;.",
	'include' 		=> 'paragrapher',
	'categorie'		=> _T('tweak:admin'),
	// tweak a inserer dans les options
	'options'		=> 1
));

//-----------------------------------------------------------------------------//
//                               fonctions                                     //
//-----------------------------------------------------------------------------//

add_tweak( array(
	'nom'			=> 'Version texte',
	'description' 	=> "2 filtres pour vos squelettes. 
_ version_texte : extrait le contenu texte d'une page html &agrave; l'exclusion de quelques balises &eacute;l&eacute;mentaires.
_ version_plein_texte : extrait le contenu texte d'une page html pour rendre du texte plein.",
	'auteur' 		=> '[Cedric MORIN->mailto:cedric.morin@yterium.com]',
	'include' 		=> 'verstexte_fonctions',
	// tweak a inserer dans les fonctions
	'fonctions'		=> 1,
));

add_tweak( array(
	'nom'			=> 'Orientation des images',
	'description' 	=> "3 nouveauw crit&egrave;res pour vos squelettes : <code>{portrait}</code>, <code>{carre}</code> et <code>{paysage}</code>. Id&egrave;al pour le classement des photos en fonction de leur forme.
_ Infos : [->http://www.spip-contrib.net/Portrait-ou-Paysage]",
	'auteur' 		=> 'Pierre Andrews (Mortimer) &amp; IZO',
	'include' 		=> 'orientation',
	// tweak a inserer dans les fonctions
	'fonctions'		=> 1,
));


//-----------------------------------------------------------------------------//
//                               PUBLIC                                        //
//-----------------------------------------------------------------------------//

// TODO : gestion du jQuery dans la fonction � revoir ?
add_tweak( array(
	'nom'			=> 'D&eacute;sactiver les objects flash',
	'description' 	=> 'Supprime les objets flash des pages de votre site et les remplace par le contenu alternatif associ&eacute;.
_ N&eacute;cessite le plugin {jQuery} ou une version de SPIP sup&eacute;rieure � 1.9.2.',
	'auteur' 		=> '[Cedric MORIN->mailto:cedric.morin@yterium.com]',
	'include' 		=> 'desactiver_flash',
	'categorie'		=> _T('tweak:admin'),
	// pipeline => fonction
	'affichage_final' => 'InhibeFlash_affichage_final',
));

//-----------------------------------------------------------------------------//
//                               TYPO                                          //
//-----------------------------------------------------------------------------//

add_tweak( array(
	'nom'			=> 'Tout multi',
	'description' 	=> "Introduit le raccourci &lt;:un_texte:&gt; pour introduire librement des blocs multi-langues dans un article.
_ La fonction SPIP utilis&eacute;e est : _T('un_texte', \$flux).
_ N'oubliez pas de v&eacute;rifier que 'un_texte' est bien d&eacute;fini dans les fichiers de langue.",
	'auteur' 		=> '',
	'include' 		=> 'toutmulti',
	'categorie'		=> _T('tweak:typo'),
	// pipeline => fonction
	'pre_typo'	=> 'ToutMulti_pre_typo',
));

add_tweak( array(
	'nom'			=> 'Belles puces',
	'description' 	=> 'Remplace les puces - (tiret) des articles par des puces -* (&lt;li>...)',
	'auteur' 		=> '[J&eacute;r&ocirc;me Combaz->http://conseil-recherche-innovation.net/index.php/2000/07/08/72-jerome-combaz]',
	'include' 		=> 'bellespuces',
	'categorie'		=> _T('tweak:typo'),
	// pipeline => fonction
	'pre_typo' => 'bellespuces_pre_typo',
));	

add_tweak( array(
	'nom'			=> 'D&eacute;coration',
	'description' 	=> "7 nouveaux styles dans vos articles : <sc>capitales</sc>, <souligne>soulign&eacute;</souligne>, <barre>barr&eacute;</barre>, <dessus>dessus</dessus>, <clignote>clignote</clignote>, <surfluo>fluo</surfluo> et <surgris>gris&eacute;</surgris>. Utilisation :
-* {&lt;sc&gt;}Lorem ipsum dolor sit amet{&lt;/sc&gt;}
-* {&lt;souligne&gt;}Lorem ipsum dolor sit amet{&lt;/souligne&gt;}
-* {&lt;barre&gt;}Lorem ipsum dolor sit amet{&lt;/barre&gt;}
-* {&lt;dessus&gt;}Lorem ipsum dolor sit amet{&lt;/dessus&gt;}
-* {&lt;clignote&gt;}Lorem ipsum dolor sit amet{&lt;/clignote&gt;}
-* {&lt;surfluo&gt;}Lorem ipsum dolor sit amet{&lt;/surfluo&gt;}
-* {&lt;surgris&gt;}Lorem ipsum dolor sit amet{&lt;/surgris&gt;}

Infos : [->http://www.spip-contrib.net/?article1552]",
	'auteur' 		=> '[izo@aucuneid.net->http://www.aucuneid.com/bones]',
	'include' 		=> 'decoration',
	'categorie'		=> _T('tweak:typo'),
	// pipeline => fonction
	'pre_typo' => 'decoration_pre_typo',
));

add_tweak( array(
	'nom'			=> 'Mises en exposant',
	'description' 	=> "Textes fran&ccedil;ais : am&eacute;liore le rendu typographique des abr&eacute;viations courantes, en mettant en exposant les &eacute;l&eacute;ments n&eacute;cessaires (ainsi, {<acronym>Mme</acronym>} devient {M<sup>me</sup>}) et en corrigeant les erreurs courantes ({<acronym>2&egrave;me</acronym>} ou  {<acronym>2me</acronym>}, par exemple, deviennent {2<sup>e</sup>}, seule abr&eacute;viation correcte).
_ Les abr&eacute;viations obtenues sont conformes &agrave; celles de l'Imprimerie nationale telles qu'indiqu&eacute;es dans le {Lexique des r&egrave;gles typographiques en usage &agrave; l'Imprimerie nationale} (article &laquo;&nbsp;Abr&eacute;viations&nbsp;&raquo;, presses de l'Imprimerie nationale, Paris, 2002).
_ Infos : [->http://www.spip-contrib.net/?article1564]",
	'auteur' 		=> 'Vincent Ramos [contact->mailto:www-lansargues@kailaasa.net]',
	'include' 		=> 'typo_exposants',
	'categorie'		=> _T('tweak:typo'),
	// pipeline => fonction
	'post_typo'	=> 'typo_exposants',
));

add_tweak( array(
	'nom'			=> 'Filets de S&eacute;paration',
	'description' 	=> "Ins&egrave;re des filets de s&eacute;paration, personnalisables par des feuilles de style, dans tous les textes de Spip.
_ La syntaxe est : &quot;__code__&quot;, o&ugrave; &quot;code&quot; repr&eacute;sente soit le num&eacute;ro d&rsquo;identification (de 0 &agrave; 7) du filet &agrave; ins&eacute;rer en relation directe avec les styles correspondants, soit le nom d'une image plac&eacute;e dans le dossier img/filets.
_ Infos : [->http://www.spip-contrib.net/?article1563]",
	'auteur' 		=> 'FredoMkb',
	'include' 		=> 'filets_sep',
	'categorie'		=> _T('tweak:typo'),
	// pipeline => fonction
	'pre_typo'	=> 'filets_sep',
));

add_tweak( array(
	'nom'			=> 'Smileys',
	'description' 	=> "Ins&egrave;re des smileys dans tous les textes o&ugrave; apparait un raccourci du genre <acronym>:-)</acronym>. Id&eacute;al pour les  forums.
_ Infos : [->http://www.spip-contrib.net/?article1561]",
	'auteur' 		=> 'Sylvain',
	'include' 		=> 'smileys',
	'categorie'		=> _T('tweak:typo'),
	// pipeline => fonction
	'pre_typo'	=> 'tweak_smileys',
));

// Id�es d'ajouts :
// http://www.spip-contrib.net/Citations
// http://www.spip-contrib.net/la-balise-LESMOTS
// http://www.spip-contrib.net/Ajouter-une-lettrine-aux-articles

//-----------------------------------------------------------------------------//
//                        activation des tweaks                                //
//-----------------------------------------------------------------------------//

// exclure ce qui n'est pas un pipeline...
$tweak_exclude = array('nom', 'description', 'auteur', 'categorie', 'include', 'options', 'fonctions', 'actif');

// lire les metas et initialiser : $tweaks_pipelines, $tweaks_css
tweak_lire_metas();

?>