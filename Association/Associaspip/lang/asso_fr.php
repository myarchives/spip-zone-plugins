<?php
/***************************************************************************
 *  Associaspip, extension de SPIP pour gestion d'associations             *
 *                                                                         *
 *  Copyright (c) 2007 Bernard Blazin & Francois de Montlivault (V1)       *
 *  Copyright (c) 2010-2011 Emmanuel Saint-James & Jeannot Lapin (V2)       *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

// This is a SPIP language file  --  Ceci est un fichier langue de SPIP

$GLOBALS[$GLOBALS['idx_lang']] = array(

# Globaux (interface)
	# Titres globaux
	'titre_gestion_pour_association' => 'Gestion pour Association',
	'titre_relance' => 'Renouvellement de votre cotisation',
	'titre_menu_gestion_association' => 'Gestion Association',
	'titre_page_config' => 'Configuration du plugin',
	# Navigation : Nom des onglets
	'menu2_titre_association' => 'L\'association',
	'menu2_titre_gestion_membres' => 'Membres',
	'menu2_titre_relances_cotisations' => 'Relances des cotisations',
	'menu2_titre_gestion_dons' => 'Dons',
	'menu2_titre_ventes_asso' => 'Ventes',
	'menu2_titre_gestion_activites' => 'Activit&eacute;s',
	'menu2_titre_livres_comptes' => 'Comptes',
	'menu2_titre_gestion_prets' => 'Pr&ecirc;ts',
	# Navigation : Nom des modules
	'titre_onglet_defaut' => 'Gestion de l\'association @nom@',
	'titre_onglet_activite' => 'Gestion des activit&eacute;s',
	'titre onglet association' => 'Param&eacute;trage de la gestion associative',
	'titre_onglet_membres' => 'Gestion des membres',
	'titre_onglet_dons' => 'Gestion des dons',
	'titre_onglet_ventes' => 'Gestion des ventes',
	'titre_onglet_comptes' => 'Gestion comptable',
	'titre_onglet_prets' => 'Gestion des pr&ecirc;ts',
# Communs
	# Entetes communes
	'entete_action' => 'Action',
	'entete_actions' => 'Actions',
	'entete_code' => 'R&eacute;f./Code',
	'entete_commentaire' => 'Commentaire',
	'entete_date' => 'Date',
	'entete_duree' => 'Dur&eacute;e',
	'entete_intitule' => 'Intitul&eacute;',
	'entete_id' => 'ID',
	'entete_montant' => 'Montant',
	'entete_nom' => 'Nom',
	'entete_num' => 'N<sup>o</sup>',
	'entete_quantite' => 'Q<sup>t&eacute;</sup>',
	'entete_statut' => 'Statut',
	'entete_solde' => 'Solde',
	'entete_tous' => 'Tous',
	# Libelles communes
	'libelle_commentaire' => 'Commentaire',
	'libelle_duree' => 'Dur&eacute;e',
	'libelle_date' => 'Date (AAAA-MM-JJ)',
	'libelle_intitule' => 'Intitul&eacute; complet',
	'libelle_montant' => 'Montant (Euros)',
	'libelle_nd_mbr' => 'N<sup>o</sup> de membre',
	'libelle_nom' => 'Nom',
	'libelle_num' => 'N<sup>o</sup>',
	'libelle_quantite' => 'Quantit&eacute;',
	'libelle_statut' => 'Statut',
	# Listes communs
	'liste_nombre_total' => 'Total&nbsp;:',
	# Boutons communs
	'bouton_ajouter' => 'Ajouter',
	'bouton_confirmer' => 'Confirmer',
	'bouton_desactiver' => 'D&eacute;sactiver',
	'bouton_envoyer' => 'Envoyer',
	'bouton_impression' => 'Impression',
	'bouton_modifier' => 'Modifier',
	'bouton_soumettre' => 'Soumettre',
	'bouton_retour' => 'Retour',
	'bouton_supprimer' => 'Supprimer',
	'bouton_valider' => 'Valider',
	# Mois (definis dans SPIP  sous leur nom complet) abregees  <http://fr.wikipedia.org/wiki/Mois#Abr.C3.A9viations>
	'date_mois_1' => 'jan.',
	'date_mois_2' => 'f&eacute;v.',
//	'date_mois_3' => 'mars',
	'date_mois_4' => 'avr.',
//	'date_mois_5' => 'mai',
//	'date_mois_6' => 'juin',
	'date_mois_7' => 'juill.',
//	'date_mois_8' => 'ao&ucirc;t',
	'date_mois_9' => 'sept.',
	'date_mois_10' => 'oct.',
	'date_mois_11' => 'nov.',
	'date_mois_12' => 'd&eacute;c.',
	# Chaines communes (en majorite) parametriques
	'devise_code_iso' => 'EUR', // pour les code ISO cf. <http://fr.wikipedia.org/wiki/Liste_des_monnaies_en_circulation> & <http://fr.wikipedia.org/wiki/Codes_ISO_4217_des_monnaies>
	'devise_symbole' => '&euro;', // pour les entites (X)HTML cf. <http://webdesign.about.com/od/localization/l/blhtmlcodes-cur.htm> & <http://fr.wikipedia.org/wiki/Symbole_mon%C3%A9taire> &  <http://fr.wikipedia.org/wiki/Aide:Liste_de_caract%C3%A8res_sp%C3%A9ciaux#Symboles_mon.C3.A9taires>
	'devise_nom' => 'Euro', // les noms des monnaies ne dependent pas de la langue mais du pays et sont communs a beaucoup : cf <http://www.baudelet.net/monnaies/> ; utiliser le symbole pour indiquer le nom generique (cf. ) ou le code ISO pour preciser la devise exacte d'un pays : cf <http://fr.wikipedia.org/wiki/Liste_des_monnaies_en_circulation>
	'devise_montant' => '@montant@&nbsp;@devise@', // pays francophones/luxophone/etc. : '@nombre@&nbsp;@devise@' ; pays anglophones/germanophones/etc. : '@devise@&nbsp;@nombre@' ; pour l'usage, cf. <http://programmer.spip.org/Syntaxe-complete-des-codes-de> & <http://programmer.spip.org/Codes-de-langue-en-PHP>
	'duree_temps' => '@nombre@&nbsp;@unite@',
	'nombre_fois' => '@nombre@ fois',
	'objet_num' => '@objet@ n<sup>o</sup>&nbsp;:&nbsp;@num@',
	'titre_num' => '@titre@&nbsp;@num@',
	'totaux_montants' => 'Montants Totaux @de_par@',
	'totaux_montants' => 'Bilan financier @de_par@',
	'totaux_nombres' => 'Nombres Totaux @de_par@',
	'totaux_nombres' => 'Effectif @de_par@',
	'totaux_moyens' => 'Statistiques @de_par@',
	'date_du_jour' => 'Nous sommes le @date@',
	'date_du_jour_heure' => 'Nous sommes le @date@ et il est @time@',

# Configuration du plugin
	# Configuration : Libelles
	'config_libelle_nom' => 'Nom',
	'config_libelle_email' => 'Adresse courriel',
	'config_libelle_adresse' => 'Adresse',
	'config_libelle_rue' => 'Rue',
	'config_libelle_num_rue' => 'N&deg;',
	'config_libelle_ville' => 'Ville',
	'config_libelle_pays' => 'Pays',
	'config_libelle_codepostal' => 'Code Postal',
	'config_libelle_telephone' => 'T&eacute;l&eacute;phone',
	'config_libelle_declaration' => 'N&deg; de d&eacute;claration',
	'config_libelle_prefet' => 'Pr&eacute;fecture ou Sous-pr&eacute;fecture',
	'config_libelle_objet' => 'Objet',
	'config_info_recufiscal' => 'Re&ccedil;u fiscal fran&ccedil;ais',
	'config_libelle_codefiscal' => 'R&eacute;ductions d\'imp&ocirc;ts applicable selon :',
	'config_libelle_cgi200' => 'Art. 200 du CGI',
	'config_libelle_cgi238' => 'Art. 238 bis du CGI',
	'config_libelle_cgi885' => 'Art. 885-0 V bis A du CGI',
	'config_libelle_recufiscal' => 'Type',
	'config_libelle_infofiscal' => 'Pr&eacute;cision(s)',
	'config_libelle_tauxfiscal' => '% cotisation statutaire',
	'config_libelle_recufisc0' => 'D&eacute;sactiver (gestion manuelle ou non-usage)',
	'config_libelle_recufisc1' => 'Asso./fond. reconnue d-u-p (pr&eacute;ciser dates)',
	'config_libelle_recufisc2' => 'Asso. du 57/67/68 dont la mission est reconnue d-u-p (pr&eacute;ciser date)',
	'config_libelle_recufisc3' => 'Fondation universitaire/partenariale',
	'config_libelle_recufisc4' => 'Fondation d\'entreprise',
	'config_libelle_recufisc5' => '&OElig;uvre/org. d-i-g',
	'config_libelle_recufisc6' => 'Mus&eacute;e de France',
	'config_libelle_recufisc7' => 'Ets. d\'enseignement sup./artistique pub./priv&eacute;, d-i-g, s-b-l',
	'config_libelle_recufisc8' => 'Org. dont l\'objet exclusif est la participation financi&egrave;re &agrave; la cr&eacute;ation d\'ent.',
	'config_libelle_recufisc9' => 'Asso. culturelle ou de bienfaisance et ets. pub. des cultes reconnus d\'Alsace-Moselle',
	'config_libelle_recufisc10' => 'Org. ayant pour activit&eacute; principale l\'organisation de festivals',
	'config_libelle_recufisc11' => 'Asso. fournissant gratuitement aide/soins &agrave; pers. en difficult&eacute;...',
	'config_libelle_recufisc12' => 'Fond. du patrimoine ou fond./asso. lui affectant ses dons',
	'config_libelle_recufisc13' => 'Ets. de recherche public/priv&eacute;, d-i-g, s-b-l',
	'config_libelle_recufisc14' => 'Ent. d\'insertion ou ent. de travail temporaire d\'insertion',
	'config_libelle_recufisc15' => 'Asso. interm&eacute;diaires',
	'config_libelle_recufisc16' => 'Ateliers/chantiers d\'insertion',
	'config_libelle_recufisc17' => 'Ent. adapt&eacute;es',
	'config_libelle_recufisc18' => 'Agence Nationale de la Recherche',
	'config_libelle_recufisc19' => 'St&eacute;./org. agr&eacute;&eacute; de recherche scientifique/technique',
	'config_libelle_recufisc20' => 'Autre organisme (&agrave; pr&eacute;ciser)',
	'config_libelle_classe_banques' => 'Classe des comptes financiers',
	'config_libelle_classe_charges' => 'Classe des comptes de charges',
	'config_libelle_classe_produits' => 'Classe des comptes de produits',
	'config_libelle_classe_contributions_volontaires' => 'Classe des comptes de contrib. volontaires',
	'config_libelle_dons'=> 'Gestion des dons et colis',
	'config_libelle_activer_dons'=> 'Activer la gestion des dons et colis',
	'config_libelle_cotisations'=> 'Gestion des cotisations',
    'config_libelle_activer_cotisations' => 'Activer la gestion des cotisations',
	'config_libelle_ventes'=> 'Gestion des ventes associatives',
	'config_libelle_activer_ventes'=> 'Activer la gestion des ventes associatives',
	'config_libelle_frais_envoi'=> 'frais d\'envoi',
	'config_libelle_comptes'=> 'Gestion comptable',
	'config_libelle_activer_comptes'=> 'Activer la gestion comptable',
	'config_libelle_destinations'=> 'Activer la gestion des destinations comptables',
	'config_libelle_activites'=> 'Gestion des inscriptions aux activit&eacute;s (n&eacute;cessite le plugin Agenda)',
	'config_libelle_activer_activites'=> 'Activer la gestion des inscriptions aux activit&eacute;s',
	'config_libelle_prets'=> 'Gestion des pr&egrave;ts et ressources',
	'config_libelle_activer_prets'=> 'Activer la gestion des pr&egrave;ts et ressources',
	'config_libelle_indexation'=> 'Num&eacute;rotation des membres',
	'config_libelle_num_pc'=>'R&eacute;f. comptable',
	'config_libelle_num_dc'=>'Dest. comptable',
	'config_libelle_import_nom_auteur' => 'Lors de l\'import/cr&eacute;ation d\'un membre depuis la liste des auteurs SPIP, le nom de l\'auteur a le format suivant:',
	'config_libelle_utiliser_champ_id_asso' => 'R&eacute;f&eacute;rence interne <abbr title="Attention, ce champ est purement informatif les membres sont toujours d&eacute;sign&eacute;s et organis&eacute;s par leur id auteur SPIP mais il permet aux associations qui le d&eacute;sirent d\'avoir une r&eacute;f&eacute;rence membre de leur choix et de conserver cette information dans les tables du plugin">(&agrave; caract&egrave;re informatif)</abbr>',
	'config_libelle_gerer_champs_membres' => 'La fiche des membres contient les champs :',
	'config_plan_comptable_prerenseigne' => 'Activer l\'aide &agrave; la d&eacute;claration du plan comptable (fran&ccedil;ais uniquement)',
	'config_libelle_categorie_par_defaut' => 'Cat&eacute;gorie de cotisation des nouveaux membres',
	'config_libelle_affichage_champs_page_membres' => 'S&eacute;lectionner les champs &agrave; afficher sur la page des membres',
	'config_libelle_virements_internes' => 'R&eacute;f. virements internes',
	# Configuration : Options
	'import_nom_auteur_nom_prenom' => 'Nom Pr&eacute;nom',
	'import_nom_auteur_prenom_nom' => 'Pr&eacute;nom Nom',
	'import_nom_auteur_nom' => 'Nom',
	'config_info_asso' => 'Donn&eacute;es de l\'association',
	'config_info_plugin' => 'Options du plugin',
	'config_info_membres' => 'Options de gestion des membres',
	# Configuration : Infos, Aides et Messages
	'config_erreur_pas_de_destination_definie' => 'Pas de destination comptable d&eacute;finie',
	'config_aide_infofiscal' => 'Dates au format jj/mm/aaaa s&eacute;par&eacute;es par un espace.',
	'config_aide_recufiscal' => 'sigles :
		s-b-l = &agrave; but non lucratif ;
		d-i-g = d\'int&eacute;r&egrave;t g&eacute;n&eacute;ral ;
		d-u-p = d\'utilit&eacute; publique ;
		<br />abbr&eacute;viations :
		asso. = association(s) ;
		fond. = fondation(s) ;
		ent. = entreprise(s) ;
		ets. = &eacute;tablissement(s) ;
		org. = organisme(s) ;
		pers. = personne(s) ;
		pub. = public(s)/publique(s) ;
		st&eacute;. = soci&eacute;t&eacute;(s) ;
		sup. = sup&eacute;rieur(e)(s) ;
	...',
	'config_aide_pays' => 'code alpha-2 ISO 3166-1',
	'choisir_cat_defaut' => 'Aucune cat&eacute;gorie par d&eacute;faut',
	'choisir_ref_compte' => '-- Choisir une r&eacute;f&eacute;rence comptable',
	'choisir_dest_compte' => '-- Choisir une destination par d&eacute;faut',
	'choisir_classe_compte' => '-- Classe comptable ind&eacute;termin&eacute;e',

# Meta utilisateurs
	'editer_meta_utilisateur' => '&Eacute;diter le champs utilisateur',
	'supprimer_meta_utilisateur' => 'Supprimer le champs utilisateur',
	'nom_meta_utilisateur' => 'Nom',
	'action_meta_utilisateur' => 'Action',
	'avertissement_suppression_meta_utilisateur' => 'Vous vous appr&ecirc;tez &agrave; supprimer le champs utilisateur',
	'editer_asso_metas_utilisateur_lien' => 'G&eacute;rer les champs suppl&eacute;mentaires du profil de l\'association',
	'ajouter_meta_utilisateur' => 'Cr&eacute;er un nouveau champs',
	'editer_asso_metas_utilisateur' => '&Eacute;dition des champs utilisateurs',
	'meta_utilisateur_note' => '<p>Note :</p><p>Cette page permet de cr&eacute;er ou d\'&eacute;diter(renommer/supprimer) des champs suppl&eacute;mentaires qui apparaissent dans le profil de votre association.</p><p>Une fois cr&eacute;&eacute;s les champs suppl&eacute;mentaires apparaissent dans la page de profil de l\'association o&ugrave; vous pourrez leur associer une valeur.</p>',
	'meta_utilisateur_limitation_note' => '<p>Notes :</p><p>Le nom d\'un champs est limit&eacute; aux caract&egrave;res alphanum&eacute;riques: A-Z a-z 0-9 et espaces, pas de caract&egrave;res accentu&eacute;s ni ponctuation.</p><p>Bien que conservant la casse dans leur affichage, la gestion du nom des champs y est insensible, vous ne pouvez donc pas cr&eacute;er deux champs identiques différenci&eacute;s par leur casse. Ex : "Nouveau Champs" et "nouveau champs" ne peuvent pas cohabiter.</p><p>Le nom de champ peut &ecirc;tre renseign&eacute; dans le fichier de langues <tt>local</tt> pour indiquer le texte accentu&eacute; ou traduit associ&eacute;.</p>',
	'erreur_nom_meta_utilisateur_incorrect' => 'Le nom d\'un champs est limit&eacute; aux caract&egrave;res alphanum&eacute;riques: A-Z a-z 0-9 et espaces, pas de caract&egrave;res accentu&eacute;s ni ponctuation.',
	'erreur_nom_meta_utilisateur_trop_long' => 'Le nom d\'un champs est limit&eacute; &agrave; 237 caract&egrave;res',
	'erreur_pas_de_nom_meta_utilisateur' => 'Le nom d\'un champs ne peut pas &ecirc;tre vide, si vous voulez supprimer un champs, utilisez le bouton supprimer sur la page listant tous les champs utilisateur.',
	'erreur_meta_utilisateur_deja_definie' => 'Ce champs utilisateur est d&eacute;j&agrave; d&eacute;fini.',

# Groupes
	'gerer_les_groupes' => 'G&eacute;rer les groupes',
	'gestion_groupes' => 'Gestion des groupes',
	'nom_groupe' => 'Nom du groupe',
	'ordre_affichage' => 'Ordre d\'affichage sur la page d\'accueil',
	'ajouter_un_groupe' => 'Ajouter un groupe',
	'suppression_de_groupe' => 'Suppression d\'un groupe',
	'tous_les_groupes' => 'Tous les groupes',
	'aucun_membre_dans_ce_groupe' => 'Aucun membre dans ce groupe',
	'editer_groupe' => 'Editer le groupe',
	'voir_groupe' => 'Voir le groupe',
	'supprimer_groupe' => 'Supprimer le groupe',
	'ajouter_membres_au_groupe' => 'Ajouter ces membres au groupe',
	'titre_editer_groupe' => 'Editer le groupe',
	'ajouter' => 'Ajouter',
	'exclure' => 'Exclure',
	'exclure_du_groupe' => 'Exclure du groupe',
	'supprimer_selectionnes' => 'Exclure les membres selectionn&eacute;s',
	'ok_edition_groupe' => 'Sauvegarder les modifications du champs Fonction',
	'ordre_affichage_groupe' => 'Ordre d\'affichage',
	'aide_groupes' => '<p><strong>Affichage d\'un groupe sur la page d\'accueil</strong></p><p>Pour afficher un groupe sur la page d\'accueil du plugin, par exemple le groupe "Bureau", il suffit de mettre un nombre entier diff&eacute;rent de z&eacute;ro dans le champs "Ordre d\'affichage".</p><p>Les groupes affich&eacute;s le sont par ordre croissant de cet index.</p>',
	'vous_vous_appretez_a_supprimer_le_groupe' => 'Vous vous appretez &agrave; supprimer le groupe ',
	'adherent_message_grouper' => '<p>S&eacute;lectionner les groupes que les adh&eacute;rents suivants vont rejoindre.</p>',
	'adherents_dp' => 'Adh&eacute;rents :',
	'groupes_dp' => 'Groupes :',
	'groupe_dp' => 'Groupe :',
	'rejoindre_un_groupe' => 'Rejoindre un ou plusieurs groupes',
	'quitter_un_groupe' => 'Quitter un groupe',
	'adherent_message_degrouper' => '<p>S&eacute;lectionner les groupes dont les adh&eacute;rents seront exclus.</p>',
	'titre_voir_groupe' => 'Voir le groupe',
# Association (accueil)
	'association_infos_contacts' => '  ', // information sur l'association (objet, declaration, etc.), ses coordonnees (adresse, numero et email principaux) et les contacts (nom, fonction, numero, email)
	'categories_de_cotisations' => 'Cat&eacute;gories de cotisations',
	'toutes_categories_de_cotisations' => 'Toutes les cat&eacute;gories de cotisations',
	'configuration' => 'Configuration',
	'gestion_association' => 'Gestion d\'une Association',
	'gestion_des_banques' => 'Gestion des banques',
	'gestion_de_lassoc' => 'Gestion de l\'association @nom@',
	'association_info_doc' => '<p>Ce plugin vous permet de g&eacute;rer une petite association en ligne.</p> <p>Vous pouvez ainsi  visualiser, ajouter et modifier des membres actifs, lancer des mails de masse pour les relances de cotisations, g&eacute;rer des dons, des ventes associatives, des inscriptions aux activit&eacute;s, des pr&ecirc;ts de mat&eacute;riels et autres ressources, et tenir un livre de comptes.</p>',
	'message' => 'Message',
	'sujet' => 'Sujet',
	'message_relance' => '
Bonjour,

Votre adh&eacute;sion est arriv&eacute;e &agrave; &eacute;ch&eacute;ance.
Si vous souhaitez continuer l\'aventure en notre compagnie, n\'oubliez pas de reconduire celle-ci.
Vous pouvez nous faire parvenir votre r&egrave;glement &agrave; votre convenance (ch&egrave;que, mandat  ou virement ).

Le bureau de l\'association.

Merci de ne pas r&eacute;pondre directement &agrave; ce message automatique
	',
	'message_adhesion_webmaster' =>'

	',
	'profil_de_lassociation' => 'Profil de l\'association',

# Adherents
 # Actions
	'selectionner_tout' => 'D&eacute;/S&eacute;lectionner tout',
	'choisir_action' => 'Pour la s&eacute;lection :',
	'desactiver_adherent' => 'D&eacute;sactiver',
	'reactiver_adherent' => 'R&eacute;activer',
	'supprimer_adherent' => 'Supprimer',
	'rejoindre_groupe' => 'Rejoindre un groupe',
 # Titres
	'adherent_titre_action_membres_actifs' => 'Action sur les membres actifs',
	'adherent_titre_modifier_membre' => 'Modifier un membre actif',
	'adherent_titre_ajout_adherent' => 'Ajout d\'adh&eacute;rent',
	'adherent_titre_ajouter_membre_actif' => 'Ajouter des membres actifs',
	'adherent_titre_ajouter_membre' => 'Ajouter un membre',
	'adherent_titre_historique_membre' => 'Historique membre',
	'adherent_titre_fiche_signaletique_id' => 'Fiche signal&eacute;tique #@id@',
	'adherent_titre_historique_cotisations' => 'Historique des cotisations',
	'adherent_titre_historique_activites' => 'Historique des activit&eacute;s',
	'adherent_titre_historique_ventes' => 'Historique des ventes',
	'adherent_titre_historique_dons' => 'Historique des dons',
	'adherent_titre_historique_prets' => 'Historique des pr&ecirc;ts',
	'adherent_titre_liste_actifs' => 'Tous les membres actifs',
	# Libelle
	'adherent_libelle_donnees_adherent' => 'Donn&eacute;es Adh&eacute;rent',
	'adherent_libelle_id_asso' => 'R&eacute;f. int.',
	'adherent_libelle_reference_interne' => 'R&eacute;f&eacute;rence interne',
	'adherent_libelle_numero' => 'Num&eacute;ro',
	'adherent_libelle_numero_auteur' => 'AUTEUR NUM&Eacute;RO',
	'adherent_libelle_numero_visiteur' => 'VISITEUR NUM&Eacute;RO',
	'adherent_libelle_id_auteur' => 'ID',
	'adherent_libelle_photo' => 'Photo',
	'adherent_libelle_nom_famille' => 'Nom',
	'adherent_libelle_prenom' => 'Pr&eacute;nom',
	'adherent_libelle_sexe' => 'Civilit&eacute;',
	'adherent_libelle_categorie' => 'Cat&eacute;gorie',
	'adherent_libelle_fonction' => 'Fonction',
	'adherent_libelle_validite' => 'Validit&eacute;',
	'adherent_libelle_date_validite' => 'Date limite de validit&eacute; (AAAA-MM-JJ)',
	'adherent_libelle_commentaires' => 'Remarques',
	'adherent_libelle_statut' => 'Statut de cotisation',
	'adherent_libelle_groupes' => 'Groupes',
	'adherent_libelle_statut_ok' => '&Agrave; jour',
	'adherent_libelle_statut_echu' => '&Eacute;chu',
	'adherent_libelle_statut_relance' => 'Relanc&eacute;',
	'adherent_libelle_statut_sorti' => 'D&eacute;sactiv&eacute;',
	'adherent_libelle_statut_prospect' => 'Prospect',
	'adherent_libelle_oui' => 'oui',
	'adherent_libelle_non' => 'non',
	'adherent_libelle_homme' => 'H',
	'adherent_libelle_femme' => 'F',
	'adherent_libelle_masculin' => 'Monsieur',
	'adherent_libelle_feminin' => 'Madame',
	# En-tetes
	'adherent_entete_livre' => 'Livre',
	'adherent_entete_paiement' => 'Paiement',
	'adherent_entete_justification' => 'Justification',
	'adherent_entete_journal' => 'Journal',
	'adherent_entete_activite' => 'Activit&eacute;',
	'adherent_entete_lieu' => 'Lieu',
	'adherent_entete_inscrits' => 'Inscrits',
	'adherent_entete_notes' => 'Notes',
	'adherent_entete_supprimer_abrev' => 'Sup.<br /><abbr title="Pour supprimer plusieurs adh&eacute;rents. Si des adh&eacute;rents sont coch&eacute;s pour &ecirc;tre d&eacute;sactiv&eacute;s, ils seront seulement d&eacute;sactiv&eacute;s !">???</abbr>',
	'adherent_entete_desactiver_abrev' => 'D&eacute;s.<br /><abbr title="Pour d&eacute;sactiver plusieurs adh&eacute;rents sans passer par leur &eacute;dition">???</abbr> ',

	'adherent_entete_statut_defaut' => 'Actifs',
	'adherent_entete_statut_ok' => '&Agrave; jour',
	'adherent_entete_statut_echu' => '&Eacute;chu',
	'adherent_entete_statut_relance' => 'Relanc&eacute;s',
	'adherent_entete_statut_sorti' => 'D&eacute;sactiv&eacute;s',
	'adherent_entete_statut_erreur_bank' => 'Paiement refus&eacute;',
	'adherent_entete_statut_prospect' => 'Prospects',
	# Categories
	'pas_de_categorie_attribuee' => 'Pas de cat&eacute;gorie attribu&eacute;e',
	'erreur_pas_de_categorie' => 'Aucune cat&eacute;gorie de cotisation d&eacute;finie',
	# Ref. Int.
	'pas_de_reference_interne_attribuee' => 'Pas de r&eacute;f&eacute;rence interne attribu&eacute;e',
	# Bouton
	'adherent_bouton_modifier_membre' => 'Modifier le membre',
	'adherent_bouton_maj_operation' => 'Mettre &agrave; jour l\'op&eacute;ration',
	'adherent_bouton_maj_inscription' => 'Mettre &agrave; jour l\'inscription',
	'parametres' => 'Param&egrave;tres',
	# Label
	'adherent_label_modifier_visiteur' => 'Modifier le visiteur',
	'adherent_label_modifier_auteur' => 'Modifier l\'auteur',
	'adherent_label_envoyer_courrier' => 'Envoyer un courrier',
	'adherent_label_ajouter_cotisation' => 'Ajouter une cotisation',
	'adherent_label_modifier_membre' => 'Modifier membre',
	'adherent_label_voir_membre' => 'Voir le membre',
	'adherent_label_page_du_membre' => 'Page du membre',
	'adherent_label_voir_operation' => 'Voir l\'op&eacute;ration comptable',
	'adherent_label_rejoindre_association' => 'Devenir membre de l\'association',
	# Message
	'suppression_des_adherents' => 'Suppression des adh&eacute;rents',
	'desactivation_des_adherents' => 'D&eacute;sactivation des adh&eacute;rents',
	'activation_des_adherents' => 'Activation des adh&eacute;rents',
	'adherent_message_ajout_adherent' => '@prenom@ @nom@ a &eacute;t&eacute; ajout&eacute; dans le fichier',
	'adherent_message_ajout_adherent_suite' => 'et enregistr&eacute; comme visiteur',
	'adherent_message_email_invalide' => 'L\'email n\'est pas valide !',
	'adherent_message_maj_adherent' => 'Les donn&eacute;es de @prenom@ @nom@ ont &eacute;t&eacute; mises &agrave; jour !',
	'adherent_message_confirmer_suppression' => 'Vous vous appr&ecirc;tez &agrave; effacer les membres',
	'adherent_message_confirmer_desactivation' => 'Vous vous appr&ecirc;tez &agrave; d&eacute;sactiver les membres',
	'adherent_message_confirmer_activation' => 'Vous vous appr&ecirc;tez &agrave; r&eacute;activer les membres',
	'adherent_message_suppression_faite' => 'Suppression effectu&eacute;e !',
	'adherent_message_desactivation_faite' => 'D&eacute;sactivation effectu&eacute;e !',
	'adherent_message_activation_faite' => 'R&eacute;activation effectu&eacute;e !',
	'adherent_message_detail_suppression' => 'Les adh&eacute;rents supprim&eacute;s le sont uniquement de la liste des membres de l\'association. Si vous souhaitez supprimer aussi l\'auteur spip, il faut passer par la page de gestion des auteurs.',
	'adherent_message_detail_desactivation' => 'Les adh&eacute;rents d&eacute;sactiv&eacute;s ne sont pas supprim&eacute;s. Il suffit de faire afficher les adh&eacute;rents désactiv&eacute;s pour les r&eacute;-activ&eacute;s &agrave; nouveau.',
	'adherent_message_detail_activation' => 'Les adh&eacute;rents seront r&eacute;activ&eacute;s avec le statut \'prospect\'',
	# Liste
	'adherent_liste_nombres' => 'Nombre de membres',
	'adherent_liste_nombre_ok' => 'A jour : ',
	'adherent_liste_nombre_echu' => 'Echus : ',
	'adherent_liste_nombre_relance' => 'Relanc&eacute;s : ',
	'adherent_liste_nombre_prospect' => 'Prospects : ',
	# synchro adherents/auteurs
	'synchroniser_asso_membres' => 'Synchroniser la listes des membres avec les auteurs SPIP',
	'synchroniser_choix' => 'Cocher le statut des auteurs SPIP a importer dans la liste des membres, vous pouvez cocher plusieurs cases.',
	'synchroniser_note' => 'Notes:<p> Les auteurs jamais connect&eacute;s seront aussi import&eacute;s dans la liste des membres de l\'association(en fonction de la s&eacute;l&eacute;ction que vous faites).</p><p>Si trop d\'auteurs sont import&eacute;s, vous pourrez toujours les supprimer de la liste des membres, cela n\'a aucune incidence sur leur statut d\'auteur SPIP.</p><p>m&ecirc;me si vous cochez "Tous les auteurs", les auteurs &agrave; la poubelle ne seront pas import&eacute;s comme membres.</p>Par d&eacute;faut, seul les auteurs non pr&eacute;sents dans la liste des membres sont import&eacute;s. La derni&egrave;re case vous permet de forcer l\'insertion de tous les auteurs dans la liste des membres. Cela ne modifiera toutefois pas le statut des membres d&eacute;j&agrave; pr&eacute;sents mais permet de repartir du bon pied quand on activ&eacute;/desactiv&eacute; le plugin tout en modifiant les auteurs SPIP.',
	'synchroniser_tous' => 'Tous les auteurs',
	'synchroniser_visiteurs' => 'Les visiteurs',
	'synchroniser_redacteurs' => 'Les r&eacute;dacteurs',
	'synchroniser_administrateurs' => 'Les administrateurs',
	'synchroniser_forcer' => 'Forcer l\'insertion des auteurs d&eacute;j&agrave; pr&eacute;sents comme membres',
	'pas_de_categorie' => 'Ne pas renseigner ce champ',
	'synchronise_asso_membre_lien' => 'Synchroniser la liste des membres depuis la liste des auteurs',
	'membres_ajoutes' => ' membres ins&eacute;r&eacute;s dans la liste des membres',
	'membre_ajoute' => ' membre ins&eacute;r&eacute; dans la liste des membres',
	# relances
	'emails_envoyes' => ' emails envoy&eacute;s',
	'email_envoye' => ' email envoy&eacute;',
	'echec' => '&eacute;chec',
	'echecs' => '&eacute;checs',
	'aucune_adresse_trouvee_pour_les_membres' => 'Aucune adresse trouv&eacute;e pour les membres : ',
	'ecrire_a' => '&Eacute;crire &agrave;',
	'a' => '&agrave',
	# cotisation
	'gestion_cotisations_limitee' => 'La gestion comptable &eacute;tant desactiv&eacute;e, seule la date de validit&eacute; est prise en charge par la gestion des cotisations.',

# ACTIVITES
	# Titres
	'activite_titre_action_sur_inscriptions' => 'Action sur les inscriptions',
	'activite_titre_mise_a_jour_inscriptions' => 'Mise &agrave; jour des inscriptions',
	'activite_titre_ajouter_inscriptions' => 'Ajouter des inscriptions',
	'activite_titre_toutes_activites' => 'Toutes les activit&eacute;s',
	'activite_titre_inscriptions_activites' => 'Inscriptions aux activit&eacute;s',
	# Sous-titres
	'activite_mise_a_jour_inscription' => 'Mettre &agrave; jour une inscription',
	'activite_ajouter_inscription' => 'Ajouter une inscription',
	# Libelle
	'activite_libelle_inscription' => 'Inscription n&deg;',
	'activite_libelle_nomcomplet' => 'Nom complet',
	'activite_libelle_invitation' => ' -- Invitation ext&eacute;rieure -- ',
	'activite_libelle_accompagne_de' => 'Je serai accompagn&eacute; de',
	'activite_libelle_membres' => 'Noms des participants membres',
	'activite_libelle_non_membres' => 'Noms des participants non membres',
	'activite_libelle_nombre_inscrit' => 'Nombre total d\'inscrits',
	'activite_libelle_montant_inscription' => 'Montant de l\'inscription (en &euro;)',
	'activite_libelle_date_paiement' => 'Date de paiement (AAAA-MM-JJ)',
	'activite_libelle_mode_paiement' => 'Mode de paiement',
	# En-tete
	'activite_entete_heure' => 'Heure',
	'activite_entete_intitule' => 'Intitul&eacute;',
	'activite_entete_lieu' => 'Lieu',
	'activite_entete_toutes' => 'Toutes',
	'activite_entete_validees' => 'Valid&eacute;es',
	'activite_entete_adherent' => 'Adh&eacute;rent',
	'activite_entete_inscrits' => 'Nbre',
	# Bouton
	'activite_bouton_modifier_article' => 'Modifier l\'article',
	'activite_bouton_ajouter_inscription' => 'Ajouter une inscription',
	'activite_bouton_voir_liste_inscriptions' => 'Voir la liste des inscriptions',
	'activite_bouton_maj_inscription' => 'Mettre &agrave; jour l\'inscription',
	# Liste
	'activite_liste_legende' => 'En bleu : Inscription non valid&eacute;e <br /> En vert : Inscription valid&eacute;e',
	'activite_liste_nombre_inscrits' => 'Nombre d\'inscrits : @total@',
	'activite_liste_total_participations' => 'Total des participations : @total@ &euro;',
	# Message
	'activite_justification_compte_inscription' => 'Inscription n&deg; @id_activite@ - @nom@',
	'activite_message_ajout_inscription' => 'L\'inscription de @nom@ a &eacute;t&eacute; enregistr&eacute;e pour un montant de @montant@ &euro;',
	'activite_message_maj_inscription' => 'L\'inscription de @nom@ a &eacute;t&eacute; mise &agrave; jour',
	'activite_message_confirmation_supprimer' => 'Vous vous appr&ecirc;tez &agrave; effacer @nombre@ inscription@pluriel@ !',
	'activite_message_suppression' => 'Suppression effectu&eacute;e !',
	'activite_message_sujet' => 'Inscription activit&eacute;',
	'activite_message_confirmation_inscription'=>'
Bonjour,

Nous venons d\'enregistrer pour vous l\'inscription suivante:

Activit&eacute;: @activite@
Date: @date@
Lieu: @lieu@

De: @nom@
Accompagn&eacute; de
	Membres: @membres@
	Non-membres: @non_membres@
Nombre total d\'inscrits: @inscrits@

Cette inscription ne sera d&eacute;finitive qu\'apr&egrave;s v&eacute;rification et dans la mesure o&ugrave;, sauf stipulation contraire, le montant de @montant@ euros nous est parvenu.

Dans cette attente et dans l\'attente de vous retrouver, nous vous adressons nos salutations les meilleures.

L\'&eacute;quipe @nomasso@
	',
	'activite_message_webmaster'=>'
De: @nom@
Activit&eacute;: @activite@
Nombre: @inscrits@
Commentaire: @commentaire@
	',

# VENTES
	#Entetes
	'vente_entete_article' => 'Article',
	'vente_entete_quantites' => 'Quantit&eacute;',
	'vente_entete_date_envoi' => 'Date d\'envoi',
	'dons_titre_mise_a_jour' => 'Mise &agrave; jour des dons',
	'adherent_bouton_maj_vente' => 'Editer la vente',

# RESSOURCES
	#Messages
	'ressources_info' => 'Vous pouvez g&eacute;rer ici les diff&eacute;rentes ressources pr&ecirc;t&eacute;es aux membres (livres, mat&eacute;riels, ...)<br />La puce indique la disponibilit&eacute; des diff&eacute;rentes ressources',
	'ressources_danger_suppression' => 'Vous vous appr&ecirc;tez &agrave; effacer l\'article n&deg; @id_ressource@ !',
	# Titres
	'ressources_titre_gestion_ressources' => 'Gestion des ressources',
	'ressources_titre_edition_ressources' => 'Edition de ressource',
	'ressources_titre_suppression_ressources' => 'Suppression de ressource',
	'ressources_titre_liste_ressources' => 'Liste des ressources',
	'ressources_titre_mise_a_jour' => 'Mise &agrave; jour des ventes',
	# En-tete
	'ressources_entete_intitule' => 'Article',
	'ressources_entete_code' => 'Code',
	# Navigation
	'ressources_nav_gestion_' => 'Gestion des ressources',
	'ressources_nav_ajouter' => 'Ajouter une ressource',
	'ressources_nav_supprimer' => 'Supprimer la ressource',
	'ressources_nav_editer' => 'Editer la ressource',
	# Libelle
	'ressources_num' => 'RESSOURCE N&deg;',
	'ressources_libelle_code' => 'Code',
	'ressources_libelle_intitule' => 'Article',
	'ressources_libelle_date_acquisition' => 'Date d\'acquisition (AAAA-MM-JJ)',
	'ressources_libelle_prix_location' => 'Prix de la location (en euros)',
	'ressources_libelle_statut' => 'Statut',
	'ressources_libelle_statut_ok' => 'Libre',
	'ressources_libelle_statut_reserve' => 'R&eacute;serv&eacute;',
	'ressources_libelle_statut_suspendu' => 'En suspend',
	'ressources_libelle_statut_sorti' => 'D&eacute;saffect&eacute;',
	'ressources_libelle_commentaires' => 'Commentaires',

# Prêts
	#Messages
	'prets_danger_suppression' => 'Vous vous appr&ecirc;tez &agrave; effacer la r&eacute;servation n&deg; @id_pret@ !',
	# Titres
	'prets_titre_gestion_prets' => 'Gestion des r&eacute;servations',
	'prets_titre_edition_prets' => 'Edition de r&eacute;servation',
	'prets_titre_suppression_prets' => 'Suppression de r&eacute;servation',
	'prets_titre_liste_reservations' => 'Liste des r&eacute;servations',
	# En-tete
	'prets_entete_date_sortie' => 'Date sortie',
	'prets_entete_nom' => 'Nom',
	'prets_entete_duree' => 'Dur&eacute;e',
	'prets_entete_date_retour' => 'Date retour',
	'prets_entete_reservation' => 'R&eacute;servation',
	'prets_entete_retour' => 'Restitution',
	# Navigation
	'prets_nav_gerer' => 'G&eacute;rer les r&eacute;servations',
	'prets_nav_ajouter' => 'Ajouter une r&eacute;servation',
	'prets_nav_annuler' => 'Annuler la r&eacute;servation',
	'prets_nav_editer' => 'Editer la r&eacute;servation',
	# Libelle
	'prets_libelle_date_sortie' => 'Date de sortie',
	'prets_libelle_duree' => 'Dur&eacute;e',
	'prets_libelle_num_emprunteur' => 'N&deg; de l\'emprunteur',
	'prets_libelle_commentaires' => 'Commentaires',
	'prets_libelle_date_retour' => 'Date de retour',
	'prets_libelle_mode_paiement' => 'Mode de paiement',

# Exercices Budgetaires
	'exercices_budgetaires_titre' => 'Exercices Budg&eacute;taires',
	'exercice_budgetaire_titre' => 'Exercice Budg&eacute;taire',
	'ajouter_un_exercice' => 'Ajouter un exercice',
	'tous_les_exercices' => 'Tous les exercices',
	'exercice_intitule' => 'Intitul&eacute;',
	'exercice_commentaire' => 'Commentaire',
	'exercice_debut' => 'Date d&eacute;but',
	'exercice_fin' => 'Date fin',
	'exercice_debut_aaaa' => 'Date d&eacute;but (AAAA-MM-JJ)',
	'exercice_fin_aaaa' => 'Date fin (AAAA-MM-JJ)',
	'exercice_budgetaire_edition_titre' => 'Edition exercice budg&eacute;taire',
	'exercice_budgetaire_supprime' => 'Suppression exercice budg&eacute;taire',
	'vous_vous_appretez_a_effacer_exercice_budgetaire' => 'Vous vous appr&ecirc;tez &agrave; effacer l\'exercice budg&eacute;taire',

# Plan comptable
	#Message
	'plan_info' => 'Vous pouvez d&eacute;finir ici les comptes de votre plan comptable.<br />Vous devez au minimum d&eacute;finir les comptes de produits n&eacute;cessaires &agrave; la configuration du plugin et les comptes financiers relatifs aux diff&eacute;rentes modes de paiement.',
    'edit_plan' => '<p>Vous devez choisir d\'abord une "CLASSE" puis un "CODE" dont le 1er chiffre doit correspondre &agrave; la "classe". Par exemple : classe 5 et code 5171</p>Si vous avez activ&eacute; l\'aide &agrave; la d&eacute;claration du plan comptable fran&ccedil;ais, un s&eacute;lecteur de code listant tous les codes et intitul&eacute;s correspondant vous permettra de remplir directement les cases code et intitul&eacute; que vous pourrez modifier ensuite, ce sont elles qui seront consid&eacute;r&eacute;es et non le s&eacute;lecteur.',
	'non_implemente' => 'Fonctionnalit&eacute; non encore impl&eacute;ment&eacute;e !',
	# Titres
	'plan_comptable' => 'Plan comptable',
	# En-tete
	'plan_entete_tous' => 'Tous',
	# Navigation
	'plan_nav_ajouter' => 'Ajouter une r&eacute;f&eacute;rence comptable',
	'operations_comptables' => 'Op&eacute;rations comptables',
	'liens_vers_les_justificatifs' => 'Liens vers les justificatifs',
	'destination_nav_ajouter' => 'Ajouter une destination comptable',
	#Libelle
	'plan_libelle_comptes_actifs' => 'Comptes actifs',
	'plan_libelle_comptes_desactives' => 'Comptes d&eacute;sactiv&eacute;s',
	'plan_libelle_oui' => 'oui',
	'plan_libelle_non' => 'non',
	'direction_plan' => 'Type d\'op&eacute;rations',
# Destination comptable
	'ajouter_destination' => 'ajouter une destination',
	'supprimer_destination' => 'supprimer',
	'destination_entete_utilise' => 'Utilis&eacute;',
	# Titres
	'destination_comptable' => 'Destination comptable',
# Bilan
	'toutes_destination' => 'toutes destinations',
	'bilan_depenses' => 'D&eacute;penses',
	'bilan_recettes' => 'Recettes',
	'bilan_solde' => 'Solde',
# Comptes
	# Libelles
	'compte_financier' => 'Compte financier',
	'bilan' => 'Bilan',
	'compte_cree_automatiquement' => 'Compte cr&eacute;&eacute; automatiquement par Associaspip',
	'virement_interne' => 'Virement interne',
	'bouton_radio_type_operation_titre' => 'Type d\'op&eacute;ration',
	'compte_origine' => 'Compte Origine',
	'compte_destination' => 'Compte Destination',
	'depense' => 'D&eacute;pense',
	'depense_evaluee' => 'D&eacute;pense &eacute;valu&eacute;e',
	'recette' => 'Recette',
	'recette_evaluee' => 'Recette &eacute;valu&eacute;e',
	'compte_debite' => 'Compte d&eacute;bit&eacute;',
	'compte_credite' => 'Compte cr&eacute;dit&eacute;',
	'aucun' => 'aucun',
	'tous' => 'tous',
	'aucun_achat_pour_l_instant' => 'Aucun achat pour l\'instant',
	'aucun_don_pour_l_instant' => 'Aucun achat don l\'instant',
	'aucun_pret_payant_pour_l_instant' => 'Aucun pr&ecirc;t payant pour l\'instant',
	'aucune_activite_payante_pour_l_instant' => 'Aucun activit&eacute; payante pour l\'instant',
	'aucune_cotisation_pour_l_instant' => 'Aucune cotisation pour l\'instant',
	'totaux' => 'Totaux',
	# Entetes
	'compte_entete_imputation' => 'Cpte. Imputation',
	'compte_entete_financier' => 'Cpte. Financier',
	'compte_entete_justification' => 'Justification',
	# Listes
	'compte_liste_nombres' => 'Nombre d\'op&eacute;rations',
	'compte_liste_nombre_pair' => 'Produits : ',
	'compte_liste_nombre_impair' => 'Charges : ',
	'compte_liste_nombre_cv' => 'Contrib. volontaires : ',
	'compte_liste_nombre_vi' => 'Virements internes : ',
# Compte de Resultat
	'cpte_resultat_titre_general' => 'Compte de R&eacute;sultat',
	'cpte_resultat_bouton_voir' => 'Voir',
	'cpte_resultat_titre_charges' => 'CHARGES',
	'cpte_resultat_titre_produits' => 'PRODUITS',
	'cpte_resultat_titre_benevolat' => 'CONTRIBUTIONS VOLONTAIRES',
	'cpte_resultat_titre_resultat' => 'R&Eacute;SULTAT',
	'cpte_resultat_total_charges' => 'Total des Charges',
	'cpte_resultat_total_produits' => 'Total des Produits',
	'cpte_resultat_perte' => 'Perte',
	'cpte_resultat_benefice' => 'B&eacute;n&eacute;fice',
	'cpte_resultat_recette_evaluee' => 'Recette<br />&eacute;valu&eacute;e',
	'cpte_resultat_depense_evaluee' => 'D&eacute;pense<br />&eacute;valu&eacute;e',
	'cpte_resultat_mode_exportation' => 'Exporter le Compte de R&eacute;sultat en ',
	'cpte_resultat_pied_page_export_pdf' => 'Associaspip - Gestion d\'une association sous licence GPL',
	'cpte_resultat_total_produits_evalues' => 'Total des Produits &Eacute;valu&eacute;s',
	'cpte_resultat_total_charges_evaluees' => 'Total des Charges &Eacute;valu&eacute;es',
	# annexe
	'annexe_titre_general' => 'Annexe',
	# Verifications
	'erreur_titre' => 'Une erreur est pr&eacute;sente dans votre saisie',
	'erreur_recette_depense' => 'Une op&eacute;ration ne peut contenir simultan&eacute;ment des d&eacute;penses et recettes. Par ailleurs les d&eacute;penses ou recettes ne peuvent pas &ecirc;tre n&eacute;gatives ou toutes les deux nulles',
	'erreur_montant_destination' => 'La somme des montants affect&eacute;s aux diff&eacute;rentes destinations ne correspond pas au montant global de l\'op&eacute;ration',
	'erreur_destination_dupliquee' => 'Une m&ecirc;me destination a &eacute;t&eacute; s&eacute;lectionn&eacute;e plusieurs fois',
	'erreur_configurer_association_titre' => 'Votre saisie contient des erreurs !',
	'erreur_configurer_association_reference_multiple' => 'Une m&ecirc;me r&eacute;f&eacute;rence comptable ne doit pas &ecirc;tre utilis&eacute;e pour plusieurs fonctions activ&eacute;es(ventes, dons, prets, activit&eacute;s) ou cotisations',
	'erreur_configurer_association_classe_identique' => 'Une m&ecirc;me classe ne doit pas &ecirc;tre utilis&eacute;e pour plusieurs fonctions !',
	'erreur_configurer_association_gestion_comptable_non_activee' => 'Il n\'est pas possible d\'activer un module(gestion des prets, ventes, dons ou activit&eacute;s) si la gestion comptable n\'est pas activ&eacute;e.',
	'erreur_configurer_association_nom_association_vide' => 'Le nom de l\'association ne doit pas &ecirc;tre vide !',
	'erreur_id_adherent' => 'Ce num&eacute;ro de membre ne correspond &agrave; aucun membre de l\'association',
	'erreur_pas_de_classe_financiere' => 'Aucune classe de comptes financiers d&eacute;finie au plan comptable !',
	'erreur_creer_un_plan_pour_activer_ce_module' => 'Vous devez d&eacute;finir un plan comptable pour pouvoir activer ce module.',
	'erreur_creer_un_plan_et_activer_gestion_comptable_pour_activer_ce_module' => 'Vous devez d&eacute;finir un plan comptable et activer le module de gestion comptable pour pouvoir activer ce module.',
	'erreur_pas_de_compte' => 'Pas de r&eacute;f&eacute;rence comptable active d&eacute;finie !',
	'erreur_pas_de_destination' => 'Pas de destination comptable d&eacute;finie !',
	'erreur_gestion_comptable_inactive' => 'Afin de pouvoir g&eacute;rer les cotisations, dons et ventes, la gestion comptable doit &ecirc;tre activ&eacute;e',
	'erreur_plan_classe' => 'La classe d\'un compte doit &ecirc;tre un entier entre 0 et 9',
	'erreur_plan_code' => 'Le code d\'un compte est compos&eacute; de caract&egrave;res alphanum&eacute;riques uniquement et doit commencer par 2 chiffres. Le premier chiffre doit &ecirc;tre &eacute;gal &agrave; la classe du compte',
	'erreur_plan_code_duplique' => 'Ce code est d&eacute;j&agrave; utilis&eacute; pour une autre r&eacute;f&eacute;rence comptable(peut-&ecirc;tre d&eacute;sactiv&eacute;e)',
	'erreur_plan_code_modifie_utilise_classe_financiere' => 'Cette r&eacute;f&eacute;rence comptable est utilis&eacute;e par un module de gestion (ventes/dons/prets/activit&eacute;s) activ&eacute; ou pour la gestion des cotisations. Vous ne pouvez donc pas modifier le code/la classe pour lui attribuer la classe des comptes financiers.',
	'erreur_plan_changement_classe_impossible' => 'Vous ne pouvez pas modifier la classe de ce compte pour la changer vers ou depuis la classe d&eacute;finie comme &eacute;tant celle des comptes financiers car des op&eacute;rations sur ce compte existent dans le livre de comptes.',
	'erreur_format_date' => 'La date doit &ecirc;tre au format AAAA-MM-JJ ; ce qui n\'est pas le cas de&nbsp;: @date@',
	'erreur_valeur_date' =>  'Cette date n\'existe pas&nbsp;: @date@',
	'erreur_operation_non_permise_sur_ce_compte' => 'Ce compte n\'accepte qu\'un seul type d\'op&eacute;rations (recette ou d&eacute;pense) et ne correspond pas a celle que vous avez rentr&eacute;',
	'erreur_montant' => 'Les valeurs n&eacute;gatives ne sont pas autoris&eacute;es',
	'erreur_configurer_association_plan_comptable_non_valide' => 'Vous ne pouvez pas activer le module de gestion comptable car votre plan comptable n\'est pas valide.<br/>Pour &ecirc;tre valide, un plan comptable doit suivre les r&egrave;gles suivantes :<ul><li>Contenir des comptes d\'au moins deux classes diff&eacute;rentes.<li><li>Les classes sont un chiffre entre 0 et 9.</li><li>Les codes des comptes doivent &ecirc;tre unique.</li><li>Les codes doivent commencer par un chiffre &eacute;gal &agrave; la classe du compte.</li><li>Les codes sont au format : 2 chiffres suivis de caract&egrave;res alphanum&eacute;riques</li></ul>',
	'erreur_configurer_association_reference_financier' => 'La r&eacute;f&eacute;rence comptable associ&eacute;e a un type d\'op&eacute;ration ne peut pas &ecirc;tre de la classe des comptes financiers',
# MaJ
	# MaJ integration de coodonnees
	'effectuer_la_maj' => 'Effectuer la mise &agrave; jour maintenant',
	'maj_coordonnees_notes' => 'Notes&nbsp;:<ul><li>Si vous choissisez de ne pas effectuer la mise &agrave; jour, ce choix vous sera propos&eacute; &agrave; chaque chargement de la page de gestion des plugins.</li><li>Ne pas tenir compte du message Echec au bas de ce cadre.</li><li>Vous pouvez ignorer ce message et g&eacute;rer les autres plugins normalement, la mise &agrave; jour ne sera alors pas effectu&eacute;e(et ce message continuera donc &agrave; apparaitre).</li><li>Le champ email de la table spip_asso_membres est normalement vide - cette information &eacute;tant contenue dans la table spip_auteurs - il sera &eacute;limin&eacute; sans sauvegarde.</li>',
	'maj_coordonnees_intro' => 'Vous vous appretez &agrave; effectuer une mise &agrave; jour du plugin Association basculant la gestion des adresses et t&eacute;l&eacute;phones vers le plugin Coordonn&eacute;es. A l\'issu de cette M&agrave;j, les champs correspondants &agrave; ces donn&eacute;es seront supprim&eacute;s des tables du plugin Association.<br/><strong>Ca pourrait &ecirc;tre une bonne id&eacute;e de faire une sauvegarde de votre base de donn&eacute;es avant de continuer (au minimum des tables spip_asso_membres ainsi que spip_adresses, spip_adresses_liens, spip_numeros et spip_numeros_liens si elles sont pr&eacute;sentes)</strong>',
	'maj_coordonnees_plugin_inactif' => 'Le plugin Coordonn&eacute;es n\'est pas actif sur votre installation, les donn&eacute;es d\'adresses et t&eacute;l&eacute;phones pr&eacute;sentes dans les tables du plugin Association seront perdues si vous effectuez la mise &agrave; jour maintenant. Pour les conserver, veuillez installer et activer le plugin Coordonn&eacute;es, en version 1.4.5 au minimum.',
	'maj_coordonnees_ignorer' => 'Ignorer les donn&eacute;es contenues dans les tables du plugin Association',
	'maj_coordonnees_merge' => 'Combiner les donn&eacute;es d\'Association et Coordonn&eacute;es. Les donn&eacute;es pr&eacute;sentes dans Association sont ajout&eacute;es aux tables de Coordonn&eacute;es(ce qui peut provoquer des doublons ! )',
	'maj_coordonnees_adresses_inserees' => ' adresse(s) ins&eacute;r&eacute;e(s) dans la base de Coordonn&eacute;es.',
	'maj_coordonnees_numeros_inseres' => ' num&eacute;ro(s) ins&eacute;r&eacute;(s) dans la base de Coordonn&eacute;es.',
	# MaJ activation des modules seulement si la gestion comptable est active
	'maj_desactive_gestion_comptable' => 'Gestion d\'association: &agrave; partir de cette mise &agrave; jour, il n\'est plus possible d\'activer la gestion comptable si le plan comptable n\'est pas valide. Votre plan comptable n\'est pas valide, la gestion comptable a donc &eacute;t&eacute; desactiv&eacute;e. Pour la reactiver, rendez vous sur la d\'&eacute;dition du plan comptable puis celle de configuration du plugin',
	'maj_desactive_modules' => 'Gestion d\'association : &agrave; partir de cette mise &agrave; jour, il n\'est plus possible d\'activer les modules de gestion de dons, ventes, prets ou activit&eacute;s si la gestion comptable n\'est pas activ&eacute;e. Votre configuration actuelle du plugin n\'&eacute;tant plus autoris&eacute;e, les modules de gestions activ&eacute;s ont &eacute;t&eacute; d&eacute;sactiv&eacute;s(aucune donn&eacute; n\'a  &eacute;t&eacute; &eacute;ffac&eacute;e). Rendez vous sur la page de configuration du plugin pour les r&eacute;activer.',
	# MaJ Generation des etiquette
	'eti_avec_civilite' => 'Avec la civilit&eacute;',
	'eti_nb_colonne' => 'Nb &eacute;tiquettes en largeur',
	'eti_nb_ligne' => 'Nb &eacute;tiquettes en hauteur',
	'eti_largeur_page' => 'largeur page',
	'eti_hauteur_page' => 'Hauteur page',
	'eti_marge_haut_page' => 'Marge haut de page',
	'eti_marge_bas_page' => 'Marge bas de page',
	'eti_marge_gauche_page' => 'marge gauche de page',
	'eti_marge_droite_page' => 'Marge droite de page',
	'eti_marge_haut_etiquette' => 'Marge haut &eacute;tiquette',
	'eti_marge_gauche_etiquette' => 'Marge gauche &eacute;tiquette',
	'eti_marge_droite_etiquette' => 'Marge droite &eacute;tiquette',
	'eti_espace_etiquettesl' => 'Espace entre &eacute;tiquettes largeur',
	'eti_espace_etiquettesh' => 'Espace entre &eacute;tiquettes hauteur',
	'etiquette_aucun_choix' => 'Aucun statut interne s&eacute;lectionn&eacute;',
	'info_doc_etiquette'=>'Cette page permet le param&eacute;trage du g&eacute;n&eacute;rateur d\'&eacute;tiquettes, il permet ainsi de renseigner le g&eacute;n&eacute;rateur sur le format du papier sur lequel seront imprim&eacute;es les &eacute;tiquettes, la taille des &eacute;tiquettes ...',
	'disposition_des_etiquettes' => 'Espace entre &eacute;tiquettes hauteur',
	'contenu_des_etiquettes' => 'Contenu des &eacute;tiquettes',
	'parametrage_des_etiquettes' => 'Param&eacute;trage des &eacute;tiquettes',
	'enregistrer' => 'Enregistrer',
	'imprimer' => 'Imprimer',
	'info_etiquette'=>'Imprimer les &eacute;tiquettes de vos cartes de membres, de vos courriers papiers...',
	'etiquettes'=>'&Eacute;tiquettes',
	'titre_page_config_etiquette'=>'Param&eacute;trage des &eacute;tiquettes',
	'membre_sans_email'=>'Uniquement les menbres sans email',
	'format_des_pages' => 'Format des pages',
	'marges_des_etiquettes' => 'Marge des &eacute;tiquettes',
# Categories
	# Categories : entetes
	'categorie_entete_valeur' => 'Cat&eacute;gorie',
	'categorie_entete_libelle' => 'Liblell&eacute; complet',
	# Categories : liblelles
	# Categories : messages
	# Categories : titres
	'ajouter_une_categorie_de_cotisation' => 'Ajouter une cat&eacute;gorie de cotisation',


// chaines collectee automatiquement

'a_developper' => 'A d&eacute;velopper',
'acheteur' => 'Acheteur',
'action_sur_les_dons' => 'Action sur les dons',
'action' => 'Action',
'activite_nd' => 'Activit&eacute; n&deg;',
'adresse' => 'Adresse',
'ajouter_une_operation' => 'Ajouter une op&eacute;ration',
'apres_confirmation_vous_ne_pourrez_plus_modifier_ces_operations' => 'Apr&egrave;s confirmation vous ne pourrez plus modifier ces op&eacute;rations.',
'argent' => 'Argent',
'article' => 'Article',
'avoir_actuel' => 'Avoir actuel',
'avoir_initial' => 'Avoir initial',
'categorie' => 'Cat&eacute;gorie',
'classe' => 'Classe',
'code' => 'Code',
'code_de_l_article' => 'Code de l\'article',
'colis' => 'Colis',
'commentaires' => 'Commentaires',
'compte_active' => 'Compte activ&eacute;',
'compte' => 'Compte',
'contre_valeur_en_e__' => 'Contre-valeur (en &euro;)',
'geste_association' => 'Geste de l\'association',
'contrepartie' => 'Contrepartie',
'crediteur' => 'Compte cr&eacute;diteur',
'debiteur' => 'Compte d&eacute;biteur',
'destination' => "Destinations",
'date_aaaa_mm_jj' => 'Date (AAAA-MM-JJ)',
'date_report_aaaa_mm_jj' => 'Date report (AAAA-MM-JJ)',
'date_du_paiement_aaaa_mm_jj' => 'Date du paiement (AAAA-MM-JJ)',
'don' => 'Don',
'don_financier_en_e__' => 'Don financier (en &euro;)',
'duree_en_mois' => 'Dur&eacute;e (en mois)',
'duree_mois' => 'Dur&eacute;e (mois)',
'email' => 'Email',
'en_rose_vente_enregistree_en_bleu_vente_expediee' => 'En rose : Vente enregistr&eacute;e<br />En bleu : Vente exp&eacute;di&eacute;e',
'encaisse' => 'Encaisse',
'entrees' => 'Entr&eacute;es',
'env' => 'Env',
'envoi' => 'Envoi',
'envoye_le_aaaa_mm_jj' => 'Envoy&eacute; le (AAAA-MM-JJ)',
'fonction' => 'Fonction',
'frais_d_envoi_en_e__' => 'Frais d\'envoi (en &euro;)',
'gestion_des_emprunts_et_des_prets' => 'Gestion des emprunts et des pr&ecirc;ts',
'gestion_pour_association' => 'Gestion pour Association',
'descriptif' => 'Descriptif',
'libelle_complet' => 'Libell&eacute; complet',
'membre' => 'Membre',
'membres' => 'Membres',
'mettre_a_jour_la_vente' => 'Mettre &agrave; jour la vente',
'mettre_a_jour_le_don' => 'Mettre &agrave; jour le don',
'mettre_a_jour' => 'Mettre &agrave; jour',
'nd_d_adherent' => 'N&deg; d\'adh&eacute;rent',
'nd_de_membre' => 'N&deg; de membre',
'pret_nd' => 'Pr&ecirc;t n&deg;',
'prix_de_vente_en_e__' => 'Prix de vente(en &euro;)',
'qte' => 'Qt&eacute;',
'quantite_achetee' => 'Quantit&eacute; achet&eacute;e',
'reference' => 'R&eacute;f&eacute;rence',
'reserve' => 'R&eacute;s&eacute;rv&eacute;',
'resultat_courant' => 'R&eacute;sultat courant',
'remarques' => 'Remarques',
'solde_initial' => 'Solde initial',
'solde_reporte_en_euros' => 'Solde report&eacute; (en euros)',
'sorties' => 'Sorties',
'supprimer_le_don' => 'Supprimer le don',
'tous_les_membres_a_relancer' => 'Tous les membres &agrave; relancer',
'toutes_les_etiquettes_a_generer' => 'Toutes les &eacute;tiquettes &agrave; g&eacute;n&eacute;rer',
'valeur' => 'Valeur',
'validite' => 'Validit&eacute;',
'vous_vous_appretez_a_effacer_la_ligne_de_compte' => 'Vous vous appr&ecirc;tez &agrave; effacer la ligne de compte',
'vous_vous_appretez_a_effacer_la_categorie' => 'Vous vous appr&ecirc;tez &agrave; effacer la cat&eacute;gorie',
'vous_vous_appretez_a_effacer_le_compte' => 'Vous vous appr&ecirc;tez &agrave; effacer le compte',
'vous_vous_appretez_a_effacer_la_destination' => 'Vous vous appr&ecirc;tez &agrave; effacer la destination',
'vous_vous_appretez_a_effacer_le_don' => 'Vous vous appr&ecirc;tez &agrave; effacer le don',
'vous_vous_appretez_a_envoyer' => 'Vous vous appr&ecirc;tez &agrave; envoyer',
'vous_vous_appretez_a_valider_les_operations' => 'Vous vous appr&ecirc;tez &agrave; valider les op&eacute;rations&nbsp;:',
'vous_vous_appretez_a_effacer' => 'Vous vous appr&ecirc;tez &agrave; effacer',
'relance' => 'relance',
'relances' => 'relances',
'ventes' => 'ventes',
'vente' => 'vente',

'action_sur_les_ventes_associatives' => 'Action sur les ventes associatives',
'ajout_de_cotisation' => 'Ajout de cotisation',
'ajouter_un_don' => 'Ajouter un don',
'ajouter_une_vente' => 'Ajouter une vente',
'bilans_comptables' => 'Bilans comptables',
'date_du_paiement_AAAA-MM-JJ' => 'Date du paiement (AAAA-MM-JJ)',
'edition_plan_comptable' => 'Edition plan comptable',
'informations_comptables' => 'Informations comptables',
'modification_des_comptes' => 'Modification des comptes',
'relance_de_cotisations' => 'Relance de cotisations',
'suppression_de_compte' => 'Suppression de compte',
'suppression_de_destination' => 'Suppression de destination',
'tous_les_dons' => 'Tous les dons',
'toutes_les_ventes' => 'Toutes les ventes',
'montant_paye_en_euros' => 'Montant pay&eacute; (en euros)',
'nouvelle_cotisation' => 'Nouvelle cotisation',
);

?>