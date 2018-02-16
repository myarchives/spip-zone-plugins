<?php
/** Fichier de langue de SPIP **/
if (!defined("_ECRIRE_INC_VERSION")) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(
	'accepter_inscription'		=>"Pour utiliser ce plugin vous devez <a href='?exec=configurer_interactions'>autoriser l'inscription de rédacteurs</a>.",
	'auteur_bascule'			=>'Les auteurs @id_auteurs@ ont bien été basculés',
	'cfg_pas_creer_mot'			=>'Ne pas créer de mot clef',
	'cfg_formulaire_explicite_explication'	=>'Le formulaire d\'inscription ne crée la rubrique ad hoc que si on utilise <code>#FORMULAIRE_INSCRIPTION_AVEC_RUBRIQUE</code>',
	'cfg_formulaire_explicite_label' => 'Formulaire explicite', 
	'cfg_generale_attention'	=> 'Attention ! Si vous modifiez les paramètres ci-dessous, les modifications ne seront pas appliqués retroactivement.',
	'cfg_espace_prive_voir_explication'		=> "Ne pas autoriser les auteurs ainsi créés à voir d'autres rubriques dans l'espace privé, à l'exception des rubriques parentes de la rubrique de l'auteur",
	'cfg_espace_prive_voir_label' => 'Vision restreinte', 
	'cfg_espace_prive_creer_label' => 'Création restreinte', 
	'cfg_espace_prive_creer_explication'		=> "Ne pas autoriser les auteurs ainsi créés à proposer des articles en dehors de leur rubrique",
	'cfg_espace_prive'			=> "Lien avec l'espace privé",
	'cfg_explication'			=>	"Le plugin «&nbsp;Rubrique à l'inscription&nbsp;» permet de créer automatiquement une rubrique à l'inscription d'une personne sur le site.",
	'cfg_generale_label'				=> 'Configuration générale',
	'cfg_groupe_mots'			=> 'Groupe où créer automatiquement un mot-clef',
	'cfg_rubrique_mere_explication'				=> 'Laisser vide pour créer les rubriques à la racine.',
	'cfg_rubrique_mere_label'				=> 'Rubrique mère des rubriques créées',
	'cfg_mail'					=> 'Envoyer un courriel contenant',
	'cfg_mail_public_label'			=> 'L\'adresse publique de la rubrique',
	'cfg_mail_prive_label'			=> 'L\'adresse privée de la rubrique',
	'cfg_statut'				=> 'Statut des auteurs',
	'explication_bascule'		=> 'Cochez les auteurs à basculer en auteur "Normal" (ne supprime pas pour autant la restriction d\'administration.).',
	'mail_adresse_rubrique'		=>"L'adresse de votre rubrique reservée est : \n",
	'rubrique_a_linscription'	=> 'Rubrique à l\'inscription',
	'titre_mail_adresse_rubrique'=> 'Votre rubrique reservée',
	'titre_rubrique'			=> 'Rubrique de @nom@',
	'mot_clef_de'				=> 'Mot-clef de @nom@',
	
	'rubrique_reserve_0minirezo'=>"L'espace privé de ce site est ouvert aux visiteurs, après inscription. Une fois enregistré, vous pourrez consulter les articles en cours de rédaction, proposer des articles et participer à tous les forums. Vous disposerez également d'une rubrique réservée où vous pourrez poster vos articles.",
	'rubrique_reserve_1comite'=>"L'espace privé de ce site est ouvert aux visiteurs, après inscription. Une fois enregistré, vous pourrez consulter les articles en cours de rédaction, proposer des articles et participer à tous les forums. Vous disposerez également d'une rubrique réservée où vous pourrez proposer vos articles.",
	'rubrique_reserve_0minirezo_on'=>"L'espace privé de ce site est ouvert aux visiteurs, après inscription. Une fois enregistré, vous disposerez d'une rubrique réservée où vous pourrez poster vos articles.",
	'rubrique_reserve_1comite_on'=>"L'espace privé de ce site est ouvert aux visiteurs, après inscription. Une fois enregistré, vous disposerez d'une rubrique réservée où vous pourrez proposer vos articles.",
	'pas_autoriser_rubriquer_creerarticledans'=>'Vous n\'êtes pas pas autorisé à créer un article dans cette rubrique'
	
	
);

?>
