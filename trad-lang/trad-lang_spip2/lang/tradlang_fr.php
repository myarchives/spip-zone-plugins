<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// Fichier source, a modifier dans svn://zone.spip.org/spip-zone/_plugins_/trad-lang/trad-lang_spip2/lang/
if (!defined('_ECRIRE_INC_VERSION')) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'aucunmodule' => 'Aucun module.',

	// B
	'bouton_activer_lang' => 'Activer la langue "@lang@" pour ce module',
	'bouton_exporter_fichier_langue' => 'Exporter le fichier de langue en "@lang@"',
	'bouton_exporter_fichier_langue_original' => 'Exporter le fichier de langue original ("@lang_mere@")',
	'bouton_supprimer_langue_module' => 'Supprimer cette langue du module',
	'bouton_supprimer_module' => 'Supprimer ce module',
	'bouton_traduire' => 'Traduire',

	// C
	'cfg_form_tradlang_autorisations' => 'Les autorisations',
	'cfg_inf_type_autorisation' => 'Si vous choisissez par statut ou par auteur, il vous sera demandé ci-dessous votre sélection de statuts ou d\'auteurs.',
	'cfg_lbl_autorisation_auteurs' => 'Autoriser par liste d\'auteurs',
	'cfg_lbl_autorisation_statuts' => 'Autoriser par statut d\'auteurs',
	'cfg_lbl_autorisation_webmestre' => 'Autoriser les webmestres uniquement',
	'cfg_lbl_liste_auteurs' => 'Auteurs du site',
	'cfg_lbl_statuts_auteurs' => 'Statuts possibles',
	'cfg_lbl_type_autorisation' => 'Méthode d\'autorisation',
	'cfg_legend_autorisation_configurer' => 'Gérer le plugin',
	'cfg_legende_autorisation_modifier' => 'Modifier les traductions',
	'cfg_legende_autorisation_voir' => 'Voir l\'interface de traduction',
	'codelangue' => 'Code de langue',
	'crayon_changer_statut' => 'Attention! Vous avez modifié le contenu de la chaîne sans en modifier le statut.',
	'crayon_changer_statuts' => 'Attention! Vous avez modifié le contenu d\'une ou plusieurs chaînes sans en modifier le statut.',

	// E
	'entrerlangue' => 'Ajouter un code langue',
	'erreur_aucun_item_langue_mere' => 'La langue mère "@lang_mere@" ne contient aucun item de langue.',
	'erreur_aucun_module' => 'Il n\'y a pas de modules disponibles dans la base.',
	'erreur_aucun_tradlang_a_editer' => 'Aucune chaîne de langue n\'est considérée comme non traduite.',
	'erreur_autorisation_modifier_modules' => 'Vous n\'êtes pas autorisé à traduire les modules de langue.',
	'erreur_autoriser_profil' => 'Vous n\'êtes pas autorisé à modifier ce profil.',
	'erreur_choisir_lang_cible' => 'Choisissez une langue cible de traduction.',
	'erreur_choisir_lang_orig' => 'Choisissez une langue d\'origine qui servira de base à la traduction.',
	'erreur_choisir_module' => 'Choisissez un module à traduire.',
	'erreur_code_langue_existant' => 'Cette variante de langue existe déjà pour ce module',
	'erreur_code_langue_invalide' => 'Ce code de langue est invalide',
	'erreur_langue_activer_impossible' => 'Le code de langue "@lang@" n\'existe pas.',
	'erreur_langues_autorisees_insuffisantes' => 'Vous devez au moins sélectionner deux langues',
	'erreur_langues_differentes' => 'Choisissez une langue cible différente de la langue originale',
	'erreur_module_inconnu' => 'Ce module n\'est pas disponible',
	'erreur_pas_langue_cible' => 'Sélectionnez une langue cible',
	'erreur_repertoire_local_inexistant' => 'Attention : le répertoire pour la sauvegarde locale "squelettes/lang" est inexistant',
	'explication_comm' => 'Le commentaire est une information ajoutée dans le fichier de langue afin d\'expliciter par exemple un choix de traduction particulier.',
	'explication_langue_cible' => 'La langue vers laquelle vous traduisez.',
	'explication_langue_origine' => 'La langue depuis laquelle vous traduisez (Seules les langues 100% complètes sont disponibles).',
	'explication_langues_autorisees' => 'Les utilisateurs ne pourront créer de nouvelles traductions que dans les langues sélectionnées.',
	'explication_limiter_langues_bilan' => 'Par défaut, @nb@ langues seront affichées, si les utilisateurs n\'ont pas sélectionné de langues préférées dans leur profil.',
	'explication_limiter_langues_bilan_nb' => 'Combien de langues seront affichées par défaut (les langues les plus traduites seront sélectionnées).',
	'explication_sauvegarde_locale' => 'Sauvegardera les fichiers dans le dossier squelette du site',
	'explication_sauvegarde_post_edition' => 'Sauvegardera les fichiers temporaires à chaque modification de chaine de langue',

	// I
	'icone_modifier_tradlang' => 'Modifier cette chaine de langue',
	'icone_modifier_tradlang_module' => 'Modifier ce module de langue',
	'importer_module' => 'Importation de nouveau module de langue',
	'importermodule' => 'Importer un module',
	'info_1_tradlang' => '@nb@ chaîne de langue',
	'info_1_tradlang_module' => '1 module de langue',
	'info_aucun_tradlang_module' => 'Aucun module de langue',
	'info_chaine_jamais_modifiee' => 'Cette chaîne n\'a jamais été modifiée.',
	'info_chaine_originale' => 'Cette chaîne est la chaine originale',
	'info_filtrer_status' => 'Filtrer par statut :',
	'info_langue_mere' => '(langue mère)',
	'info_langues_non_preferees' => 'Autres langues :',
	'info_langues_preferees' => 'Langue(s) préférée(s) :',
	'info_module_traduction' => '@total@ @statut@ (@percent@%)',
	'info_module_traduit_langues' => 'Ce module est traduit ou partiellement traduit dans @nb@ langues.',
	'info_module_traduit_pc' => 'Module traduit à @pc@%',
	'info_module_traduit_pc_lang' => 'Module "@module@" traduit à @pc@% en @lang@ (@langue_longue@)',
	'info_modules_priorite_traduits_pc' => 'Les modules de priorité "@priorite@" sont traduits à @pc@% en @lang@',
	'info_nb_items_module' => '@nb@ items dans le module "@module@"',
	'info_nb_items_module_modif' => '@nb@ items du module "@module@" sont modifiés et à vérifier en @lang@ (@langue_longue@)"',
	'info_nb_items_module_modif_aucun' => 'Aucun item du module "@module@" n\'est modifié et à vérifier en @lang@ (@langue_longue@)',
	'info_nb_items_module_modif_un' => 'Un item du module "@module@" est modifié et à vérifier en @lang@ (@langue_longue@)"',
	'info_nb_items_module_new' => '@nb@ items du module "@module@" sont à traduire en @lang@ (@langue_longue@)"',
	'info_nb_items_module_new_aucun' => 'Aucun item du module "@module@" n\'est à traduire en @lang@ (@langue_longue@)',
	'info_nb_items_module_new_un' => 'Un item du module "@module@" est à traduire en @lang@ (@langue_longue@)"',
	'info_nb_items_module_ok' => '@nb@ items du module "@module@" sont traduits en @lang@ (@langue_longue@)"',
	'info_nb_items_module_ok_aucun' => 'Aucun item du module "@module@" n\'est traduit en @lang@ (@langue_longue@)',
	'info_nb_items_module_ok_un' => 'Un item du module "@module@" est traduit en @lang@ (@langue_longue@)"',
	'info_nb_items_priorite' => 'Les modules de priorité "@priorite@" ont @nb@ items',
	'info_nb_items_priorite_modif' => '@pc@% des items de priorité "@priorite@" sont modifiés et à vérifier en @lang@ (@langue_longue@)',
	'info_nb_items_priorite_new' => '@pc@% des items de priorité "@priorite@" sont nouveaux en @lang@ (@langue_longue@)',
	'info_nb_items_priorite_ok' => 'Les modules de priorité "@priorite@" sont traduits à @pc@% en @lang@ (@langue_longue@)',
	'info_nb_tradlang' => '@nb@ chaînes de langue',
	'info_nb_tradlang_module' => '@nb@ modules de langue',
	'info_percent_chaines' => '@traduites@ / @total@ chaines traduites en "[@langue@] @langue_longue@"',
	'info_status_ok' => 'OK',
	'info_str' => 'Texte de la chaine de langue',
	'info_traduire_module_lang' => 'Traduire le module "@module@" en @langue_longue@ (@lang@)',
	'infos_trad_module' => 'Informations sur les traductions',
	'item_creer_langue_cible' => 'Créer une nouvelle langue cible',
	'item_langue_cible' => 'La langue cible : ',
	'item_langue_origine' => 'La langue d\'origine :',
	'item_manquant' => '1 item est manquant dans cette langue (par rapport à la langue mère)',
	'items_en_trop' => '@nb@ items sont en trop dans cette langue (par rapport à la langue mère)',
	'items_manquants' => '@nb@ items sont manquants dans cette langue (par rapport à la langue mère)',
	'items_modif' => 'Items modifiés',
	'items_new' => 'Nouveaux items',
	'items_total_nb' => 'Nombre total d\'items',

	// L
	'label_id_tradlang' => 'Identifiant de la chaîne',
	'label_idmodule' => 'ID du module',
	'label_lang' => 'Langue',
	'label_langue_mere' => 'Langue mère',
	'label_langues_autorisees' => 'N\'autoriser que certaines langues',
	'label_langues_preferees_auteur' => 'Vos ou votre langue(s) préférée(s)',
	'label_langues_preferees_autre' => 'Ses ou sa langue(s) préférée(s)',
	'label_limiter_langues_bilan' => 'Limiter le nombre de langues visibles dans le bilan',
	'label_limiter_langues_bilan_nb' => 'Nombre de langues',
	'label_nommodule' => 'Nom du module',
	'label_priorite' => 'Priorité',
	'label_proposition_google_translate' => 'Proposition de Google Translate',
	'label_recherche_module' => 'Dans le module : ',
	'label_recherche_status' => 'Avec le statut : ',
	'label_repertoire_module_langue' => 'Répertoire du module',
	'label_sauvegarde_locale' => 'Permettre de sauvegarder localement les fichiers',
	'label_sauvegarde_post_edition' => 'Sauvegarder les fichiers à chaque modification',
	'label_synchro_base_fichier' => 'Synchroniser la base et les fichiers',
	'label_texte' => 'Descriptif du module',
	'label_tradlang_comm' => 'Commentaire',
	'label_tradlang_status' => 'Statut de la traduction',
	'label_tradlang_str' => 'Chaîne traduite',
	'label_update_langues_cible_mere' => 'Mettre à jour cette langue dans la base',
	'label_version_originale' => 'Chaîne originale (@lang@)',
	'label_version_originale_comm' => 'Commentaire de la version originale (@lang@)',
	'label_version_selectionnee' => 'Chaîne dans la langue sélectionnée (@lang@)',
	'label_version_selectionnee_comm' => 'Commentaire dans la langue sélectionnée (@lang@)',
	'languesdispo' => 'Langues disponibles',
	'legend_conf_bilan' => 'Affichage du bilan',
	'lien_accueil_interface' => 'Accueil de l\'interface de traduction',
	'lien_aide_recherche' => 'Aide à la recherche',
	'lien_aucun_status' => 'Aucun',
	'lien_bilan' => 'Bilan des traductions courantes.',
	'lien_code_langue' => 'Code langue non valide. Le code langue doit avoir au moins deux lettres  (code ISO-631).',
	'lien_confirm_export' => 'Confirmer l\'export du fichier courant (c.a.d écrasement du fichier @fichier@)',
	'lien_editer_chaine' => 'Modifier',
	'lien_editer_tous' => 'Éditer toutes les chaînes non traduites',
	'lien_export' => 'Exporter automatiquement le fichier actuel.',
	'lien_page_depart' => 'Revenir à la page de garde ?',
	'lien_profil_auteur' => 'Votre profil',
	'lien_profil_autre' => 'Son profil',
	'lien_proportion' => 'Proportion des chaines affichées',
	'lien_recharger_page' => 'Recharger la page.',
	'lien_recherche_avancee' => 'Recherche avancée',
	'lien_retour' => 'Retour',
	'lien_retour_module' => 'Retour au module "@module@"',
	'lien_retour_page_auteur' => 'Revenir à votre page',
	'lien_retour_page_auteur_autre' => 'Revenir à sa page',
	'lien_revenir_traduction' => 'Revenir à la page de traduction',
	'lien_sauvegarder' => 'Sauvegarder/Restaurer le fichier actuel.',
	'lien_telecharger' => '[Télécharger]',
	'lien_traduction_module' => 'Module ',
	'lien_traduction_vers' => ' vers ',
	'lien_traduire_suivant_str_module' => 'Traduire la chaîne non traduite suivante du module "@module@"',
	'lien_trier_langue_non' => 'Afficher le bilan global.',
	'lien_utiliser_google_translate' => 'Utiliser cette version',
	'lien_voir_bilan_lang' => 'Voir le bilan de la langue @langue_longue@ (@lang@)',
	'lien_voir_bilan_module' => 'Voir le bilan du module @nom_mod@ - @module@',
	'lien_voir_toute_chaines_module' => 'Voir toutes les chaines du module.',

	// M
	'menu_info_interface' => 'Affiche un lien menant vers l\'interface de traduction',
	'menu_titre_interface' => 'Interface de traduction',
	'message_aucun_resultat_chaine' => 'Aucun résultat correspondant à vos critères dans les chaînes de langue.',
	'message_aucun_resultat_statut' => 'Aucune chaine ne correspond au statut demandé.',
	'message_aucune_nouvelle_langue_dispo' => 'Ce module est disponible dans toutes les langues possibles',
	'message_changement_lang_orig' => 'La langue d\'origine de traduction choisie ("@lang_orig@") n\'est pas assez traduite, elle est remplacée par la langue "@lang_nouvelle@".',
	'message_changement_lang_orig_inexistante' => 'La langue d\'origine de traduction choisie ("@lang_orig@") est inexistante, elle est remplacée par la langue "@lang_nouvelle@".',
	'message_confirm_redirection' => 'Vous allez être redirigé vers la modification du module',
	'message_demande_update_langues_cible_mere' => 'Vous pouvez demander à un administrateur de resynchroniser cette langue avec la langue principale.',
	'message_info_choisir_langues_profiles' => 'Vous pouvez séléctionner vos langues préférées <a href="@url_profil@">dans votre profil</a> pour les afficher par défaut.',
	'message_langues_choisies_affichees' => 'Seules les langues que vous avez choisies sont affichées : @langues@.',
	'message_langues_preferees_affichees' => 'Seules vos langues préférées sont affichées : @langues@.',
	'message_langues_utilisees_affichees' => 'Seules les @nb@ langues les plus utilisées sont affichées : @langues@.',
	'message_module_langue_ajoutee' => 'La langue "@langue@" a été ajoutée au module "@module@".',
	'message_module_updated' => 'Le module de langue "@module@" a été mis à jour.',
	'message_passage_trad' => 'On passe à la traduction',
	'message_passage_trad_creation_lang' => 'On crée la langue @lang@ et on passe à la traduction',
	'message_suppression_module_ok' => 'Le module @module@ a été supprimé.',
	'message_suppression_module_trads_ok' => 'Le module @module@ a été supprimé. @nb@ items de traductions lui appartenant ont été également supprimés.',
	'message_synchro_base_fichier_ok' => 'Le fichier et la base de données sont synchronisés.',
	'message_synchro_base_fichier_pas_ok' => 'Le fichier et la base de données ne sont pas synchronisés.',
	'module_deja_importe' => 'Le module "@module@" est déjà importé',
	'moduletitre' => 'Modules disponibles',

	// N
	'nb_item_langue_en_trop' => '1 item est en trop dans la langue "@langue_longue@" (@langue@).',
	'nb_item_langue_inexistant' => '1 item est inexistant dans la langue "@langue_longue@" (@langue@).',
	'nb_item_langue_mere' => 'La langue principale de ce module comporte 1 item.',
	'nb_items_langue_cible' => 'La langue cible "@langue@" comporte @nb@ items définis de la langue mère.',
	'nb_items_langue_en_trop' => '@nb@ items sont en trop dans la langue "@langue_longue@" (@langue@).',
	'nb_items_langue_inexistants' => '@nb@ items sont inexistants dans la langue "@langue_longue@" (@langue@).',
	'nb_items_langue_mere' => 'La langue principale de ce module comporte @nb@ items.',
	'notice_affichage_limite' => 'L\'affichage est limité à @nb@ chaînes de langue non traduites.',

	// R
	'readme' => 'Ce plugin permet de gérer les fichiers langues',

	// S
	'str_status_modif' => 'Modifié (MODIF)',
	'str_status_new' => 'Nouveau (NEW)',
	'str_status_traduit' => 'Traduit',

	// T
	'texte_contacter_admin' => 'Contactez un administrateur si vous souhaitez y participer.',
	'texte_erreur' => 'ERREUR',
	'texte_erreur_acces' => '<b>Attention : </b>impossible d\'écrire dans le fichier <tt>@fichier_lang@</tt>. Controlez les droits d\'accès.',
	'texte_existe_deja' => ' existe déjà.',
	'texte_explication_langue_cible' => 'Pour la langue cible, vous devez choisir si vous travaillez vers une langue déjà existante, ou si vous créez une nouvelle langue.',
	'texte_export_impossible' => 'Impossible d\'exporter le fichier. Vérifiez les droits en écriture sur le fichier @cible@',
	'texte_filtre' => 'Filtre (chercher)',
	'texte_inscription_ou_login' => 'Vous devez vous créer un compte sur le site ou vous identifier pour accéder à la traduction.',
	'texte_interface' => 'Interface de traduction : ',
	'texte_interface2' => 'Interface de traduction',
	'texte_langue' => 'Langue :',
	'texte_langue_cible' => 'la langue cible qui est la langue vers laquelle vous traduisez;',
	'texte_langue_origine' => 'la langue d\'origine qui vous servira de modèle (privilégiez la langue mère si vous le pouvez);',
	'texte_langues_differentes' => 'La langue cible et la langue origine doivent être différentes.',
	'texte_modifier' => 'Modifier',
	'texte_module' => 'le module de langue à traduire;',
	'texte_module_traduire' => 'Le module à traduire :',
	'texte_non_traduit' => 'non traduit ',
	'texte_operation_impossible' => 'Opération impossible. Lorsque la case \'tout sélectionner\' est cochée,<br> il faut faire des opérations de type \'Consulter\'.',
	'texte_pas_autoriser_traduire' => 'Vous n\'avez pas les droits nécessaires pour accéder aux traductions.',
	'texte_pas_de_reponse' => '... aucune réponse',
	'texte_recapitulatif' => 'Récapitulatif traductions',
	'texte_restauration_impossible' => 'impossible de restaurer le fichier',
	'texte_sauvegarde' => 'Interface de traduction, Sauvegarde/Restauration du fichier',
	'texte_sauvegarde_courant' => 'Copie de sauvegarde du fichier courant :',
	'texte_sauvegarde_impossible' => 'impossible de sauvegarder le fichier ',
	'texte_sauvegarder' => 'Sauvegarder',
	'texte_selection_langue' => 'Pour afficher un fichier de langue traduit/en cours de traduction, veuillez
	  sélectionner la langue : ',
	'texte_selectionner' => 'Pour commencer le travail de traduction, vous devez choisir :',
	'texte_selectionner_version' => 'Choisissez la version du fichier, puis cliquez le bouton ci-contre.',
	'texte_seul_admin' => 'Seul un compte administrateur peut accéder à cette étape.',
	'texte_total_chaine' => 'Nombre de chaines :',
	'texte_total_chaine_conflit' => 'Nombre de chaines plus utilisées :',
	'texte_total_chaine_modifie' => 'Nombre de chaines à remettre à jour :',
	'texte_total_chaine_non_traduite' => 'Nombre de chaines non traduites :',
	'texte_total_chaine_traduite' => 'Nombre de chaines traduites :',
	'texte_tout_selectionner' => 'Tous sélectionner',
	'texte_type_operation' => 'Type d\'opération',
	'texte_voir_bilan' => 'Voir le <a href="@url@" class="spip_in">bilan des traductions</a>.',
	'tfoot_total' => 'Total',
	'th_avancement' => 'Avancement',
	'th_comm' => 'Commentaire',
	'th_date' => 'Date',
	'th_items_modifs' => 'Items modifiés',
	'th_items_new' => 'Nouveaux items',
	'th_items_traduits' => 'Items traduits',
	'th_langue' => 'Langue',
	'th_langue_mere' => 'Langue mère',
	'th_langue_origine' => 'Texte de la langue d\'origine',
	'th_module' => 'Module',
	'th_status' => 'Statut',
	'th_total_items_module' => 'Nombre total d\'items',
	'th_traduction' => 'Traduction',
	'titre_bilan' => 'Bilan des traductions',
	'titre_bilan_langue' => 'Bilan des traductions de la langue "@lang@"',
	'titre_bilan_module' => 'Bilan des traductions du module "@module@"',
	'titre_changer_langue_selection' => 'Changer la langue sélectionnée',
	'titre_changer_langues_affichees' => 'Changer les langues affichées',
	'titre_commentaires_chaines' => 'Commentaires au sujet de cette chaine',
	'titre_logo_tradlang_module' => 'Logo du module',
	'titre_modifications_chaines' => 'Les dernières modifications de cette chaine',
	'titre_modifier' => 'Modifier',
	'titre_page_configurer_tradlang' => 'Configuration du plugin Trad-lang',
	'titre_page_tradlang_module' => 'Module #@id@ : @module@',
	'titre_profil_auteur' => 'Éditer votre profil',
	'titre_profil_autre' => 'Éditer son profil',
	'titre_recherche_tradlang' => 'Chaines de langue',
	'titre_revisions_sommaire' => 'Dernières modifications',
	'titre_tradlang' => 'Trad-lang',
	'titre_tradlang_chaines' => 'Chaines de langue',
	'titre_tradlang_module' => 'Module de langue',
	'titre_tradlang_modules' => 'Modules de langue',
	'titre_tradlang_non_traduit' => '1 chaîne de langue non traduite',
	'titre_tradlang_non_traduits' => '@nb@ chaînes de langue non traduites',
	'titre_traduction' => 'Traductions',
	'titre_traduction_chaine_de_vers' => 'Traduction de la chaine «@chaine@» du module «@module@» de <abbr title="@lang_orig_long@">@lang_orig@</abbr> vers <abbr title="@lang_cible_long@">@lang_cible@</abbr>',
	'titre_traduction_de' => 'Traduction de ',
	'titre_traduction_module_de_vers' => 'Traduction du module "@module@" de <abbr title="@lang_orig_long@">@lang_orig@</abbr> vers <abbr title="@lang_cible_long@">@lang_cible@</abbr>',
	'titre_traduire' => 'Traduire',
	'tradlang' => 'Trad-Lang',
	'traduction' => 'Traduction @lang@',
	'traductions' => 'Traductions'
);

?>
