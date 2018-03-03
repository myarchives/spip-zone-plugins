<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
// Fichier source, a modifier dans svn://zone.spip.org/spip-zone/_plugins_/saisie_evenements/trunk/lang/
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS[$GLOBALS['idx_lang']] = array(
	'date_debut_max_fixe_label' => 'Date de début maximale',
	'date_debut_max_fixe_explication' => 'Proposer uniquement les événements qui commencent AVANT la date suivante (incluse).', 
	'date_debut_min_mobile_label' => 'Date de début minimale (mobile)',
	'date_debut_min_mobile_explication' => 'Proposer uniquement les événements qui commencent  à partir de <emph>x</emph> jours. Pour les événements qui commencent demain ou plus tard, mettre 1. Pour les événements qui commencent  hier ou plus tard, mettre -1.', 
	'date_debut_max_mobile_label' => 'Date de début maximale (mobile)',
	'date_debut_max_mobile_explication' => 'Proposer uniquement les événements qui commencent avant <emph>x</emph> jours. Pour les événements qui commencent demain au plus tard demain, mettre 1. Pour les événements qui commencent au plus tard hier, mettre -1.', 

	'date_debut_min_fixe_label' => 'Date de début minimale',
	'date_debut_min_fixe_explication' => 'Proposer uniquement les événements qui commencent APRÈS la date suivante (incluse).', 
	'option_type_affichage_label' => 'Présentation des événements', 
	'option_type_affichage_titre' => 'Uniquement le titre de l\'événement',
	'option_type_affichage_date' => 'Uniquement la date de l\'événement',
	'option_type_affichage_titre_date' => 'Le titre et la date de l\'événement',
	
	'option_type_choix_label' => 'Type de choix', 
	'option_type_choix_radio' => 'Choix unique (boutons radios)',
	'option_type_choix_checkbox' => 'Choix multiples (case à cocher)',
	
	'ids_evenement_label' => 'Événements', 
	'ids_evenement_explication' => 'Proposer les événements suivants.', 
	'ids_article_label' => 'Articles', 
	'ids_article_explication' => 'Proposer les événements des articles des articles suivants.', 

	'ids_rubrique_label' => 'Rubrique', 
	'ids_rubrique_explication' => 'Proposer les événements des articles dans les rubriques suivantes.', 

	'ids_branche_label' => 'Branche', 
	'ids_branche_explication' => 'Proposer les événements des articles dans les branches suivantes. Une branche correspond à une rubrique et ses sous-rubriques.', 

	'ids_mot_label' => 'Mot clé', 
	'ids_mot_explication' => 'Proposer les événements ayant le(s) mot(s) clé suivant.', 
	// S
	'saisie_evenements_explication' => 'Un choix d’un ou plusieurs événements',
	'saisie_evenements_titre' => 'Sélecteur d’événements',
	'saisie_evenements_chronologie_texte' => 'Les critères de date pour les choix des événements sont cumulatifs avec les critères précédents d\'association à des objets.', 
	'saisie_evenements_ids_texte' => 'Les événements proposés peuvent être choisis par leurs identifiants, ou bien par leur association à des articles, des rubriques, des mots.<br /> 
	Pour ce faire, il faut indiquer un identifiant, éventuellement plusieurs séparés par des virgules, dans les champs <emph>a hoc</emph>.<br />
	Si plusieurs critères de sélections sont définis, un ET logique est utilisé. Ainsi, si vous mettez 4 dans le champ article et 2 dans le champ mot, les évènements appartennant à l\'article&nbsp;4 tout en ayant le mot-clé&nbsp;2 seront proposés.'
);
