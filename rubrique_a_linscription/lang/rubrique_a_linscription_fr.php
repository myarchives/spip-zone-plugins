<?php
/** Fichier de langue de SPIP **/
if (!defined("_ECRIRE_INC_VERSION")) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(
	'accepter_inscription'		=>"Pour utiliser ce plugin vous devez <a href='?exec=config_contenu#configurer-redacteurs'>autoriser l'inscription de rédacteurs</a>.",
	'cfg_pas_creer_mot'			=>'Ne pas créer de mot clef',
	'cfg_argument_explicite'	=>'Le formulaire d\'inscription ne crée la rubrique ad hoc que si on lui passe l\'argument {rubrique_a_linscription}',
	'cfg_avertissement_changement'	=> 'Attention : si vous modifiez ce paramètre, les rubriques déja créées ne changeront pas de place pour autant.',
	'cfg_espace_prive_voir'		=> "Ne pas autoriser les auteurs ainsi créés à voir d'autres rubriques dans l'espace privé",
	'cfg_espace_prive'			=> "Lien avec l'espace privé",
	'cfg_explication'			=>	"Ce plugin propose de créer automatiquement une rubrique lorsqu'une personne s'inscrit sur le site. La personne inscrite reçoit les droits d'administrations sur cette rubrique",
	'cfg_generale'				=> 'Configuration générale',
	'cfg_groupes_mots'			=> 'Créer automatiquement un mot dans le groupe : ',
	'cfg_id_parent'				=> 'Rubrique mère des rubriques créées',
	'cfg_mail'					=> 'Envoyer un mail au nouvel inscrit avec :',
	'cfg_mail_public'			=> 'L\'adresse publique de la rubrique',
	'cfg_mail_privee'			=> 'L\'adresse privée de la rubrique',
	'cfg_statut'				=> 'Statut des auteurs',
	'mail_adresse_rubrique'		=>"L'adresse de votre rubrique reservée est : \n",
	'rubrique_a_linscription'	=> 'Rubrique à l\'inscription',
	'titre_mail_adresse_rubrique'=> 'Votre rubrique reservée',
	'titre_rubrique'			=> 'Rubrique de @nom@',
	'mot_clef_de'				=> 'Mot-clef de @nom@',
	
	'rubrique_reserve_0minirezo'=>"L'espace privé de ce site est ouvert aux visiteurs, après inscription. Une fois enregistré, vous pourrez consulter les articles en cours de rédaction, proposer des articles et participer à tous les forums. Vous disposerez également d'une rubrique réservée où vous pourrez poster vos articles.",
	'rubrique_reserve_1comite'=>"L'espace privé de ce site est ouvert aux visiteurs, après inscription. Une fois enregistré, vous pourrez consulter les articles en cours de rédaction, proposer des articles et participer à tous les forums. Vous disposerez également d'une rubrique réservée où vous pourrez proposer vos articles.",
	'rubrique_reserve_0minirezo_on'=>"L'espace privé de ce site est ouvert aux visiteurs, après inscription. Une fois enregistré, vous disposerez d'une rubrique réservée où vous pourrez poster vos articles.",
	'rubrique_reserve_1comite_on'=>"L'espace privé de ce site est ouvert aux visiteurs, après inscription. Une fois enregistré, vous disposerez d'une rubrique réservée où vous pourrez proposer vos articles."
	
	
);

?>
