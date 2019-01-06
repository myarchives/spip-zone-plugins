<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// extrait automatiquement de https://trad.spip.net/tradlang_module/menus?lang_cible=en
// ** ne pas modifier le fichier **

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'ajouter_lien_menu' => 'Add this menu',

	// C
	'configurer_entrees_masquees_explication' => 'Indicate the entries that you want to <strong>hide</strong> during the creation of a menu.',
	'configurer_objets_explication' => 'Choose content that can be associated with menus',
	'configurer_objets_label' => 'Linked contents',
	'configurer_titre' => 'Configure the entries of the Menus plugin',
	'confirmer_supprimer_entree' => 'Do you really want delete this entry?',
	'confirmer_supprimer_menu' => 'Are you sure you want to delete this menu?',
	'confirmer_supprimer_sous_menu' => 'Are you sure you want to delete this submenu?',

	// D
	'description_menu_accueil' => 'Link to website’s home page.',
	'description_menu_articles_rubrique' => 'Display the list of articles in a section.',
	'description_menu_deconnecter' => 'If the visitor is connected, add an entry offering disconnection.',
	'description_menu_espace_prive' => 'Link enabling the connection to the site if you aren’t already connected, and then to enter the private space if you are authorised to do so.',
	'description_menu_groupes_mots' => 'Automatically show a menu listing the keyword of the group and the linked articles. By default it shows the list of keyword groups and the keywords within them. If a groupes_mots.html template exists, the link to the group is used.',
	'description_menu_lien' => 'Adds an individually specified link, either an internal one (relative URL), or an external one (http://...).',
	'description_menu_mapage' => 'If visitors are connected, add a link to their author page.',
	'description_menu_mots' => 'Automatically shows a menu listing the articles linked to a keyword.',
	'description_menu_objet' => 'Creates a link to a SPIP object: article, section or other. By default, the entry will have the title of the object. The entry will only be visible if the object is published.',
	'description_menu_page_speciale' => 'Adds a link to a page template using a URL of the form <code>spip.php?page=name&param1=xx&param2=yyy...</code> Such pages are often used by plugins.',
	'description_menu_page_speciale_zajax' => 'Add a link to a block in a page accessible by a URL of the type <code>spip.php?page=name&param1=xx&param2=yyy...</code> This requires a Z type template and the <a href="https://contrib.spip.net/MediaBox">médiabox</a> plugin.',
	'description_menu_rubriques_articles' => 'Display a list of sections, optionally including sub-sections and articles nested to several levels. By default, all sections will be displayed starting from the site root and sorted by title (numerically then alphabetically).Articles in a given section will always be listed after any sub-sections.',
	'description_menu_rubriques_completes' => 'Displays a list of topics and, if you want, sub-sections on many levels. By default, displays all entries from the root, sorted by title (alphabetically and numerically).',
	'description_menu_secteurlangue' => 'This entry can be used by sites which have one language per sector. It displays a menu which lists the sections of the sector corresponding to the language of the page, and if desired the subsections to several levels. By default, all sections are shown from the site root, sorted by title (numerically then alphabetically).',
	'description_menu_texte_libre' => 'Just the text that you would like, or a SPIP language code (<:...:>)',

	// E
	'editer_menus_editer' => 'Edit this menu',
	'editer_menus_explication' => 'Create and configure menus for your site.',
	'editer_menus_exporter' => 'Export this menu',
	'editer_menus_nouveau' => 'Create a new menu',
	'editer_menus_titre' => 'Site menus',
	'entree_afficher_articles' => 'Include articles in the menu? (put "oui" for this)',
	'entree_afficher_item_suite' => 'Include articles in the menu? (put "oui" for this)',
	'entree_ancre' => 'Anchor',
	'entree_articles_max' => 'If so, show the articles only if the section contains a maximum of xx articles? (put the maximum number of articles, leave blank to display all articles)',
	'entree_articles_max_affiches' => 'If so, limit the number of articles listed to a maximum of  xx (followed by an item "... All the articles" with a link to the parent section)? (indicate the maximum number of articles, leave blank to display all of them)',
	'entree_aucun' => 'None',
	'entree_bloc' => 'Zpip block',
	'entree_choisir' => 'Choose the type of item you want to add:',
	'entree_classe_parent' => 'CSS class of the links of the parent elements. This class will be added to the li>a having a subsequent ul / li. For example, if you type "daddy", it allows you to use the plugin "menu deroulant 2" to format the menu.',
	'entree_connexion_objet' => 'Requires being connected (insert "session") or disconnected (insert "nosession") in order to see the object',
	'entree_contenu' => 'Content',
	'entree_css' => 'CSS classes of this (container) item',
	'entree_css_lien' => 'CSS classes of the link',
	'entree_id_groupe' => 'Number of the keyword group',
	'entree_id_mot' => 'Number of the keyword',
	'entree_id_objet' => 'Number',
	'entree_id_rubrique' => 'Number of the parent section',
	'entree_id_rubrique_ou_courante' => 'Parent or "current" section number if the parent section is the current section of the context',
	'entree_id_rubriques_exclues' => 'Numbers of the sections to be excluded, separated by commas',
	'entree_id_secteur_exclus' => 'Numbers of the sectors to be excluded, separated by commas',
	'entree_infini' => 'To infinity',
	'entree_lien_direct_articles_uniques' => 'If yes, and if unique articles are hidden, when a topic contains only one article, link to the article? (put "yes" for that)',
	'entree_mapage' => 'My page',
	'entree_masquer_articles_uniques' => 'If so and if a section contains a only one article, hide it? (put "oui" for this)',
	'entree_niveau' => 'Sub-sections level',
	'entree_nombre_articles' => 'Maximum number of articles (0 by default)',
	'entree_page' => 'Name of the page',
	'entree_parametres' => 'List of parameters',
	'entree_rubriques_max_affichees' => 'If so, limit the number of sections listed to a maximum of xx (followed by an item "... All sections" with a link to the parent section)? (indicate the maximum number of sections, leave blank to show all of them)',
	'entree_sousrub_cond' => 'Only display the subsections for the current section (enter "oui" (yes), otherwise leave it empty)',
	'entree_suivant_connexion' => 'Restrict this entry according to the connection (put "connecte" to display it only if the visitor is connected, "deconnecte" in the opposite case, put "admin" if the author is administrator or leave blank to always display it)',
	'entree_suivant_connexion_connecte' => 'only if connected',
	'entree_suivant_connexion_deconnecte' => 'only if disconnected',
	'entree_sur_n_articles' => '@n@ article(s) shown',
	'entree_sur_n_mots' => '@n@ keyword(s) shown',
	'entree_sur_n_niveaux' => 'On @n@ level(s)',
	'entree_titre' => 'Title',
	'entree_titre_connecter' => 'The title for accessing the identification form',
	'entree_titre_prive' => 'The title for accessing the private zone',
	'entree_traduction_articles_rubriques' => 'If possible, show the articles of the section in the language of the context (put "trad" for this)',
	'entree_traduction_objet' => 'Select the translation depending on the context (insert "trad" to accomplish this)',
	'entree_tri' => 'Sort order for sections ("titre" to sort by title, "num titre" to sort by the title number, prefix with an " !"for a reversed sorting)',
	'entree_tri_articles' => 'Sort order for articles ("titre" to sort by title, "num titre" to sort by the title number, prefix with an " !"for a reversed sorting)',
	'entree_type_objet' => 'Object type',
	'entree_url' => 'URL',
	'entree_url_public' => 'Return address after logging in',
	'erreur_aucun_type' => 'No item type was found.',
	'erreur_autorisation' => 'You are not allowed to modify menus.',
	'erreur_identifiant_deja' => 'This identifier is already used by another menu.',
	'erreur_identifiant_forme' => 'Identifier must contain only letters, digits or underscores.',
	'erreur_menu_inexistant' => 'Menu number @id@ doesn’t exist.',
	'erreur_mise_a_jour' => 'An error occured during database update.',
	'erreur_parametres' => 'There is an error in the parameters of the page',
	'erreur_type_menu' => 'You need to choose a type of menu',
	'erreur_type_menu_inexistant' => 'This kind of menu is not / no longer available',

	// F
	'formulaire_ajouter_sous_menu' => 'Create a sub-menu',
	'formulaire_css' => 'CSS classes',
	'formulaire_css_explication' => 'You can add to your menu additional CSS classes.',
	'formulaire_deplacer_bas' => 'Move down',
	'formulaire_deplacer_haut' => 'Move up',
	'formulaire_facultatif' => 'Optional',
	'formulaire_identifiant' => 'Identifier',
	'formulaire_identifiant_explication' => 'Give a unique keyword which let you call your menu easly.',
	'formulaire_ieconfig_choisir_menus_a_importer' => 'Select which menu(s) you would like to import.',
	'formulaire_ieconfig_importer' => 'Import',
	'formulaire_ieconfig_menu_meme_identifiant' => 'WARNING: there is already a menu with the same name on your site!',
	'formulaire_ieconfig_menus_a_exporter' => 'Menus to export:',
	'formulaire_ieconfig_ne_pas_importer' => 'Do not import',
	'formulaire_ieconfig_remplacer' => 'Overwrite the current menu with the imported menu',
	'formulaire_ieconfig_renommer' => 'Rename this menu before importing',
	'formulaire_importer' => 'Import menu',
	'formulaire_importer_explication' => 'If you exported a menu in a file, you can import now.',
	'formulaire_modifier_entree' => 'Modify this menu item',
	'formulaire_modifier_menu' => 'Modify menu:',
	'formulaire_nouveau' => 'New menu',
	'formulaire_partie_construction' => 'Menu construction',
	'formulaire_partie_identification' => 'Menu identification',
	'formulaire_supprimer_entree' => 'Delete this menu item',
	'formulaire_supprimer_menu' => 'Delete the menu',
	'formulaire_supprimer_sous_menu' => 'Delete this sub-menu',
	'formulaire_titre' => 'Title',

	// I
	'info_1_menu' => 'A menu',
	'info_afficher_articles' => 'The articles will be included in the menu.',
	'info_articles_max' => 'Only if the section contains more than @max@ articles',
	'info_articles_max_affiches' => 'Display limited to @max@ articles',
	'info_aucun_menu' => 'No menu',
	'info_classe_parent' => 'Class of the parent elements:',
	'info_connexion_obligatoire' => 'Connection required',
	'info_deconnexion_obligatoire' => 'Only when disconnected',
	'info_masquer_articles_uniques' => 'Unique articles hidden',
	'info_nb_menus' => '@nb@ menus',
	'info_numero_menu' => 'MENU NUMBER:',
	'info_page_speciale' => 'Link to the page « @page@ »',
	'info_page_speciale_zajax' => 'Modalbox for the "@page@" page for the "@bloc@" block',
	'info_rubrique_courante' => 'Current section',
	'info_rubriques_exclues' => ' / except section(s) @id_rubriques@',
	'info_rubriques_max_affichees' => 'Display limited to @max@ sections',
	'info_secteur_exclus' => ' / except sector(s) @id_secteur@',
	'info_sousrub_cond' => 'Only the subsections of the current section are displayed.',
	'info_tous_groupes_mots' => 'All keyword groups',
	'info_traduction_recuperee' => 'The context will determine the selected translation',
	'info_tri' => 'Sort sections:',
	'info_tri_alpha' => '(alphabetical)',
	'info_tri_articles' => 'Sort articles:',
	'info_tri_num' => '(numerical)',

	// N
	'noisette_description' => 'Insert a menu defined with the Menus plugin.',
	'noisette_label_afficher_titre_menu' => 'Show the menu title?',
	'noisette_label_identifiant' => 'Menu to display:',
	'noisette_nom_noisette' => 'Menu',
	'nom_menu_accueil' => 'Home Page',
	'nom_menu_articles_rubrique' => 'Articles of a section',
	'nom_menu_deconnecter' => 'Disconnect',
	'nom_menu_espace_prive' => 'Login / link to the private zone',
	'nom_menu_groupes_mots' => 'Keywords and Articles of a group of keywords',
	'nom_menu_lien' => 'Individual link',
	'nom_menu_mapage' => 'My page',
	'nom_menu_mots' => 'Articles of a keyword',
	'nom_menu_objet' => 'Article, section or other SPIP object',
	'nom_menu_page_speciale' => 'Link to a page template',
	'nom_menu_page_speciale_zajax' => 'A block in a Zpip page',
	'nom_menu_rubriques_completes' => 'List or tree of sections and articles (with many options)',
	'nom_menu_rubriques_evenements' => 'Section-related events',
	'nom_menu_secteurlangue' => 'Language sectors',
	'nom_menu_texte_libre' => 'Free text',

	// R
	'retirer_lien_menu' => 'Remove this menu',
	'retirer_lien_objet' => 'Dissociate',
	'retirer_tous_liens_menus' => 'Remove all menus',

	// T
	'texte_ajouter_menu' => 'Add a menu',
	'texte_creer_associer_menu' => 'Create and associate a menu',
	'titre_menu' => 'Menu',
	'titre_objets_lies_menu' => 'Related to this menu',
	'tous_les_articles' => '... All articles',
	'toutes_les_rubriques' => '... All sections',

	// U
	'utiles_explication' => 'The current template of the site can use the following menus.',
	'utiles_generer_menu' => 'Create the menu <strong>@titre@ (<em>@identifiant@</em>)</strong>',
	'utiles_generer_menus' => 'Create <strong>all</strong> useful menus',
	'utiles_titre' => 'Useful menus'
);
