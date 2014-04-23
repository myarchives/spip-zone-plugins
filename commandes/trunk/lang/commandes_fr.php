<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// Fichier source, a modifier dans svn://zone.spip.org/spip-zone/_plugins_/commandes/trunk/lang/
if (!defined('_ECRIRE_INC_VERSION')) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'abbr_hors_taxe' => 'HT',
	'abbr_quantite' => 'Qté',
	'action_facture' => 'Facture',
	'action_modifier' => 'Modifier',
	'action_supprimer' => 'Supprimer',
	'adresse_facturation' => 'Adresse de facturation',
	'adresse_livraison' => 'Adresse de livraison',

	// B
	'bonjour' => 'Bonjour',

	// C
	'commande_client' => 'Client',
	'commande_date' => 'Date',
	'commande_date_paiement' => 'Date de paiement',
	'commande_editer' => 'Éditer la commande',
	'commande_modifier' => 'Modifier la commande :',
	'commande_montant' => 'Montant',
	'commande_nouvelle' => 'Nouvelle commande',
	'commande_numero' => 'Commande ',
	'commande_reference' => 'Référence',
	'commande_reference_numero' => 'Référence n° ', # MODIF
	'commande_statut' => 'Statut',
	'commande_titre' => 'Commande',
	'commandes_titre' => 'Commandes',
	'configurer_notifications_commandes' => 'Configurer les notifications',
	'configurer_titre' => 'Configurer le plugin Commandes',
	'confirmer_supprimer_commande' => 'Confirmez-vous la suppression de la commande ?',
	'contact_label' => 'Contact :',
	'contenu' => 'Contenu',

	// D
	'date_commande_label' => 'Date de création :',
	'date_envoi_label' => 'Date d’envoi :',
	'date_maj_label' => 'Dernière mise à jour :',
	'date_paiement_label' => 'Date de paiement :',
	'designation' => 'Désignation',
	'details_commande' => 'Détails de commande :',

	// E
	'etat' => 'État',
	'explications_notifications_statuts' => 'Notification lors du changement d’état',
	'explications_notifications_statuts_aucune' => 'Aucune notification lors du changement d’état',
	'explication_frais_de_port' => 'Montant sans la devise',

	// F
	'facture_date' => 'Date : <span>@date@</span>',
	'facture_num' => 'Facture n° <span>@num@</span>',
	'facture_titre' => 'Facture',

	// I
	'info_1_commande' => '1 commande',
	'info_1_commande_statut_attente' => '1 commande en attente de validation',
	'info_1_commande_statut_partiel' => '1 commande partiellement payée',
	'info_1_commande_statut_paye' => '1 commande payée',
	'info_aucun_commande' => 'Aucune commande',
	'info_commandes' => 'Commandes',
	'info_date_envoi_vide' => 'commande non envoyée',
	'info_date_non_definie' => 'non définie',
	'info_date_paiement_vide' => 'commande non payée',
	'info_nb_commandes' => '@nb@ commandes',
	'info_nb_commandes_statut_attente' => '@nb@ commandes en attente de validation',
	'info_nb_commandes_statut_partiel' => '@nb@ commandes partiellement payées',
	'info_nb_commandes_statut_paye' => '@nb@ commandes payées',
	'info_numero' => 'COMMANDE NUMÉRO :',
	'info_numero_commande' => 'COMMANDE NUMÉRO :',
	'info_toutes_commandes' => 'Toutes les commandes',

	// L
	'label_commande_dates' => 'Dates',
	'label_filtre_clients' => 'Clients',
	'label_filtre_dates' => 'Dates',
	'label_filtre_etats' => 'Etats',
	'label_filtre_tous_clients' => 'Tous les clients',
	'label_filtre_tous_statuts' => 'Tous les états',
	'label_filtre_toutes_dates' => 'Toutes les dates',
	'label_objet' => 'Objet',
	'label_passee_le' => 'passée le',
	'label_payee_le' => 'payée le',
	'label_recherche' => 'Rechercher',
	'label_frais_de_port' => 'Frais de port',
	'label_mode_paiement' => 'Mode de paiement',
	'label_sous_total_ttc' => 'Sous-total TTC',

	// M
	'merci_de_votre_commande' => 'Nous avons bien enregistré votre commande et nous vous remercions de votre confiance.',
	'modifier_commande_statut' => 'Cette commande est :',
	'montant' => 'Montant',
	'montant_ttc' => 'Montant TTC',

	// N
	'nom_bouton_plugin' => 'Commandes',
	'notifications_activer_explication' => 'Envoyer par mail des notifications de commande ?',
	'notifications_activer_label' => 'Activer',
	'notifications_cfg_titre' => 'Notifications',
	'notifications_client_explication' => 'Envoyer les notifications au client ?',
	'notifications_client_label' => 'Client',
	'notifications_expediteur_administrateur_label' => 'Choisir un administrateur :',
	'notifications_expediteur_choix_administrateur' => 'un administrateur',
	'notifications_expediteur_choix_email' => 'un email',
	'notifications_expediteur_choix_facteur' => 'idem plugin Facteur',
	'notifications_expediteur_choix_webmaster' => 'un webmestre',
	'notifications_expediteur_email_label' => 'Email de l’expéditeur :',
	'notifications_expediteur_explication' => 'Choisir l’expéditeur des notifications pour le vendeur et l’acheteur',
	'notifications_expediteur_label' => 'Expéditeur',
	'notifications_expediteur_webmaster_label' => 'Choisir un webmestre :',
	'notifications_explication' => 'Les notifications permettent d’envoyer des emails suite aux changements de statut des commandes : En attente de validation, en cours, envoyée, partiellement payée, payée, retournée, retour partiel. Cette fonctionnalité nécessite le plugin Notifications Avancées.',
	'notifications_parametres' => 'Paramètres des notifications',
	'notifications_quand_explication' => 'Quel(s) changement(s) de statut déclenche(nt) l’envoi d’une notification ?',
	'notifications_quand_label' => 'Déclenchement',
	'notifications_vendeur_administrateur_label' => 'Choisir un ou plusieurs administrateurs :',
	'notifications_vendeur_choix_administrateur' => 'un ou des administrateurs',
	'notifications_vendeur_choix_email' => 'un ou des emails',
	'notifications_vendeur_choix_webmaster' => 'un ou des webmestres',
	'notifications_vendeur_email_explication' => 'Saisir un ou plusieurs email séparés par des virgules :',
	'notifications_vendeur_email_label' => 'Email(s) du vendeur :',
	'notifications_vendeur_explication' => 'Choisir le(s) destinataire(s) des notifications pour les envois au vendeur',
	'notifications_vendeur_label' => 'Vendeur',
	'notifications_vendeur_webmaster_label' => 'Choisir un ou plusieurs webmestres :',

	// P
	'parametres_cfg_titre' => 'Paramètres',
	'parametres_duree_vie_explication' => 'Saisir la durée de vie (en heures) d’une commande avec le statut en cours',
	'parametres_duree_vie_label' => 'Durée de vie',
	'passer_la_commande' => 'Passer la commande',
	'paiement_espece' => 'Espèces',
	'paiement_cheque' => 'Chèque',
	'paiement_virement' => 'Virement bancaire',
	'paiement_cb' => 'Carte bancaire',
	'paiement_paypal' => 'Paypal',
	'paiement_bitcoin' => 'Bitcoin',
	'paiement_autre' => 'Autre',

	// R
	'recapitulatif' => 'Récapitulatif de commande :',
	'reference' => 'Référence',
	'reference_label' => 'Référence :',
	'reference_ref' => 'Référence @ref@',

	// S
	'simuler' => 'Simuler changement de statut',
	'statut_attente' => 'En attente de validation',
	'statut_encours' => 'En cours',
	'statut_envoye' => 'Envoyée',
	'statut_erreur' => 'Erreur',
	'statut_label' => 'Statut :',
	'statut_partiel' => 'Partiellement payée',
	'statut_paye' => 'Payée',
	'statut_retour' => 'Retournée',
	'statut_retour_partiel' => 'Retour partiel',
	'supprimer' => 'Supprimer',

	// T
	'texte_changer_statut_commande' => 'Cette commande est :',
	'titre_adresse_client' => 'Adresse du client',
	'titre_adresse_commande' => 'Adresse associée à la commande',
	'titre_adresses_associees' => 'Adresses associées',
	'titre_adresses_client' => 'Adresses du client',
	'titre_adresses_commande' => 'Adresses associées à la commande',
	'titre_commandes_actives' => 'Commandes actives',
	'titre_commandes_auteur' => 'Commandes de l’auteur',
	'titre_contenu_commande' => 'Contenu de la commande',
	'titre_informations_client' => 'Client',
	'titre_logo_commande' => 'Logo de la commande',

	// U
	'une_commande_de' => 'Une commande de : ',
	'une_commande_sur' => 'Une commande sur @nom@',

	// V
	'votre_commande_sur' => '@nom@ : votre commande'
);

?>
