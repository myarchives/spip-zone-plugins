<?php
// This is a SPIP language file  --  Ceci est un fichier langue de SPIP
if (!defined('_ECRIRE_INC_VERSION')) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// B
	'action_wikipedia_descriptif' => 'Remplir le descriptif avec Wikipedia',

	// B
	'bouton_taxonomie' => 'Taxons',

	// C
	'credit_itis' => 'Integrated Taxonomic Information System, @url_site@ (informations taxonomiques de base). Voir aussi la page du taxon @url_taxon@.',
	'credit_cinfo' => 'Commission internationale des noms français des oiseaux (CINFO), @url@.',
	'credit_wikipedia' => 'Wikipedia (@champs@). Voir aussi la page du taxon @url_taxon@.',

	// D

	// E
	'erreur_vider_regne' => 'Erreur lors du vidage du règne @regne@ en base de données.',
	'erreur_charger_regne' => 'Erreur lors du chargement du règne @regne@ en base de données.',
	'explication_action_regne' => 'Si le règne est déjà présent en base de données, tous les taxons qui le composent seront supprimés avant le chargement.',
	'explication_langues_regne' => 'Les taxons sont chargés par défaut avec leur nom scientifique. Cette option permet de compléter certains taxons avec leur nom commun dans la ou les langues précisées.',
	'explication_langues_utilisees' => 'Le plugin supporte quelques langues comme le français, l\'anglais et l\'espagnol. Cela permet de charger voire de saisir manuellement les noms communs et descriptifs dans ces langues.
	Néanmoins, en fonction de votre besoin vous pouvez limiter l\'utilisation de ces langues mais une langue est au moins requise.',

	// I
	'info_boite_taxonomie_gestion' => 'Cette page permet aux webmestres de consulter, charger, mettre à jour ou vider les règnes animal, végétal et fongique gérés par le plugin.',
	'info_boite_taxonomie_navigation' => 'Cette page permet aux utilisateurs de consulter la liste des taxons chargés en base de données et de naviguer de taxon en taxon.',
	'info_regne_charge' => 'déjà chargé',
	'info_regne_compteur_taxons' => '@nb@ taxons chargés du règne au @rang@',
	'info_regne_compteur_traductions' => '@nb@ noms communs en [@langue@]',

	// L
	'label_action_charger_regne' => 'Charger un règne',
	'label_action_regne' => 'Action à exécuter',
	'label_action_vider_regne' => 'Vider un règne',
	'label_ascendance' => 'Ascendance taxonomique',
	'label_colonne_actualisation' => 'Actualisé le',
	'label_colonne_statistiques' => 'Statistiques',
	'label_rang_feuille' => 'Charger le règne jusqu\'au rang',
	'label_regne' => 'Règne sur lequel appliquer l\'action',
	'label_langues_regne' => 'Langues des noms communs',
	'label_langues_utilisees' => 'Langues à utiliser',

	// N
	'notice_vider_regne_inexistant' => 'Le règne @regne@ n\'a pas été trouvé en base de données.',
	'notice_liste_aucun_regne' => 'Aucun règne n\'a encore été chargé en base de données. Utiliser le formulaire ci-dessous pour y remédier.',

	// R
	'rang_kingdom' => 'règne',
	'rang_division' => 'division',
	'rang_phylum' => 'phylum',
	'rang_class' => 'classe',
	'rang_order' => 'ordre',
	'rang_family' => 'famille',
    'rang_genus' => 'genre',
    'rang_species' => 'espèce',
    'rang_subspecies' => 'sous-espèce',
    'rang_variety' => 'variété',
    'rang_subvariety' => 'sous-variété',
    'rang_race' => 'race',
    'rang_forma' => 'forme',
    'rang_subforma' => 'sous-forme',
	'regne_animalia' => 'règne animal',
	'regne_fungi' => 'règne fongique',
	'regne_plantae' => 'règne végétal',

	// O
	'onglet_gestion' => 'Gestion des règnes',
	'onglet_configuration' => 'Configuration du plugin',
	'onglet_navigation' => 'Navigation dans la taxonomie',

	// S
	'succes_vider_regne' => 'Le règne @regne@ a bien été supprimé de la base de données.',
	'succes_charger_regne' => 'Le règne @regne@ a bien été chargé en base de données.',

	// T
	'titre_form_configuration' => 'Configuration du plugin',
	'titre_form_gestion_regne' => 'Gestion des règnes',
	'titre_liste_regnes' => 'Liste des règnes chargés en base de données',
	'titre_liste_fils_taxon' => 'Liste des descendants directs du taxon',
	'titre_page_taxonomie' => 'Taxonomie',
);

?>
