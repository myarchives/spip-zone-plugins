<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
if (!defined('_ECRIRE_INC_VERSION')) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'analyze_document' => 'Analyse de votre document',
	'ancre_formulaire_upload' => 'Retour au formulaire de mise de ligne de documents',
	'ancre_formulaire_validation' => 'Aller au formulaire de validation',
	'ancre_haut_page' => 'Retour en haut de la page',
	'aucun_document_type' => 'Aucun document du type nécessaire n\'est présent.',

	// B
	'bouton_delier_document' => 'Délier ce document de cet article',
	'bouton_forcer' => 'Forcer ce document',
	'bouton_parcourir' => 'Parcourir',
	'bouton_recuperer_document' => 'Récupérer le ou les documents',
	'bouton_supprimer' => 'Supprimer',

	// C
	'cancel_upload' => 'Annuler la mise en ligne ?',
	'cancelled' => 'Annulation...',
	'changer_type_article' => 'Changer le type de l\'article',
	'complete' => 'Finalisation...',
	'configurer_les_extensions' => 'Vous devez configurer les extensions autorisées.',
	'connection_obligatoire' => 'Vous devez être identifié au site.',

	// D
	'document_appareil' => 'Appareil :',
	'document_credits' => 'Crédits',
	'document_description' => 'Description du document :',
	'document_description_no_crayons' => 'Aucun descriptif disponible, vous pouvez en ajouter un en double cliquant sur ce texte.',
	'document_date' => 'Date :',
	'document_dimensions' => 'Dimensions :',
	'document_extension' => 'Extension :',
	'document_id' => 'Identifiant du document :',
	'document_infos_complementaires' => 'Informations complémentaires',
	'document_licence' => 'Licence :',
	'document_logo' => 'Logo du document :',
	'document_nom_fichier' => 'Nom du fichier :',
	'document_poid_fichier' => 'Taille du fichier :',
	'document_titre' => 'Titre du document :',
	'document_type' => 'Type du document :',

	// E
	'em_next' => 'Document suivant',
	'em_prev' => 'Document précédent',
	'emballe_medias' => 'Emballe médias',
	'emballe_medias_fichiers' => 'Emballe médias (Fichiers)',
	'emballe_medias_styles' => 'Emballe médias (Styles)',
	'emballe_medias_types' => 'Emballe médias (Types)',
	'erreur_aucun_fichier' => 'Veuillez choisir un fichier',
	'erreur_autorisation_article' => 'Vous n\'avez pas les droits nécessaires pour modifier l\'article demandé',
	'erreur_beforeunload' => 'Vous êtes en train de mettre en ligne un document',
	'erreur_conflit_secteur' => 'Vous ne pouvez créer un template pour les articles et pour les médias sur le même secteur',
	'erreur_diogene_multiple' => 'Vous ne pouvez avoir qu\'un seul template "emballe media" sur ce site',
	'erreur_document_disparu' => 'Le document d\'origine n\'est plus disponible. Vous pouvez ci-dessous le remettre en ligne, le fichier original était : @fichier@',
	'erreur_document_existant' => 'Un document similaire est déjà présent : @nom@',
	'erreur_document_insere' => 'Ce document est inséré dans le contenu de l\'article et ne peut donc être supprimé.',
	'erreur_fichier_trop_gros' => 'Le fichier est trop gros.',
	'erreur_filesize_limit' => '@taille_max@ est le maximum accepté par votre configuration PHP.',
	'erreur_invalid_file_type' => 'Type de fichier invalide.',
	'erreur_publier_categorie_avant' => 'Vous devez créer au moins <a href="@url@" class="spip_in">une rubrique</a> au préalable.',
	'erreur_publier_categorie_avant_demander_admin' => 'Aucune catégorie n\'existe. Veuillez contacter un administrateur afin qu\'il en crée au moins une.',
	'erreur_publier_media_sans_categorie' => 'Vous ne pouvez pas, pour le moment, publier de média sur votre MediaSPIP.',
	'erreur_zero_byte_files' => 'Il est impossible de mettre en ligne des fichiers de 0 byte.',
	'explication_chercher_article' => 'Lors de la soumission d\'un nouveau article,
		si l\'id_article n\'est pas renseigné en tant que paramètre du formulaire,
		chercher l\'existence d\'un article en cours de rédaction du même auteur
		et insérer l\'article dedans (sinon on crée
		systématiquement un nouvel article)',
	'explication_config_readonly' => 'Cette option est désactivée. Elle doit être forcée par le thème que vous utilisez.',
	'explication_file_size_limit' => 'Limite de taille pour un fichier (MB). @taille_max@ est le maximum accepté par votre configuration PHP.',
	'explication_gerer_modifs_types' => 'Affiche un formulaire dans la colonne gauche de la page de modification d\'article, permettant aux auteurs de choisir eux mêmes le type d\'article.',
	'explication_gerer_types' => 'Typer les articles (remplir le champs "em_type" de la table article) en fonction du type de document mis en ligne. Si cette option est activée, il sera possible de définir plusieurs formulaire différents en fonction du type de fichier à mettre en ligne.',
	'explication_infos_documents' => 'Ces informations sont directement extraites des métadonnées de l\'image.',
	'explication_remplir_texte_article' => 'Si on arrive à extraire automatiquement un texte du document grâce au plugin Fulltext, le copier dans le champ "texte" de l\'article',
	'explication_statut_article_apres_dernier_document' => 'Après suppression du dernier document lié à un article publié ou proposé, quel statut donner à cet article ?',
	'extensions_audio' => 'Extensions Audio :',
	'extensions_autorisees' => 'Extensions de fichiers autorisées',
	'extensions_images' => 'Extensions Image :',
	'extensions_texte' => 'Extensions Texte :',
	'extensions_video' => 'Extensions Vidéo :',

	// F
	'failed_validation' => 'La validation du fichier a échoué. La mise en ligne est annulée.',
	'file_queue_limit' => 'Limite du nombre de fichiers dans la file d\'attente',
	'file_size_limit' => 'La taille maximale d\'un fichier est de @taille@ MB',
	'file_upload_limit' => 'Limite du nombre de fichiers à mettre en ligne',
	'file_upload_limit_public' => 'La limite maximale du nombre de fichiers à mettre en ligne est de',

	// H
	'hauteur_img_previsu' => 'Hauteur maximale (en px) de la prévisualisation des images',

	// L
	'label_case_gerer_modifs_types' => 'Afficher le formulaire de changement de type',
	'label_case_gerer_types' => 'Activer la gestion des types',
	'label_case_publier_dans_secteur' => 'Permettre de publier des articles sans catégorie (à la racine du secteur médias).',
	'label_case_types_autoriser_normal' => 'Dans le cas où aucun type n\'est sélectionné, on autorise la publication de type "normal"',
	'label_cfg_file_size_limit' => 'Limite de la taille des fichiers en MB',
	'label_changer_type' => 'Modifier le type de document(s) à mettre en ligne : ',
	'label_chercher_article' => 'Rechercher un article ?',
	'label_choisir_type' => 'Choisir le type de document(s) à mettre en ligne : ',
	'label_couleur_claire' => 'Couleur claire',
	'label_couleur_foncee' => 'Couleur foncée',
	'label_couleur_texte_bouton' => 'Couleur du texte du bouton d\'upload',
	'label_em_charger_supprimer' => 'Supprimer le fichier du répertoire FTP après import',
	'label_flash_bouton_styles' => 'Styles du bouton d\'upload',
	'label_gerer_modifs_types' => 'Permettre de modifier le type à posteriori',
	'label_gerer_types' => 'Gérer les types d\'articles',
	'label_publier_dans_secteur' => 'Publication hors catégorie',
	'label_remplir_texte_article' => 'Remplir automatiquement le champ "texte" de l\'article',
	'label_statut_article_apres_dernier_document' => 'Statut d\'un article après supression du dernier document lié',
	'label_texte_upload' => 'Explications pour l\'upload',
	'label_types_autoriser_normal' => 'Autoriser de publier sans type défini',
	'label_types_disponibles' => 'Types disponibles',
	'label_upload_debug' => 'Afficher le debug du formulaire d\'upload des documents',
	'largeur_img_previsu' => 'Largeur maximale (en px) de la prévisualisation des images',
	'legend_gerer_styles' => 'Gestion des styles',
	'legend_gerer_types' => 'Gestion des types d\'articles',
	'legend_mise_en_ligne_multiple' => 'Mise en ligne de fichier(s)',
	'legend_mise_en_ligne_unique' => 'Mise en ligne de fichier',
	'lien_charger_doc_trad' => 'Depuis l\'article d\'origine',
	'lien_charger_ftp' => 'Depuis le FTP',
	'lien_charger_local' => 'Depuis votre ordinateur',
	'lien_voir_origine' => 'Voir l\'original',
	'lien_zoom_image' => 'Zoom',

	// M
	'maj_plugin' => 'Mise à jour du plugin "Emballe Medias" à la version @version@.',
	'max_file_size' => 'La taille maximale de fichier est : ',
	'media_propose_detail' => 'Le media "@titre@" est proposé à la publication
	depuis',
	'media_propose_sujet' => '[@nom_site_spip@] Propose : @titre@',
	'media_propose_titre' => 'Media proposé
	---------------',
	'media_propose_url' => 'Vous êtes invité à venir le consulter. Il est disponible à l\'adresse :',
	'media_publie_detail' => 'Le media "@titre@" vient d\'être publié par @connect_nom@.',
	'media_publie_sujet' => '[@nom_site_spip@] PUBLIE : @titre@',
	'media_publie_titre' => 'Media publié
	--------------',
	'media_valide_date' => 'Sous réserve de changement, ce media sera publié',
	'media_valide_detail' => 'Le media "@titre@" a été validé par @connect_nom@.',
	'media_valide_sujet' => '[@nom_site_spip@] VALIDE : @titre@',
	'media_valide_titre' => 'Media validé
	--------------',
	'media_valide_url' => 'En attendant, il est visible à cette adresse temporaire :',
	'message_delier_document' => 'Ce document est déjà lié à un autre objet. Vous ne pouvez le supprimer. Vous pouver seulement le délier de l\'objet en cours.',
	'message_doc_trad_indisponible' => 'Aucun document n\'est disponible dans l\'article d\'origine.',
	'message_document_original' => 'Cet article est la version originale de :',
	'message_drag_file' => 'Déposez le fichier ici.',
	'message_drag_files' => 'Déposez les fichiers ici.',
	'message_navigateur_redirection' => 'Votre navigateur va être redirigé',
	'message_notice_nb_articles_prepa' => 'Vous avez @nb@ médias en préparation',
	'message_notice_voir_articles_prepa' => 'Voir <a href="@url@">ces médias</a>',
	'message_type_mis_a_jour' => 'Le type de l\'article a été mis à jour',
	'message_type_pas_mis_a_jour' => 'Le type de l\'article n\'a pas été modifié',

	// N
	'nb_doc_uploaded' => '@nb@ documents mis en ligne',
	'no_credits_crayons' => 'Aucun crédits spécifiés',

	// P
	'pending' => 'Dans la file d\'attente...',
	'previsu_document' => 'Prévisualisation du document',
	'previsu_document_nb' => 'Prévisualisation du document numéro @nb@',

	// Q
	'queue_limit_exceeded' => 'Vous avez tenté d\'ajouter trop de fichiers.',
	'queue_limit_max' => 'La limite maximale du nombre de fichier dans la file d\'attente est',
	'queue_limit_reached' => 'Vous avez atteint la limite.',
	'queue_limit_un' => 'Vous ne pouvez sélection qu\'un seul fichier',

	// S
	'security_error' => 'Erreur de sécurité',
	'select_all' => 'Tout sélectionner',
	'server_io_error' => 'Erreur de serveur (IO)',
	'statut_poubelle' => 'supprimer l\'article (poubelle)',
	'statut_prepa' => 'en cours de rédaction (prepa)',
	'stopped' => 'Arrêté...',
	'supprimer_document' => 'Supprimer le document',
	'swfupload_alternative_js' => 'Vous devez activer le javascript pour mettre en ligne un document',

	// T
	'temps_passe' => 'passé',
	'temps_restant' => 'restant',
	'titre_lien_publier' => 'Publier',
	'titre_nouveau_document' => 'Nouveau document',
	'titre_nouveau_document_audio' => 'Nouveau document audio',
	'titre_nouveau_document_image' => 'Nouvelle image',
	'titre_nouveau_document_texte' => 'Nouveau document texte',
	'titre_nouveau_document_video' => 'Nouveau document video',
	'type_aucun' => 'Aucun type spécifique',
	'type_audio' => 'Audio',
	'type_image' => 'Image',
	'type_invalide' => 'Le type de document choisi est invalide, modifiez votre choix.',
	'type_media' => 'Type du média : ',
	'type_normal' => 'Aucun type spécifique',
	'type_obligatoire' => 'La configuration du site vous oblige à choisir un type pour ce document. Sélectionnez celui désiré dans la liste ci-dessous.',
	'type_texte' => 'Texte',
	'type_video' => 'Video',
	'types_fichiers_autorises' => 'L\'ensemble des extensions de fichier autorisées sont : @types@',

	// U
	'unhandled_error' => 'Erreur inconnue',
	'unselect_all' => 'Tout déselectionner',
	'upload_error' => 'Erreur de mise en ligne :',
	'upload_failed' => 'La mise en ligne a échoué.',
	'upload_fichiers' => 'Mise en ligne des fichiers',
	'upload_limit_exceeded' => 'Upload limit exceeded.',
	'uploading' => 'Mise en ligne...',

	// V
	'verification_fichier' => 'Vérification du fichier...',
	'verifier_formulaire' => 'Il y a des erreurs.<br />Vérifiez le contenu du formulaire.'
);

?>
