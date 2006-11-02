<?php
	/**
	 *
	 * CleverMail : plugin de gestion de lettres d'information bas� sur CleverMail
	 * Author : Thomas Beaumanoir
	 * Clever Age <http://www.clever-age.com>
	 * Copyright (c) 2006
	 *
	 **/

	$GLOBALS[$GLOBALS['idx_lang']] = array(
		// Front
		'email' => 'E-mail :',
		'version' => 'Version :',
		'inscription_lettre' => 'Inscrivez-vous &agrave; notre lettre d\'information :',
		'inscription_lettres' => 'Inscrivez-vous &agrave; nos lettres d\'information :',
		'deja_inscrit' => 'Vous &eacute;tiez d&eacute;j&agrave; inscrit &agrave; cette lettre d\'information. Votre mode d\'inscription a &eacute;t&eacute; mis &agrave; jour.',
		'inscription_validee' => 'Votre inscription est valid&eacute;e. Merci',
		'desinscription_validee' => 'Votre d&eacute;sinscription est valid&eacute;e. A bient&ocirc;t',
		'deja_validee' => 'Cette op&eacute;ration a d&eacute;j&agrave; &eacute;t&eacute; valid&eacute;e. Merci.',
		'aucune_inscription' => 'Aucune inscription ne correspond &agrave; ce param&egrave;tre.',
		'desinscription_confirmation_debut' => 'D&eacute;sinscription de la lettre d\'information',
		'desinscription_confirmation_fin' => 'demand&eacute;e. Vous allez recevoir un message demandant confirmation.',
		'ok' => 'Inscription demand&eacute;e. Vous allez recevoir un message de demande de confirmation.',
		'nok' => 'Inscription non authoris&eacute;e pour cette lettre d\'information',
		'mok' => 'Inscription en attente de validation par le mod&eacute;rateur.',
		'send_error' => 'Erreur lors de l\'envoi',
		'email_non_valide' => 'Adresse non valide',

		// Back
		'liste_lettres' => 'Liste des lettres d\'information',
		'creer_lettre' => 'Cr&eacute;er une lettre d\'information',
		'liste_abonnes' => 'Liste des abonn&eacute;s',
		'ajouter_abonne' => 'Ajouter un abonn&eacute;',
		'parametres' => 'Param&egrave;tres',
		'rechercher_abonne' => 'Rechercher un abonn&eacute; :',
		'editer_lettre' => 'Editer la lettre d\'information',
		'abonne' => 'abonn&eacute;',
		'abonnes' => 'abonn&eacute;s',
		'aucun_abonne' => 'aucun abonn&eacute;',
		'message' => 'message',
		'messages' => 'messages',
		'aucun_message' => 'aucun message',
		'statistiques' => 'Statistiques',
		'actions' => 'Actions',
		'modifier' => 'modifier',
		'modifier_submit' => 'Modifier',
		'supprimer' => 'supprimer',
		'envoyer' => 'envoyer',
		'nouveau_message' => 'nouveau message',
		'nouveaux_messages' => 'Nouveaux Messages',
		'messages_attentes' => 'Messages en attente',
		'messages_envoyes' => 'Messages envoy&eacute;s',
		'creer_nouveau_message' => 'Cr&eacute;er un nouveau message',
		'supprimer_abonnes' => 'Supprimer les abonn&eacute;s s&eacute;l&eacute;ctionn&eacute;s',
		'emails' => 'E-mails',
		'a_partir_csv' => 'A partir d\'un fichier CSV :',
		'abonne_lettres' => 'Abonner aux lettres d\'information',
		'mode' => 'Mode',
		'importer' => 'Importer',
		'aucun_abonne_ajoute' => 'aucun abonn&eacute; ajout&eacute;',
		'abonne_ajoute' => 'abonn&eacute; ajout&eacute;',
		'abonnes_ajoutes' => 'abonn&eacute;s ajout&eacute;s',
		'abonne_maj' => 'abonn&eacute; mis &agrave; jour',
		'abonnes_maj' => 'abonn&eacute;s mis &agrave; jour',
		'erreur' => 'Erreur',
		'lettre_meme_nom' => 'Une lettre d\'information porte d&eacute;j&agrave; ce nom',
		'lettre_sans_nom' => 'Une lettre d\'information doit avoir un nom',
		'tags_specifiques' => 'Tags sp&eacute;cifiques',
		'configuration_generale' => 'Configuration g&eacute;n&eacute;rale',
		'nom' => 'Nom',
		'description' => 'Description',
		'moderation' => 'Mod&eacute;ration',
		'mod_open' => 'Ouverte : tout le monde peut s\'inscrire sans confirmation',
		'mod_email' => 'E-mail : tout le monde peut s\'inscrire apr&egrave;s confirmation par e-mail',
		'mod_mod' => 'Mod&eacute;r&eacute;e : le mod&eacute;rateur doit accepter l\'inscription',
		'mod_closed' => 'Ferm&eacute;e : personne ne peut s\'inscrire',
		'email_moderateur' => 'E-mail du mod&eacute;rateur',
		'prefixer_messages' => 'Pr&eacute;fixer les sujets des messages avec le nom de la lettre d\'information',
		'confirmation_inscription' => 'Confirmation d\'une inscription envoy&eacute; par e-mail',
		'confirmation_votre_inscription' => 'Confirmation de votre inscription',
		'confirmation_votre_inscription_text' => "\nBonjour,\n\nPour confirmer votre inscription � la lettre d'information @@NOM_LETTRE@@ au format @@FORMAT_INSCRIPTION@@, veuillez confirmer votre inscription en cliquant sur ce lien :\n\n @@URL_CONFIRMATION@@\n\nMerci\n",
		'confirmation_desinscription' => 'Confirmation d\'une d&eacute;sinscription envoy&eacute; par e-mail',
		'confirmation_votre_desinscription' => 'Confirmation de votre d&eacute;sinscription',
		'confirmation_votre_desinscription_text' => "\nBonjour,\n\nVeuillez confirmer votre d&eacute;sinscription en cliquant sur ce lien :\n\n @@URL_CONFIRMATION@@\n\nMerci\n",
		'sujet' => 'Sujet',
		'url_templates' => 'URL des templates g&eacute;n&eacute;r&eacute;s',
		'version_html' => 'Version HTML',
		'version_txt' => 'Version TXT',
		'annuler' => 'Annuler',
		'creer' => 'Cr&eacute;er',
		'cree' => 'Cr&eacute;&eacute;',
		'envoye' => 'Envoy&eacute;',
		'modifie' => 'Modifi&eacute;',
		'apercu' => 'Aper&ccedil;u',
		'queue_attente' => ' en attente et ',
		'queue_envoye' => ' envoy&eacute;',
		'mauvais_identifiant_lettre' => 'Mauvais identifiant de lettre d\'information',
		'email_administrateur' => 'E-mail administrateur',
		'email_expediteur' => 'E-mail exp&eacute;diteur (from et reply-to)',
		'nombre_messages' => 'Nombre de messages par envoi',
		'info_parametres' => 'L\'e-mail de l\'administrateur est utilis&eacute; par d&eacute;faut comme l\'e-mail du mod&eacute;rateur lors de la cr&eacute;ation d\'une newsletter',
		'nouveaux_messages_text' => 'Ici sont list&eacute;s les messages qui ne sont pas encore envoy&eacute;s',
		'messages_attentes_text' => 'Ici sont list&eacute;s les messages qui sont en file d\'attente pour &ecirc;tre envoy&eacute;s',
		'messages_envoyes_text' => 'Ici sont list&eacute;s les messages qui ont &eacute;t&eacute; envoy&eacute;s avec succ&egrave;s',
		'creer_message' => 'Cr&eacute;er un message',
		'modifier_message' => 'Modifier un message',
		'sujet_message' => 'Sujet du message',
		'sujet_vide' => 'Le sujet ne doit pas &ecirc;tre vide',
		'modifier_abonne' => 'Modifier un abonn&eacute;',
		'lettres_information' => 'Lettres d\'information',
		'desabonner' => 'D&eacute;sabonner',
		'desabonner2' => 'd&eacute;sabonner',
		'abonne_aucune_lettre' => 'Abonn&eacute; &agrave; aucune newsletter',
		'supprimer_abonne_base' => 'Supprimer d&eacute;finitivement cet abonn&eacute; de la base',
		'abonne_inconnu' => 'Abonn&eacute; inconnu',
		'resultats' => 'r&eacute;sultats',
		'aucun_resultat' => 'Aucun r&eacute;sultat',
		'supprimer_abonnes' => 'Supprimer les abonn&eacute;s selectionn&eacute;s',
		'desabonner_abonnes' => 'D&eacute;sabonner les abonn&eacute;s selectionn&eacute;s',
		'confirme_suppression_multiple_base' => 'Vous &ecirc;tes sur le point de supprimer des abonn&eacute;s de la base. &Eacute;tes vous sur ?',
		'confirme_desabonnement_multiple_lettre' => 'Vous &ecirc;tes sur le point de d&eacute;sabonner plusieurs abonn&eacute;s de cette liste. &Eacute;tes vous sur ?'
	);
?>