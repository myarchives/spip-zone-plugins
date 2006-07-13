<?php


	/**
	 * SPIP-Lettres : plugin de gestion de lettres d'information
	 *
	 * Copyright (c) 2006
	 * Agence Artégo http://www.artego.fr
	 *  
	 * Ce programme est un logiciel libre distribue sous licence GNU/GPL.
	 * Pour plus de details voir le fichier COPYING.txt.
	 *  
	 **/


	$GLOBALS[$GLOBALS['idx_lang']] = array(

		'lettres_information' => 'Lettres d\'information',
		'lettre_information' => 'Lettre d\'information',

		// Installation
		'installation' => 'Installation du plugin "Lettres d\'information"',
		'installation_note' => 'L\'installation du plugin lettres d\'information consiste en la création des tables MySQL nécessaires à la création de lettres d\'informations.',
		'installation_texte' => 'Les tables nécessaires au fonctionnement du plugin lettres d\'information n\'ont pas été détectées. Cette étape permet d\'ajouter ces tables dans votre base de données MySQL.',
		'creation_des_tables_mysql' => 'Création des tables MySQL',
		'creer_tables_mysql' => 'Créer les tables MySQL',
 
		// Administration
		'plugin' => 'Plugin',
		'plugin_version' => 'version',
		'lettres_publiees' => 'Vos lettres publiées en ligne',
		'lettres_brouillon' => 'Vos lettres non publiées en ligne',
		'lettres_envoi_en_cours' => 'Vos lettres à envoyer',
		'administration' => 'Administration du plugin "Lettres d\'information"',
		'configuration' => 'Configuration du plugin',
		'squelette_formulaire_lettres' => 'Squelette du formulaire d\'inscription',
		'squelette_formulaire_lettres_texte' => 'L\'adresse du formulaire est le nom du squelette où figure le formulaire <code>#FORMULAIRE_LETTRES</code> sans son extension.<br /><br /><em>ex : si </em><code>#FORMULAIRE_LETTRES</code><em> figure dans le squelette </em><code>inscription.html</code><em>, alors l\'adresse à renseigner est "</em><code>inscription</code><em>".</em>',
		'squelette_message_html' => 'Squelette du message au format HTML',
		'squelette_message_texte' => 'Squelette du message au format texte',
		'squelette_message_html_descriptif' => 'L\'adresse du formulaire est le nom du squelette qui sert à générer le message HTML des lettres (sans son extension).<br /><br /><em>ex : si </em><code>lettre_information_html.html</code><em> est le squelette générant le message HTML des lettres, alors l\'adresse à renseigner est "</em><code>lettre_information_html</code><em>".</em>',
		'squelette_message_texte_descriptif' => 'L\'adresse du formulaire est le nom du squelette qui sert à générer le message texte des lettres (sans son extension).<br /><br /><em>ex : si </em><code>lettre_information_texte.html</code><em> est le squelette générant le message HTML des lettres, alors l\'adresse à renseigner est "</em><code>lettre_information_texte</code><em>".</em>',
		'abonnes' => 'Abonnés',
		'lettres' => 'Lettres',
		'recherche' => 'Recherche',
		'resultat_recherche' => 'Résultat de la recherche :',
		'nb_inscrits' => 'nombre d\'abonnés',
		'nb_inscriptions' => 'nombre d\'inscriptions',
		'nb_lettres_brouillon' => 'en cours de rédaction',
		'nb_lettres_publiees' => 'publiées en ligne',
		'nb_lettres_envoi_en_cours' => 'à envoyer',
		'modifier_lettre' => 'Modifier la lettre',
		'nouvelle_lettre' => 'Nouvelle lettre',
		'titre' => '<b>Titre</b> [Obligatoire]',
		'descriptif' => 'Descriptif',
		'texte' => 'Texte',
		'enregistrer' => 'Enregistrer',
		'numero_lettre' => 'LETTRE NUMERO',
		'numero_archive' => 'ARCHIVE NUMERO',
		'raccourci_voir_abonnes' => 'Voir les abonnés',
		'raccourci_ajouter_abonne' => 'Ajouter un abonné',
		'raccourci_envoyer_lettre' => 'Envoyer cette lettre',
		'raccourci_statistiques' => 'Statistiques',
		'raccourci_statistiques_generales' => 'Statistiques générales',
		'raccourci_archives' => 'Accéder aux archives',
		'raccourci_creer_nouvelle_lettre' => 'Créer une nouvelle lettre d\'information',
		'raccourci_configurer_plugin' => 'Configuration du plugin',
		'raccourci_tester_envoi' => 'Tester l\'envoi avec les auteurs',
		'raccourci_reprendre_envoi' => 'Reprendre un envoi',
		'raccourci_retour_liste_lettres' => 'Retour à la liste des lettres',
		'raccourci_retourner_lettre' => 'Retour à la lettre',
		'raccourci_formulaire_inscription' => 'Aller au formulaire d\'inscription sur l\'espace public',
		'modifier_lettre' => 'Modifier la lettre',
		'date' => 'DATE',
		'changer_date' => 'CHANGER LA DATE :',
		'langue_lettre' => 'LANGUE DE LA LETTRE',
		'langue_cette_lettre' => 'LANGUE DE CETTE LETTRE :',
		'changer' => 'Changer',
		'choisir' => 'Choisir',
		'etat' => 'Cette lettre est :',
		'statut_envoi' => 'L\'envoi de cette lettre est :',
		'fenetre_envoi' => 'Envoi de la lettre',
		'fenetre_envoi_termine' => 'Envoi terminé !',
		'fenetre_envoi_en_cours' => 'Envoi en cours...',
		'fermer' => 'Fermer la fenêtre',
		'rafraichir' => 'Rafraichir',
		'envoi_termine' => 'Envoi terminé !<br /><br />Vous pouvez changer le statut de la lettre pour la valeur "Terminé !"',
		'action_publie' => 'Publiée en ligne',
		'action_brouillon' => 'En cours de rédaction',
		'action_a_envoyer' => 'A envoyer',
		'action_poubelle' => 'A supprimer',
		'action_en_cours' => 'En cours',
		'action_arreter' => 'A arrêter',
		'action_termine' => 'Terminé !',
		'action_purger' => 'Purger',
		'previsualiser_html' => 'Prévisualiser la lettre au format HTML',
		'previsualiser_texte' => 'Prévisualiser la lettre au format texte',
		'mots_cles' => 'MOTS-CLES',
		'ajouter_mot' => 'AJOUTER UN MOT-CLE :',
		'retirer_mot' => 'Retirer ce mot',
		'envoyer_lettre' => 'Envoyer cette lettre',
		'reprendre_lettre' => 'Reprendre l\'envoi de cette lettre',
		'arreter_envoi_lettre' => 'Arrêter l\'envoi de cette lettre',
		'nb_total_abonnes' => 'nombre d\'abonnés',
		'nb_total_emails_envoyes' => 'emails envoyés',
		'nb_total_emails_non_envoyes' => 'emails non envoyés',
		'nb_total_emails_attente' => 'emails à envoyer',
		'nb_total_emails_echec' => 'emails dont l\'envoi a échoué',
		'voir_message_html' => 'Voir le message HTML',
		'voir_message_texte' => 'Voir le message texte',
		'aller_liste_abonnes' => 'Aller à la liste des abonnés',
		'aller_liste_lettres' => 'Aller à la liste des lettres',
		'import_csv' => 'Import d\'abonnés depuis un fichier CSV',
		'import_etapes' => 'Etapes',
		'import_etape_1' => 'Upload du fichier CSV',
		'import_etape_2' => 'Validation de l\'import',
		'import_etape_3' => 'Inscription des nouveaux abonnés à des lettres',
		'import_etape_4' => 'Résultat de l\'import',
		'note_importation' => 'Votre fichier doit contenir une adresse email par ligne.',
		'note_preferences' => 'Pour les abonnés déjà en base, cette option n\'aura aucun effet',
		'uploader_fichier_csv' => 'Sélectionner le fichier CSV',
		'charger' => 'Charger',
		'donnees_fichier_csv' => 'Données contenues dans le fichier CSV',
		'nombre_emails_valides_fichier_csv' => 'Nombre d\'emails valides',
		'nombre_emails_non_valides_fichier_csv' => 'Nombre d\'emails non valides',
		'emails_valides_fichier_csv' => 'Emails valides contenus dans votre fichier',
		'emails_non_valides_fichier_csv' => 'Emails non valides contenus dans votre fichier',
		'importer_ces_emails' => 'Importer ces adresses email',
		'export_csv' => 'Exporter les abonnés vers un fichier CSV',
		'abonnes_ajoutes' => 'Abonnés ajoutés',
		'nombre_abonnes_ajoutes' => 'Nombre d\'abonnés ajoutés',
		'nombre_abonnes_non_ajoutes' => 'Nombre d\'abonnés non ajoutés car déjà en base',
		'nombre_abonnes_selectionnes' => 'Nombre d\'abonnés sélectionnés',
		'choix_format' => 'Choix des préférences de ces abonnés',
		'abonnes_selectionnes' => 'Abonnés sélectionnés',
		'inscrire_lettres' => 'Inscrire aux lettres',
		'abonnes_ajoutes_a_cette_lettre' => 'Nombre d\'abonnés ajoutés à cette lettre :',
		'abonnes_non_ajoutes_a_cette_lettre' => 'Nombre d\'abonnés non ajoutés car déjà inscrits :',
		'resultat' => 'Résultat de l\'envoi',
		'resultat_envoye' => 'Lettre envoyée',
		'resultat_a_envoyer' => 'Lettre non envoyée',
		'resultat_echec' => 'Echec de l\'envoi',
		'abonnes_archives' => 'Abonnés à qui on a envoyé cette archive',
		'action_archive' => 'Action sur cette archive',
		'action_archive_aucune' => 'Aucune',
		'action_archive_poubelle' => 'Supprimer',
		'envois' => 'envois',
		'envoi' => 'envoi',
		'dates' => 'DATES',
		'date_message' => 'Date du message',
		'date_debut_envoi' => 'Début de l\'envoi',
		'date_fin_envoi' => 'Fin de l\'envoi',
		'archives_abonne' => 'Archives que l\'abonné a re&ccedil;ues',
		'export_csv' => 'Export d\'abonnés vers un fichier CSV',
		'export_etapes' => 'Etapes',
		'export_etape_1' => 'Choix des abonnés à exporter',
		'export_etape_2' => 'Téléchargement du fichier',
		'exporter' => 'Exporter',
		'selectionner_abonnes_a_exporter' => 'Sélectionner les abonnés à exporter',
		'telechargement_fichier_csv' => 'Téléchargement du fichier CSV',
		'telechargement_note' => 'Le fichier CSV est généré dans le répertoire CACHE/. Il est supprimé lorsque le cache est vidé.',
		'telecharger_le_fichier' => 'Télécharger le fichier',
		'transfert' => 'Transférer des abonnés d\'une lettre vers une autre',
		'transfert_etapes' => 'Etapes',
		'transfert_etape_1' => 'Choix des abonnés à transferer et choix des lettres destinataires',
		'transfert_etape_2' => 'Résultat du transfert',
		'selectionner_abonnes_a_transferer' => 'Choix des abonnés à transferer',
		'selectionner_lettres_destinataires' => 'Choix des lettres destinataires',
		'transferer' => 'Transférer',
		'transferer_depuis' => 'Lettre d\'origine',
		'retirer_auteur' => 'Retirer cet auteur',
		'ajouter_auteur' => 'AJOUTER UN AUTEUR : ',
		'tester_envoi' => 'TESTER L\'ENVOI : ',
		'tester' => 'Tester',
		'email_test' => 'TEST',
		'logo_lettre' => 'LOGO DE LA LETTRE',
		'statistiques' => 'Statistiques',
		'statistiques_inscription' => 'Evolution des inscriptions',
		'statistiques_desinscription' => 'Evolution des désinscriptions',
		'statistiques_archives' => 'Evolution du nombre d\'envois (par archives)',
		'derniere_semaine' => 'Ces 7 derniers jours',
		'derniers_mois' => 'Ces 12 derniers mois',
		'au_fil_des_envois' => 'Au fil des envois',
		'statistiques_par_lettre' => 'Statistiques par lettre',
		'configuration_squelettes' => 'Configuration des squelettes',
		'configuration_mailer' => 'Configuration du mailer',
		'configuration_smtp' => 'Choix du mailer',
		'configuration_smtp_descriptif' => 'Si vous n\'êtes pas sûrs, choisissez la fonction mail de PHP.',
		'utiliser_mail' => 'Utiliser la fonction mail de PHP',
		'utiliser_smtp' => 'Utiliser SMTP',
		'spip_lettres_smtp_host' => 'Hôte :',
		'spip_lettres_smtp_port' => 'Port :',
		'spip_lettres_smtp_auth' => 'Requiert une authentification :',
		'spip_lettres_smtp_auth_oui' => 'oui',
		'spip_lettres_smtp_auth_non' => 'non',
		'spip_lettres_smtp_username' => 'Nom d\'utilisateur :',
		'spip_lettres_smtp_password' => 'Mot de passe :',
		'spip_lettres_smtp_sender' => 'Retour des erreurs (optionnel)',
		'spip_lettres_smtp_sender_descriptif' => 'Définit dans l\'entête du mail l\'adresse email de retour des erreurs (ou Return-Path), et lors d\'un envoi via la méthode SMTP cela définit aussi l\'adresse de l\'envoyeur.',


		// Formulaires
		'lettres_information' => 'Lettres d\'information',
		'email' => 'Email',
		'format' => 'Format',
		'format_html' => 'HTML',
		'format_texte' => 'Texte',
		'format_mixte' => 'Mixte',
		'valider' => 'Valider',
		'action' => 'Action',
		'action_inscription' => 'Inscription',
		'action_desinscription' => 'Désinscription',
		'action_changement_format' => 'Changement de format',
		'validation_inscription_succes' => 'Votre inscription a bien été validée.',
		'validation_inscription_erreur' => 'Votre inscription n\'a pu être validée.',
		'validation_desinscription_succes' => 'Votre désinscription a été validée.',
		'validation_desinscription_erreur' => 'Votre désinscription n\'a pas pu être validée.',
		'validation_changement_succes' => 'Votre changement de format vient d\'être pris en compte.',
		'validation_changement_erreur' => 'Votre changement de format n\'a pas pu être pris en compte.',
		'redirection_erreur' => 'Une erreur empêche la redirection.',
		'action_inconnue' => 'Action inconnue.',
		'contactez_webmaster' => 'Contactez le webmaster :',
		'envoi_inscription_succes' => 'Vous allez recevoir un email pour confimer votre inscription à la/aux lettre(s) suivante(s) :',
		'envoi_inscription_erreur' => 'L\'email pour confirmer votre inscription n\'a pas pu être envoyé.',
		'envoi_desinscription_succes' => 'Vous allez recevoir un email pour confimer votre désinscription à la/aux lettre(s) suivante(s) :',
		'envoi_desinscription_erreur' => 'L\'email pour confirmer votre désinscription n\'a pas pu être envoyé.',
		'envoi_changement_format_succes' => 'Vous allez recevoir un email pour confimer votre changement de format.',
		'envoi_changement_format_erreur' => 'L\'email pour confirmer votre changement de format n\'a pas pu être envoyé.',
		'webmaster' => 'Webmaster',
		'email_non_valide' => 'L\'email fourni n\'est pas valide',
		'liste_lettres_vide' => 'Sélectionnez au moins une lettre.',
		'objet_inscription' => 'Confirmation inscription',
		'objet_desinscription' => 'Confirmation désinscription',
		'objet_changement_format' => 'Confirmation de changement de format',
		'deja_abonne' => 'Vous êtes déjà abonnés à cette lettre',
		'pas_abonne' => 'Vous n\'êtes pas abonnés à cette lettre',
		'changement_affecte_toutes_les_lettres' => 'Le changement de format affecte toutes les lettres auquelles vous êtes abonnés.',
		'auteurs' => 'AUTEURS',


		// Abonné
		'etat_abonne' => 'Action sur cet abonné :',
		'etat_abonne_aucune' => 'Aucune',
		'etat_abonne_poubelle' => 'Supprimer',
		'abonne' => 'abonné',
		'abonnes_a_valider' => 'Abonnés en attente de validation',
		'abonnes_valides' => 'Abonnés validés',
		'abonnes_non_inscrits' => 'Abonnés inscrits à aucune lettre',
		'nouvel_abonne' => 'email@abonne.com',
		'email' => 'Email',
		'format' => 'Format',
		'inscriptions' => 'Inscriptions',
		'archives' => 'Archives',
		'numero_abonne' => 'ABONNE NUMERO',
		'abonne_edition' => 'Edition d\'un abonné',
		'code' => 'Code',
		'maj_le' => 'Mis à jour le',
		'modifier_abo' => 'Modifier cet abonné',
		'editer_abo' => 'Editer l\'abonné',
		'email_o' => '<b>Email</b> [Obligatoire]',
		'format_o' => '<b>Format</b> [Obligatoire]',
		'retour_liste' => 'Retour à la liste des abonnés',
		'abonnements' => 'Abonnements',
		'desabonner' => 'Désabonner',
		'inscrire_abo' => 'INSCRIRE CET ABONNE A',
		'inscrire' => 'Inscrire',
		'statut_valide' => 'Inscrit',
		'statut_a_valider' => 'En attente',
		'inscription' => 'inscription',
		'inscriptions' => 'inscriptions',

		// Squelettes
		'se_desinscrire' => 'Se désinscrire de cette lettre',
		'titre_changement_format' => 'Validation de votre changement de format',
		'titre_desinscription' => 'Validation de votre(vos) désinscription(s)',
		'titre_inscription' => 'Validation de votre(vos) inscription(s)',
		'valider_changement_format' => 'Valider le changement de format',
		'valider_desinscription' => 'Valider votre(vos) désinscription(s)',
		'valider_inscription' => 'Valider votre(vos) inscription(s)',
		'texte_changement_format' => 'Vous avez demandé à changer le format des lettres auxquelles vous êtes abonnés sur '.lire_meta('nom_site'),
		'texte_desinscription' => 'Sur '.lire_meta('nom_site').', vous avez demandé à vous désinscrire des lettres d\'information suivantes :',
		'texte_inscription' => 'Sur '.lire_meta('nom_site').', vous avez demandé à vous inscrire aux lettres d\'information suivantes :',
		'retour' => 'Retour',


		'Z' => 'ZZzZZzzz'

	);

?>