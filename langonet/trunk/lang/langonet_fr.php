<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// Fichier source, a modifier dans svn://zone.spip.org/spip-zone/_plugins_/langonet/branches/v0/lang/
if (!defined('_ECRIRE_INC_VERSION')) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// B
	'bouton_cocher_tout' => 'Tout cocher',
	'bouton_cocher_aucun' => 'Tout décocher',
	'bouton_cocher_spip' => 'Cocher les modules SPIP',
	'bouton_corriger' => 'Obtenir les corrections',
	'bouton_generer' => 'Générer',
	'bouton_langonet' => 'LangOnet',
	'bouton_lister' => 'Afficher',
	'bouton_rechercher' => 'Rechercher',
	'bouton_verifier' => 'Vérifier',
	'bulle_afficher_fichier_lang' => 'Afficher le fichier de langue généré le @date@',
	'bulle_afficher_fichier_log' => 'Afficher le log du @date@',
	'bulle_corriger' => 'Télécharger le fichier de langue corrigé',
	'bulle_telecharger_fichier_lang' => 'Télécharger le fichier de langue généré le @date@',
	'bulle_telecharger_fichier_log' => 'Télécharger le log du @date@',

	// C
	'complement_definis_non_mais_cas2' => 'Le raccourci est bien défini dans le module «<code>@module@</code>». L\'utilisation d\'un autre module est probalement une erreur.',
	'complement_definis_non_mais_cas2_1' => 'Néanmoins, le raccourci est aussi défini dans le module «<code>@module_utilise@</code>» utilisé dans l\'occurrence.',
	'complement_definis_non_mais_cas2_2' => 'En outre, le raccourci n\'est pas défini dans le module «<code>@module_utilise@</code>» utilisé dans l\'occurrence.',
	'complement_definis_non_mais_cas2_3' => 'Par contre, il n\'a pas été possible de vérifier la définition du raccourci dans le module «<code>@module_utilise@</code>» utilisé dans l\'occurrence car celui-ci n\'est pas présent sur le site.',
	'complement_definis_non_mais_cas4' => 'Le raccourci n\'est défini ni dans le module «<code>@module@</code>» en cours de vérification ni dans le module «<code>@module_utilise@</code>» utilisé dans l\'occurrence.',
	'complement_definis_non_mais_cas4_1' => 'Néanmoins, il n\'a pas été possible de vérifier la définition du raccourci dans le module «<code>@module_utilise@</code>» car celui-ci n\'est pas présent sur le site.',
	'complement_definis_peut_etre_cas5' => 'Le raccourci est totalement variable.',
	'complement_definis_peut_etre_cas6' => 'Le raccourci est partiellement variable.',
	'complement_definis_peut_etre_cas6_1' => 'Aucun item du module «<code>@module@</code>» ne s\'en rapproche.',
	'complement_definis_peut_etre_cas6_2' => 'L\'item «@item@» du module «<code>@module@</code>» est potentiellement compatible.',

	// I
	'info_affichage' => 'Choisissez d\'afficher le texte produit ou brut de la traduction.',
	'info_arborescence_scannee' => 'Choisissez le répertoire de base dont l\'arborescence sera scannée',
	'info_bloc_langues_generees' => 'Cliquez sur un lien ci-dessous pour télécharger l\'un des fichiers de langue générés.',
	'info_bloc_logs_definition' => 'Cliquez sur un lien ci-dessous pour télécharger le dernier fichier de logs de vérification des définitions manquantes d\'un fichier de langue.',
	'info_bloc_logs_fonction_l' => 'Cliquez sur un lien ci-dessous pour télécharger le dernier fichier de logs de vérification des utilisations de _L() dans une arborescence donnée.',
	'info_bloc_logs_utilisation' => 'Cliquez sur un lien ci-dessous pour télécharger le dernier fichier de logs de vérification des définitions obsolètes d\'un fichier de langue.',
	'info_chemin_langue' => 'Dossier dans lequel est installé le fichier de langue (exemple : <em>plugins/rainette/lang/</em>, ou <em>ecrire/lang/</em>)',
	'info_fichier_liste' => 'Choisissez le fichier de langue dont vous voulez afficher les items, parmi ceux présents dans le site.',
	'info_fichier_source' => 'Choisissez le fichier de langue qui servira de référence pour générer le fichier cible.',
	'info_fichier_verifie' => 'Choisissez le fichier de langue à vérifier parmi ceux présents dans le site.',
	'info_generer' => 'Cette option vous permet de générer, à partir d\'une langue source, le fichier de langue d\'un module donné dans une langue cible. Si le fichier cible existe déjà son contenu est réutilisé pour construire le nouveau fichier. Le fichier généré est toujours encodé en UTF-8.',
	'info_langue' => 'Abréviation de la langue (exemple : <em>fr</em>, <em>en</em>, <em>es</em>...)',
	'info_langue_reference' => 'La langue affichée est la langue de référence pour la traduction.',
	'info_lister' => 'Cette option vous permet de visualiser les items d\'un fichier de langue classés par ordre alphabétique.',
	'info_mode' => 'Correspond à la chaîne qui sera insérée lors de la création d\'un nouvel item pour la langue cible.',
	'info_module' => 'Correspond au préfixe du fichier de langue hors abréviation de la langue (exemple : <em>rainette</em> pour le plugin de même nom, ou <em>ecrire</em> pour SPIP)',
	'info_modules_recherche_item' => 'Par défaut, tous les modules disponibles sont sélectionnés pour la recherche. Si vous préférez choisir les modules à utiliser ouvrez la liste en décochant la case ci-dessous.',
	'info_modules_recherche_texte' => 'Par défaut, seuls les modules de langue SPIP sont sélectionnés pour la recherche. Si vous préférez choisir les modules à utiliser ouvrez la liste en décochant la case ci-dessous.',
	'info_pattern_item_cherche' => 'Saisissez un texte correspondant à tout ou partie d\'un raccourci d\'item de langue. La recherche est toujours insensible à la casse.',
	'info_pattern_texte_cherche' => 'Saisissez en UTF-8 un texte correspondant à tout ou partie d\'une traduction française d\'item de langue. La recherche est toujours insensible à la casse.',
	'info_recherche' => 'Les résultats de la recherche sont présentés par type de correspondance.',
	'info_rechercher_item' => 'Cette option vous permet de chercher des items de langue via leur raccourci dans les fichiers de langue présents sur le site. Par souci de performance, seuls les fichiers de langue française sont utilisés et les fichiers de langue <em>paquet-xxxx_fr.php</em> sont exclus.',
	'info_rechercher_texte' => 'Cette option vous permet de chercher des items de langue via leur traduction française dans les fichiers de langue de SPIP et des plugins disponibles. Par souci de performance, seuls les fichiers de langue française sont utilisés et les fichiers de langue <em>paquet-xxxx_fr.php</em> sont exclus.',
	'info_table' => 'Chaque ligne affiche l\'icone représentant l\'état de traduction (si le module est sous TradLang), le raccourci en gras et la traduction elle-même.',
	'info_tradlang_oui' => 'Ce module est traduit avec TradLang. @reference@ La légende des couleurs de l\'état est la suivante :',
	'info_tradlang_non' => 'Ce module n\'est pas traduit avec TradLang.',
	'info_tradlang_statut_ok' => 'item correctement traduit',
	'info_tradlang_statut_modif' => 'item dont la traduction est obsolète (référence modifiée)',
	'info_tradlang_statut_new' => 'item non encore traduit',
	'info_verification_l' => 'Vous avez choisi de rechercher les cas d\'utilisation de la fonction _L() dans les fichiers PHP de l\'arborescence <code>@arborescence@</code>.',
	'info_verification_utilisation_arbo_1' => 'Vous avez choisi de rechercher les items de langue du module «<code>@module@</code>» non utilisés dans les fichiers de l\'arborescence :',
	'info_verification_utilisation_arbo_n' => 'Vous avez choisi de rechercher les items de langue du module «<code>@module@</code>» non utilisés dans les fichiers des arborescences :',
	'info_verification_definition_arbo_1' => 'Vous avez choisi de rechercher les items de langue non définis dans le module «<code>@module@</code>» mais utilisés dans les fichiers de l\'arborescence :',
	'info_verification_definition_arbo_n' => 'Vous avez choisi de rechercher les items de langue non définis dans le module «<code>@module@</code>» mais utilisés dans les fichiers des arborescences :',
	'info_verifier' => 'Cette option vous permet de vérifier les fichiers de langue d\'un module donné sous deux angles complémentaires. D\'une part, il est possible de vérifier si des items de langue utilisés dans un groupe de fichiers (un plugin, par exemple) ne sont pas définis dans le fichier de langue idoine, et d\'autre part, que certains items de langue définis ne sont plus utilisés.',
	'info_verifier_l' => 'Cette option vous permet de lister et de corriger toutes les utilisations de la fonction _L() dans les fichiers PHP d\'une arborescence donnée.',
	'info_utilises_non' => 'Les items de langue ci-dessous sont <strong>obsolètes</strong>, c\'est-à-dire non utilisés avec le module «<code>@module@</code>» (par exemple, <code><:@module@:raccourci:></code>).<br />Néanmoins, il est possible que cela soit dû à une absence de détection sachant qu\'aujourd\'hui les expressions de langue écrites sur plusieurs lignes ne sont pas recensées. Nous vous invitons donc à vérifier le code.',
	'info_utilises_non_mais' => 'Les items de langue ci-dessous ne sont <strong>pas utilisés avec le module «<code>@module@</code>»</strong>.<br />Il est donc possible que l\'utilisation d\'un autre module soit une erreur. Nous vous invitons donc à vérifier un par un les cas d\'utilisations affichés en regard de chaque item de langue suspects.',
	'info_utilises_peut_etre' => 'Les items de langue ci-dessous sont <strong>peut-être obsolètes</strong>.<br />Néanmoins, il est possible qu\'ils soient utilisés dans un contexte complexe comme par exemple :  <code>_T(\'@module@:item_\'.$variable))</code>. Nous vous invitons donc à vérifier un par un les cas d\'utilisations affichés en regard de chaque item de langue suspects.',
	'info_utilises_non_module_nok' => 'Cet item est quand même utilisé avec un autre module de langue. Nous vous conseillons de vérifier si cela est une erreur.',
	'info_definis_non' => 'Les items de langue ci-dessous sont utilisés dans des fichiers passés en revue lors de la vérification mais ne sont <strong>pas définis</strong> dans le module «<code>@module@</code>».',
	'info_definis_non_mais' => 'Les items de langue ci-dessous sont utilisés dans des fichiers passés en revue lors de la vérification mais sont <strong>probablement en erreur</strong>. En effet, ils sont soient définis dans le module «<code>@module@</code>» mais utilisés avec un autre module, soient non définis ni dans le module «<code>@module@</code>» ni dans le module utilisé. Nous vous invitons à les vérifier un par un.',
	'info_definis_oui_mais' => 'Les items de langue ci-dessous sont utilisés dans des fichiers passés en revue lors de la vérification avec un autre module que celui en cours de vérification mais sont bien définis. Il est probable que ce ne soit pas une erreur mais nous vous invitons à le vérifier.',
	'info_definis_peut_etre' => 'Les items de langue ci-dessous sont utilisés dans un contexte complexe et pourraient être non définis dans le module «<code>@module@</code>». Nous vous invitons à les vérifier un par un.',

	// L
	'label_affichage' => 'Mode d\'affichage de la traduction',
	'label_arborescence_scannee' => 'Arborescence à scanner',
	'label_avertissement' => 'Avertissements',
	'label_chemin_langue' => 'Localisation du fichier de langue',
	'label_correspondance' => 'Type de correspondance',
	'label_correspondance_commence' => 'Commence par',
	'label_correspondance_contient' => 'Contient',
	'label_correspondance_egal' => 'Égal à',
	'label_erreur' => 'Erreurs',
	'label_defaut_modules_item' => 'Tous les modules disponibles',
	'label_defaut_modules_texte' => 'Les modules SPIP (ecrire, spip, public)',
	'label_fichier_liste' => 'Fichier de langue',
	'label_fichier_source' => 'Fichier de langue source',
	'label_fichier_verifie' => 'Langue à vérifier',
	'label_langue_cible' => 'Langue cible',
	'label_langue_source' => 'Langue source',
	'label_mode' => 'Mode de création des nouveaux items',
	'label_module' => 'Module',
	'label_modules' => 'Modules utilisés pour le recherche',
	'label_pattern' => 'Texte à rechercher',
	'label_verification' => 'Type de vérification',
	'label_verification_definition' => 'Détection des définitions manquantes',
	'label_verification_fonction_l' => 'Détection des cas d\'utilisation de la fonction _L()',
	'label_verification_utilisation' => 'Détection des définitions obsolètes',
	'legende_generer_cible' => 'Fichier cible',
	'legende_generer_source' => 'Fichier source',
	'legende_resultats' => 'Résultats de la vérification',
	'legende_table' => 'Liste alphabétique des items du fichier de langue choisi',
	'legende_trouves' => 'Liste des items trouvés (@total@)',

	// M
	'message_nok_arborescence_l' => 'Aucun fichier à vérifier dans l\'arborescence choisie.',
	'message_nok_aucun_fichier_log' => 'Aucun fichier de log disponible au téléchargement',
	'message_nok_aucune_langue_generee' => 'Aucun fichier de langue généré disponible au téléchargement',
	'message_nok_champ_obligatoire' => 'Ce champ est obligatoire',
	'message_nok_ecriture_fichier' => 'Le fichier de langue «<em>@langue@</em>» du module «<em>@module@</em>» n\'a pas été créé car une erreur s\'est produite lors de son écriture !',
	'message_nok_lecture_fichier' => 'Le fichier de langue «<em>@langue@</em>» du module «<em>@module@</em>» n\'est pas accessible ou est vide !',
	'message_nok_fichier_langue' => 'La génération a échoué car le fichier de langue «<em>@langue@</em>» du module «<em>@module@</em>» est introuvable dans le répertoire «<em>@dossier@</em>» !',
	'message_nok_fichier_log' => 'Le fichier de log contenant les résultats de la vérification n\'a pas pu être créé !',
	'message_nok_fichier_script' => 'Le fichier de script contenant les commandes de remplacement des fonctions _L par _T n\'a pas pu être créé !',
	'message_nok_item_trouve' => 'Aucun item de langue ne correspond à la recherche !',
	'message_nok_corrections' => 'Les corrections n\'ont pas pas pu être intégrées dans le fichier de langue concerné.',
	'message_ok_corrections_fonction_l' => 'Les items construits à partir des cas d\'utilisation de la fonction _L() ont été intégrés dans le fichier de langue <code>@fichier@</code>.',
	'message_ok_corrections_utilisation' => 'La vérification a produit un fichier de langue corrigé <code>@fichier@</code> dans lequel les items obsolètes ont été mis en commentaire.',
	'message_ok_corrections_definition' => 'La vérification a produit un fichier de langue corrigé <code>@fichier@</code> dans lequel les items non définis on été rajoutés avec une traduction vide qu\'il vous sera facile de compléter. Un commentaire permet de les identifier plus facilement.',
	'message_ok_fichier_genere' => 'Le fichier de langue «<em>@langue@</em>» du module «<em>@module@</em>» a été généré correctement.<br />Vous pouvez récupérer le fichier «<em>@fichier@</em>».',
	'message_ok_fichier_log' => 'La vérification s\'est correctement déroulée. Vous pouvez consultez les résultats plus bas dans le formulaire.<br />Le fichier «<em>@log_fichier@</em>» a été créé pour sauvegarder ces résultats.',
	'message_ok_fichier_log_script' => 'La vérification s\'est correctement déroulée. Vous pouvez consultez les résultats plus bas dans le formulaire.<br />Le fichier «<em>@log_fichier@</em>» a été créé pour sauvegarder ces résultats ainsi que le fichier des commandes de remplacement _L en _T, «<em>@script@</em>».',
	'message_ok_fonction_l_0' => 'Aucun cas d\'utilisation de la fonction _L() n\'a été détecté',
	'message_ok_fonction_l_1' => 'Un seul cas d\'utilisation de la fonction _L()',
	'message_ok_fonction_l_n' => '@nberr@ cas d\'utilisation de la fonction _L()',
	'message_ok_item_trouve' => 'La recherche du texte @pattern@ s\'est déroulée correctement.',
	'message_ok_item_trouve_commence_1' => 'L\'item de langue ci-dessous commence par le texte recherché :',
	'message_ok_item_trouve_commence_n' => 'Les @sous_total@ items ci-dessous commencent tous par le texte recherché :',
	'message_ok_item_trouve_contient_1' => 'L\'item de langue ci-dessous contient le texte recherché :',
	'message_ok_item_trouve_contient_n' => 'Les @sous_total@ items ci-dessous contiennent tous le texte recherché :',
	'message_ok_item_trouve_egal_1' => 'L\'item de langue ci-dessous correspond exactement au texte recherché :',
	'message_ok_item_trouve_egal_n' => 'Les @sous_total@ items ci-dessous correspondent exactement au texte recherché :',
	'message_ok_definis_non_0' => 'Tous les items de langue utilisés sont bien définis',
	'message_ok_definis_non_1' => 'Un seul item de langue non défini',
	'message_ok_definis_non_n' => '@nberr@ items de langue non définis',
	'message_ok_definis_non_mais_0' => 'Aucun item de langue probablement indéfini',
	'message_ok_definis_non_mais_1' => 'Un item de langue probablement défini',
	'message_ok_definis_non_mais_n' => '@nberr@ items de langue probablement non définis',
	'message_ok_definis_oui_mais_0' => 'Aucun item de langue défini aussi dans un autre module',
	'message_ok_definis_oui_mais_1' => 'Un item de langue défini aussi dans un autre module',
	'message_ok_definis_oui_mais_n' => '@nberr@ items de langue définis aussi dans un autre module',
	'message_ok_definis_peut_etre_0' => 'Aucun item de langue partiellement ou totalement variable',
	'message_ok_definis_peut_etre_1' => 'Un item de langue partiellement ou totalement variable',
	'message_ok_definis_peut_etre_n' => '@nberr@ items de langue partiellement ou totalement variables',
	'message_ok_table_creee' => 'La table des items du fichier de langue @langue@ a été correctement créée.',
	'message_ok_fichier_verification' => 'La vérification s\'est correctement déroulée. Vous pouvez consultez les résultats plus bas après le formulaire.',
	'message_ok_utilises_non_0' => 'Aucun item de langue obsolète n\'a été détecté',
	'message_ok_utilises_non_1' => 'Un seul item de langue obsolète',
	'message_ok_utilises_non_n' => '@nberr@ items de langue obsolètes',
	'message_ok_utilises_non_mais_0' => 'Aucun item de langue utilisé avec un autre module n\'a été détecté',
	'message_ok_utilises_non_mais_1' => 'Un seul item de langue utilisé avec un autre module',
	'message_ok_utilises_non_mais_n' => '@nberr@ items de langue utilisés avec un autre module',
	'message_ok_utilises_peut_etre_0' => 'Aucun item de langue potentiellement obsolète n\'a été détecté',
	'message_ok_utilises_peut_etre_1' => 'Un seul item de langue potentiellement obsolète',
	'message_ok_utilises_peut_etre_n' => '@nberr@ items de langue potentiellement obsolètes',

	'message_ok_non_utilises_0s' => 'Tous les items de langue définis  dans le fichier de langue «<em>@langue@</em>» sont bien utilisés dans les fichiers des répertoires «<em>@ou_fichier@</em>».',
	'message_ok_non_utilises_1s' => 'L\'item de langue ci-dessous est bien défini dans le fichier de langue «<em>@langue@</em>», mais n\'est pas utilisé dans les fichiers des répertoires «<em>@ou_fichier@</em>» :',
	'message_ok_non_utilises_ns' => 'Les @nberr@ items de langue ci-dessous sont bien définis dans le fichier de langue «<em>@langue@</em>», mais ne sont pas utilisés dans les fichiers des répertoires «<em>@ou_fichier@</em>» :',

	// O
	'onglet_generer' => 'Générer une langue',
	'onglet_lister' => 'Afficher une langue',
	'onglet_rechercher_item' => 'Rechercher un raccourci',
	'onglet_rechercher_texte' => 'Rechercher un texte',
	'onglet_verifier_item' => 'Vérifier une langue',
	'onglet_verifier_l' => 'Vérifier la fonction _L()',
	'option_affichage_final' => 'Texte produit sans balise HTML',
	'option_affichage_brut' => 'Texte brut avec les balises HTML',
	'option_aucun_dossier' => 'aucune arborescence sélectionnée',
	'option_aucun_fichier' => 'aucune langue sélectionnée',
	'option_mode_index' => 'Item de la langue source',
	'option_mode_new' => 'Balise &lt;NEW&gt; uniquement',
	'option_mode_new_index' => 'Item de la langue source précédé de &lt;NEW&gt;',
	'option_mode_new_valeur' => 'Chaîne dans la langue source précédée de &lt;NEW&gt;',
	'option_mode_pas_item' => 'Ne pas créer d\'item',
	'option_mode_valeur' => 'Chaîne dans la langue source',
	'option_mode_vide' => 'Une chaîne vide',

	// T
	'texte_item_defini_ou' => '<em>défini dans :</em>',
	'texte_item_mal_defini' => '<em>mais pas défini dans le bon module :</em>',
	'texte_item_non_defini' => '<em>mais défini nulle part !</em>',
	'texte_item_utilise_ou' => '<em>utilisé dans :</em>',
	'titre_bloc_langues_corrigees_definis_non' => 'Définitions manquantes - Modules corrigés',
	'titre_bloc_langues_corrigees_utilises_non' => 'Définitions obsolètes - Modules corrigés',
	'titre_bloc_langues_corrigees_fonction_l' => 'Fonction _L - Modules corrigés',
	'titre_bloc_langues_generees' => 'Fichiers de langue générés',
	'titre_bloc_logs_definition' => 'Définitions manquantes',
	'titre_bloc_logs_fonction_l' => 'Utilisations de _L()',
	'titre_bloc_logs_utilisation' => 'Définitions obsolètes',
	'titre_form_generer' => 'Génération des fichiers de langue',
	'titre_form_lister' => 'Affichage des fichiers de langue',
	'titre_form_rechercher_item' => 'Recherche de raccourcis dans les fichiers de langue',
	'titre_form_rechercher_texte' => 'Recherche de textes dans les fichiers de langue',
	'titre_form_verifier' => 'Vérification des fichiers de langue',
	'titre_form_verifier_l' => 'Vérification de l\'utilisation de la fonction _L()',
	'titre_page' => 'LangOnet',
	'titre_page_navigateur' => 'LangOnet',
);

?>
