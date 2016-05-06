<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// Fichier source, a modifier dans svn://zone.spip.org/spip-zone/_plugins_/boussole/trunk/lang/
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// B
	'bouton_actualiser_boussoles' => 'Actualiser les boussoles',
	'bouton_actualiser_caches' => 'Actualiser les caches',
	'bouton_boussole' => 'Boussole',
	'bouton_importer' => 'Importer',
	'bouton_importer_boussole' => 'Importer les sites d’une boussole',
	'bouton_retirer_boussole' => 'Retirer la boussole',
	'bouton_retirer_serveur' => 'Retirer le serveur',
	'bouton_supprimer' => 'Supprimer',
	'bouton_synchroniser' => 'Synchroniser les données',
	'bulle_afficher' => 'Afficher dans les modèles',
	'bulle_aller_site' => 'Se rendre sur la page du site référencé',
	'bulle_cacher' => 'Ne pas afficher dans les modèles',
	'bulle_deplacer_bas' => 'Déplacer vers le bas',
	'bulle_deplacer_haut' => 'Déplacer vers le haut',

	// C
	'colonne_alias' => 'Alias',
	'colonne_description_cache' => 'Description',
	'colonne_fichier_cache' => 'Cache',
	'colonne_nbr_sites' => 'Contient',
	'colonne_prefixe_plugin' => 'Plugin ?',
	'colonne_serveur' => 'Serveur',
	'colonne_titre' => 'Titre',
	'colonne_url' => 'URL',
	'colonne_version' => 'Version',

	// D
	'description_noisette_boussole' => 'Affichage standard d’une boussole. Vous pouvez choisir le modèle d’affichage (liens textuels, logos...) ainsi que sa configuration précise',
	'description_noisette_boussole_actualite' => 'Affichage des articles syndiqués des sites d’une boussole selon le modèle d’affichage <code>boussole_liste_actualite</code>.',
	'description_noisette_boussole_contenu_z' => 'Affichage de toutes les informations d’une boussole comme contenu principal d’une page Z et selon le modèle d’affichage <code>boussole_contenu_z</code>.',
	'description_noisette_boussole_fil_ariane' => 'Affichage du fil d’ariane d’une boussole.',
	'description_page_boussole' => 'Page des informations détaillées d’une boussole',

	// I
	'info_activite_serveur' => 'Par défaut, la fonction serveur du plugin n’est pas active. Vous pouvez l’activer en choisissant l’option adéquate ci-dessous et en lui affectant un nom.',
	'info_ajouter_boussole' => 'En ajoutant des boussoles à votre base de données, vous aurez la possiblité d’utiliser les modèles fournis pour les afficher dans vos pages publiques.<br />Si la boussole existe déjà ce formulaire permettra de la mettre à jour en conservant la configuration d’affichage.',
	'info_ajouter_serveur' => 'Ce formulaire vous permet de déclarer un serveur de boussoles. Par défaut, le serveur « spip » est toujours accessible depuis les sites client.',
	'info_alias_boussole_manuelle' => 'Saisissez l’alias de la boussole manuelle telle que définie dans son fichier XML.',
	'info_boite_boussoles_gerer_client' => '<strong>Cette page est uniquement accessible aux responsables du site.</strong><p>Elle permet l’ajout, la mise à jour et la suppression des boussoles en base de données en vue de leur affichage sur ce site. Il est aussi possible de se rendre sur la page de configuration de l’affichage de chaque boussole en cliquant sur son nom dans la liste.</p><p>Un formulaire permet également de configurer les serveurs de boussoles accessibles depuis le site.</p>',
	'info_boite_boussoles_gerer_serveur' => '<strong>Cette page est uniquement accessible aux responsables du site.</strong><p>Elle permet de mettre à jour manuellement le cache des boussoles hébergées par ce site serveur. Il est possible de télécharger les caches en cliquant sur leur nom dans la liste.</p><p>Un formulaire permet également de déclarer des boussoles manuelles hébergées sur le site.</p>',
	'info_boussole_manuelle' => 'Boussole Manuelle',
	'info_cache_boussole' => 'Cache de la boussole « @boussole@ »',
	'info_cache_boussoles' => 'Cache des boussoles hébergées',
	'info_configurer_boussole' => 'Ce formulaire vous permet de configurer l’affichage de la boussole en choisissant les sites à afficher ou pas et l’ordre d’affichage dans un groupe. Les sites non affichés sont repérés par un fond hachuré et une police grise.',
	'info_declarer_boussole_manuelle' => 'Ce formulaire vous permet de déclarer une boussole manuelle hébergée par ce site. Une fois déclarée, la boussole deviendra accessible par les sites client utilisant ce serveur.',
	'info_importer_boussole' => 'Cette option vous permet d’importer l’ensemble des sites d’une boussole installée sur votre site. Si certains sites de la boussole choisie sont déjà référencés, il ne seront pas créés à nouveau mais leurs données seront synchronisées avec celles fournies par la boussole pour ces mêmes sites.',
	'info_liste_aucun_cache' => 'Aucun cache n’a encore été créé pour les boussoles hébergées. Utilisez le bouton « actualiser les caches » pour les générer.',
	'info_liste_aucun_hebergement' => 'Aucune boussole n’est encore hébergée sur ce serveur. Utilisez le formulaire ci-dessous pour déclarer une boussole manuelle ou activez un plugin de boussole sur ce site.',
	'info_liste_aucun_serveur' => 'Aucun serveur n’a encore été configuré pour le site client.',
	'info_liste_aucune_boussole' => 'Aucune boussole n’a encore été chargée dans votre base. Utilisez le formulaire ci-dessous pour en ajouter.',
	'info_nom_serveur' => 'Saisissez le nom que vous souhaitez donner à votre serveur de boussoles. Le nom « spip » est réservé au serveur d’URL « http://boussole.spip.net » et ne peut donc pas être utilisé.',
	'info_rubrique_parent' => 'Pour créer les sites de la boussole vous devez choisir une rubrique d’accueil.',
	'info_site_boussole' => 'Ce site fait partie de la boussole :',
	'info_site_boussoles' => 'Ce site fait partie des boussoles :',
	'info_url_serveur' => 'Saisissez l’URL du site serveur.',

	// L
	'label_1_boussole' => '@nb@ boussole',
	'label_1_site' => '@nb@ site',
	'label_a_class' => 'Classe de l’ancre englobant le logo',
	'label_activite_serveur' => 'Activer la fonction serveur ?',
	'label_actualise_le' => 'Actualisée le',
	'label_affiche' => 'Affiché ?',
	'label_afficher_descriptif' => 'Afficher le descriptif des sites ?',
	'label_afficher_lien_accueil' => 'Afficher le lien vers la page d’accueil ?',
	'label_afficher_slogan' => 'Afficher le slogan des sites ?',
	'label_alias_boussole' => 'Alias de la boussole',
	'label_ariane_separateur' => 'Séparateur :',
	'label_boussole' => 'Boussole à afficher',
	'label_cartouche_boussole' => 'Afficher le cartouche de la boussole ?',
	'label_demo' => 'Retrouvez la page de démo de cette boussole à l’adresse',
	'label_descriptif' => 'Descriptif',
	'label_div_class' => 'Classe du div englobant',
	'label_div_id' => 'Id du div englobant',
	'label_fichier_xml' => 'Fichier XML',
	'label_langue_site' => 'Pour les données traduites, n’importer que la traduction dans la langue du site.',
	'label_li_class' => 'Classe de chaque balise li de la liste',
	'label_logo' => 'Logo',
	'label_max_articles' => 'Nombre max d’articles affichés par site',
	'label_max_sites' => 'Nombre max de sites',
	'label_mode' => 'Choisissez une boussole',
	'label_mode_standard' => '« @boussole@ », boussole officielle des sites SPIP',
	'label_modele' => 'Modèle d’affichage',
	'label_n_boussoles' => '@nb@ boussoles',
	'label_n_sites' => '@nb@ sites',
	'label_nom' => 'Nom',
	'label_nom_serveur' => 'Nom du serveur',
	'label_p_class' => 'Classe du paragraphe englobant le descriptif',
	'label_publier_import' => 'Publier automatiquement les sites nouvellement créés. Le statut des sites existant avant l’import n’est pas modifié',
	'label_sepia' => 'Code de la couleur de sépia (sans #)',
	'label_slogan' => 'Slogan',
	'label_taille_logo' => 'Taille max du logo (en pixels)',
	'label_taille_logo_boussole' => 'Taille max du logo de la boussole (en pixels)',
	'label_taille_titre' => 'Taille max du titre d’une boussole',
	'label_titre_actualite' => 'Afficher le titre du bloc d’actualité ?',
	'label_titre_boussole' => 'Afficher le titre de la boussole ?',
	'label_titre_groupe' => 'Afficher le titre du groupe ?',
	'label_titre_site' => 'Afficher le titre des sites ?',
	'label_type_bulle' => 'Information affichée dans la bulle de chaque lien',
	'label_type_description' => 'Description affichée à coté du logo',
	'label_ul_class' => 'Classe de la balise ul de la liste',
	'label_url' => 'URL',
	'label_url_serveur' => 'URL du serveur',
	'label_version' => 'Version',

	// M
	'message_nok_0_site_importe' => 'Aucun site n’a été importé à partir de la boussole @boussole@.',
	'message_nok_alias_boussole_manquant' => 'L’alias de la boussole n’a pas été fournie au serveur « @serveur@ ».',
	'message_nok_aucune_boussole_hebergee' => 'Aucune boussole n’est encore hébergée sur le serveur « @serveur@ ».',
	'message_nok_boussole_inconnue' => 'Aucune boussole ne correspond à l’alias « @alias@ ».',
	'message_nok_boussole_non_hebergee' => 'La boussole « @alias@ » n’est pas hébergée sur le serveur « @serveur@ ».',
	'message_nok_cache_boussole_indisponible' => 'Le fichier cache de la boussole « @alias@ » n’est pas disponible sur le serveur « @serveur@ ».',
	'message_nok_cache_liste_indisponible' => 'Le fichier cache de la liste des boussoles n’est pas disponible sur le serveur « @serveur@ ».',
	'message_nok_declaration_boussole_xml' => 'La boussole manuelle « @boussole@ » ne peut pas être déclarée car son fichier XML est introuvable.',
	'message_nok_ecriture_bdd' => 'Erreur d’écriture en base de données (table @table@).',
	'message_nok_nom_serveur_spip' => 'Le nom de serveur « spip » est réservé. Choisissez en un autre.',
	'message_nok_reponse_invalide' => 'La réponse du serveur « @serveur@ » est mal formée ou l’URL saisie ne correspond pas à un serveur actif.',
	'message_ok_1_site_importe' => 'Un seul site a été importé à partir de la boussole @boussole@.',
	'message_ok_boussole_actualisee' => 'La boussole « @fichier@ » a été mise à jour.',
	'message_ok_boussole_ajoutee' => 'La boussole « @fichier@ » a été ajoutée.',
	'message_ok_boussole_manuelle_ajoutee' => 'La boussole manuelle « @boussole@ » a été déclarée au serveur et les caches ont été mis à jour.',
	'message_ok_n_sites_importes' => '@nb@ sites ont été importés à partir de la boussole @boussole@.',
	'message_ok_serveur_ajoute' => 'Le serveur « @serveur@ » a été ajouté (@url@).',
	'modele_boussole_liste_avec_logo' => 'Liste de liens avec noms, logos et description',
	'modele_boussole_liste_par_groupe' => 'Liste de liens textuels par groupe',
	'modele_boussole_liste_simple' => 'Liste simple de liens textuels',
	'modele_boussole_panorama' => 'Galerie des logos',
	'modele_boussole_panorama_sepia' => 'Galerie des logos avec effet sépia',

	// O
	'onglet_client' => 'Fonction Client',
	'onglet_configuration' => 'Configuration du plugin',
	'onglet_serveur' => 'Fonction Serveur',
	'option_aucune_description' => 'Aucune description',
	'option_descriptif_site' => 'Descriptif du site',
	'option_nom_site' => 'Nom du site',
	'option_nom_slogan_site' => 'Nom et slogan du site',
	'option_slogan_site' => 'Slogan du site',

	// T
	'titre_boite_autres_boussoles' => 'Autres boussoles',
	'titre_boite_infos_boussole' => 'BOUSSOLE D’ALIAS',
	'titre_boite_logo_boussole' => 'LOGO DE LA BOUSSOLE',
	'titre_form_ajouter_boussole' => 'Ajouter ou mettre à jour une boussole',
	'titre_form_ajouter_serveur' => 'Déclarer un serveur de boussoles',
	'titre_form_boussole_manuelle' => 'Déclarer une boussole manuelle',
	'titre_form_configurer_serveur' => 'Configurer la fonction serveur',
	'titre_formulaire_configurer' => 'Configuration de l’affichage de la boussole',
	'titre_liste_boussoles' => 'Liste des boussoles disponibles à l’affichage',
	'titre_liste_caches' => 'Liste des caches des boussoles hébergées',
	'titre_liste_serveurs' => 'Liste des serveurs accessibles depuis le site',
	'titre_page_boussole' => 'Gestion des boussoles',
	'titre_page_configurer' => 'Configuration du plugin Boussole',
	'titre_page_importer_boussole' => 'Importation d’une boussole'
);
