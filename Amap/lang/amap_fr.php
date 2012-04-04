<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// A
	'action' => 'Action ?',
	'action_modifier' => 'Modifier',
	'action_supprimer' => 'Supprimer',
	'adherent' => 'Adhérent', 
	'adherent_sans_type_panier_sans_type_adherent' => 'Vos adhérents n\'ont pas encore de type de panier affecté ou de type d\'adhérent.', 
	'adhesion' => 'Adhésion (ex:2008)',
	'adhesion_auteur' => 'Adhésion :',
	'administrateur' => 'Administrateur',
	'attention' => 'ATTENTION !',
	'attention_modifications' => '<p>Vous venez d\'activer le plugin AMAP, ce dernier vient de créer une nouvelle rubrique "Agenda de la saison" avec deux sous-rubriques "Distribution" et "Évènements", ainsi que la rubrique "Archives".</p>
									1. Avant de poursuivre, veuillez renseigner toutes les dates de votre saison grâce au plugin agenda.<br />
									2. Cette opération devra être effectuée avant chaque début de nouvelles saisons.<br />
									3. À la fin de chaque saison, vous prendrez soin de mettre à jour la liste des amapiens, ainsi que l\'archivage dans la rubrique appropriée, des dates de la saison passée, ceci pour le bon fonctionnement de ce plugin.<br />
									4. Mettre à jour les <b>type d\'adhérent</b>, <b>adhésion</b> et <b>type de panier</b> sur la page de chaque auteur sinon aucun panier ne pourra lui être attribué.<br />
									<p><strong>LE NON RESPECT DE CES QUELQUES PRINCIPES ENTRAINERA UN DYSFONCTIONNEMENT DU PLUGIN AMAP</strong></p>',
	'aucun_panier_pour_nom' => 'Nous n\'avons aucun panier pour @nom@.',
	'aucun_panier_produit_par_nom' => 'Nous n\'avons aucun panier produit par @nom@.',
	'avant_le' => 'avant le',

	// C
	'confirmation_envoi' => 'Votre mise a disposition du panier du @date_distribution@ est confimer, nous vous remercions.',
	'contenu_panier' => 'Contenu du panier',
	'contenu_panier_explication' => 'Vous pouvez rédiger votre contenu de la même façon que dans SPIP.',
	'creer_paniers_pour_nom' => 'Créer des paniers pour @nom@.',

	// D
	'date_distribution' => 'Date de la distribution',
	'date_livraison' => 'Date de la livraison',
	'depuis_le' => 'depuis le',
	'distribution_paniers' => 'Distribution des paniers du @nb@',

	// E
	'enregistrement' => 'Enregistrement',
	'enregistrement_panier' => 'Enregistrement d\'un panier',
	'envoyer' => 'Envoyer',

	// G
	'gestion_amap' => 'Gestion AMAP',
	'grand' => 'Grand',

	// I
	'information_amap' => 'Information AMAP',
	'impression' => 'Impression',
	'impression_donnees' => 'Impression de données',
	'impression_donnees_fonction_date' => 'Impression des paniers en fonction d\'une date :',
	'impression_explication' => 'Seulement les dates contenant au minimum un panier sont cliquables et ouvrent une nouvelle fenêtre.',

	// L
	'les_livraisons' => 'Les livraisons',
	'les_livraisons_effectuees' => 'Les livraisons déjà effectuées',
	'les_paniers' => 'Les paniers de @nom@',
	'liste_amapiens' => 'Liste des amapiens',
	'liste_amapiens_enregistres'  => 'Liste des amapiens enregistrés',
	'liste_livraisons' => 'Liste des livraisons',
	'liste_paniers' => 'Liste des paniers',
	'liste_paniers_distribuer_le' => 'Liste des paniers à distribuer le',
	'liste_paniers_vendu_par' => 'Liste des paniers produit par @nom@',
	'livraison' => 'Livraison',

	// M
	'manque_fpdf_imprimer' => 'Il vous manque le plugins "fpdf" pour pouvoir imprimer vos listes de paniers.',
	'mettre_disposition' => 'Mettre à disposition',
	'mini_doc' => 'Mini documentation',

	// N
	'nom'  => 'NOM',

	// P
	'panier' => 'Panier',
	'panier_deja_vendu' => 'Vous avez déjà vendu 1 panier',
	'panier_dispo' => 'Panier disponible le @date_distribution@',
	'panier_dispo_auteur' => 'Bonjour,
		<br />Je mets à disposition le panier du @date_distribution@
		<br />@nom_adherent@',
	'panier_dispo_auteur_mail' => 'Bonjour,
Je mets à disposition le panier du @date_distribution@, pour le récupérer suiver le lien suivant @lien@
@panier_dispo_plus@
@nom_adherent@',
	'panier_dispo_plus' => 'Des infos à donner en plus (elle seront rajouter dans le mail envoyer avant votre nom)',
	'panier_distribuer' => 'panier à distribuer',
	'panier_liste' => 'Liste des paniers',
	'panier_livraison' => 'Contenu d\'un panier',
	'panier_recupere' => 'Panier du @date_distribution@ récupéré',
	'panier_recupere_auteur_mail' => 'Bonjour,
Je récupère le panier du @date_distribution@ produit par @nom_producteur@
@nom_adherent@',
	'paniers_deja_vendu' => 'Vous avez déjà vendu @nb@ panier',
	'paniers_distribuer' => 'paniers à distribuer',
	'pas_connecte_ou_reconnu' => 'Vous n\'êtes pas connecté ou on ne vous a pas reconnu.',
	'pas_date_distributions' => 'Pas de date de distribution renseigné.',
	'pas_paniers' => 'Vous ne disposez d\'aucun panier durant cette saison, en effet aucun contrat vous concernant n\'est actuellement en cours',
	'pas_producteur_amap' => 'Vous n\'avez pas de producteur dans votre amap.',
	'petit' => 'Petit',
	'producteur' => 'Producteur',
	'producteurs' => 'Producteurs',

	// Q
	'qui_recupere_panier_disponible' => 'Qui récupère le panier disponible ?',

	// R
	'reste_panier_distribuer' => 'Il nous reste encore 1 panier à distribuer',
	'reste_panier_recuperer' => 'Il vous reste encore 1 panier à recupérer',
	'reste_paniers_distribuer' => 'Il nous reste encore @nb@ paniers à distribuer',
	'reste_paniers_recuperer' => 'Il vous reste encore @nb@ paniers à recupérer',
	'retour_auteur' => 'Retour sur la page auteur de @nom@',

	//S
	'signature' => 'Signature',

	// T
	'table_vide_aucun_enregistrement' => 'Cette table est actuellement vide :
										<br />Elle ne contient aucun enregistrement.',
	'type_panier' => 'Type de panier',
	'type_panier_auteur' => 'Type de panier :',
	'type_adherent' => 'Type d\'adhérent',
	'type_adherent_auteur' => 'Type d\'adhérent :',

	//U
	'utiliser_entete_colone_tri' => 'Utiliser les entêtes de colonne pour classer les amapiens (en noir l\'ordre de tri actif et en vert les ordres disponibles).',

	// V
	'visiteur' => 'Visiteur',
	'vos_paniers' => 'Vos paniers',
);

?>
