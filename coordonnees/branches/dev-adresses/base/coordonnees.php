<?php
/**
 * Plugin Coordonnees
 * Licence GPL (c) 2010 - Marcimat / Ateliers CYM
 */

if (!defined('_ECRIRE_INC_VERSION')) return;


/**
 * Déclaration des alias de tables et filtres automatiques de champs
 */
function coordonnees_declarer_tables_interfaces($interfaces) {

	$interfaces['table_des_tables']['adresses'] = 'adresses';
	$interfaces['table_des_tables']['numeros'] = 'numeros';
	$interfaces['table_des_tables']['emails'] = 'emails';

	$interfaces['tables_jointures']['spip_auteurs'][] = 'adresses_liens';
	$interfaces['tables_jointures']['spip_auteurs'][] = 'numeros_liens';
	$interfaces['tables_jointures']['spip_auteurs'][] = 'emails_liens';

	$interfaces['table_des_traitements']['VILLE'][] = _TRAITEMENT_TYPO;

	return $interfaces;
}


/**
 * Déclaration des objets éditoriaux
 */
function coordonnees_declarer_tables_objets_sql($tables) {

	/* ADRESSES */
	$tables['spip_adresses'] = array(
		'type'                   => 'adresse',
		'principale'             => "oui",
		'field' => array(
			"id_adresse"          => "bigint(21) NOT NULL",
			"titre"               => "varchar(255) NOT NULL DEFAULT ''", // perso, pro, vacance...
			"voie"                => "tinytext NOT NULL default ''", // p. ex. 21 rue de cotte
			"complement"          => "tinytext NOT NULL default ''", // p. ex. 3e etage
			"localite_dependante" => 'tinytext NOT NULL default ""',
			"code_postal"         => "varchar(40) NOT NULL DEFAULT ''",
			"ville"               => "tinytext NOT NULL",
			'zone_administrative' => 'tinytext NOT NULL default ""',
			"pays"                => "varchar(3) NOT NULL DEFAULT ''",
			"maj"                 => "TIMESTAMP"
		),
		'key' => array(
			"PRIMARY KEY"      => "id_adresse",
			"KEY iso3166"      => "pays",
			"KEY zip"          => "zone_administrative(255), code_postal"
		),
		'titre' => "titre AS titre, '' AS lang",
		'champs_editables'       => array('titre', 'voie', 'complement', 'boite_postale', 'code_postal', 'ville', 'zone_administrative', 'pays'),
		'champs_versionnes'      => array(),
		'rechercher_champs'      => array('pays' => 8, 'titre' => 5, 'voie' => 3, 'zone_administrative' => 3, 'ville' => 3),
		'tables_jointures'       => array('spip_adresses_liens'),
		/* Les textes standard */
		'texte_modifier'         => 'coordonnees:modifier_adresse',
		'texte_ajouter'          => 'coordonnees:ajouter_adresse',
		'texte_logo_objet'       => 'coordonnees:logo_adresse',
		'texte_creer'            => 'coordonnees:nouvelle_adresse',
		'texte_objet'            => 'coordonnees:adresse',
		'texte_objets'           => 'coordonnees:adresses',
		'info_aucun_objet'       => 'coordonnees:info_aucune_adresse',
		'info_1_objet'           => 'coordonnees:info_1_adresse',
		'info_nb_objets'         => 'coordonnees:info_nb_adresses',
	);

	/* NUMEROS DE TELEPHONE */
	$tables['spip_numeros'] = array(
		'type'                   => 'numero',
		'principale'             => "oui",
		'field' => array(
			"id_numero"        => "bigint(21) NOT NULL",
			"titre"            => "varchar(255) NOT NULL DEFAULT ''", // domicile, bureau, etc.
			"numero"           => "varchar(255) NOT NULL DEFAULT ''",
			"maj"              => "TIMESTAMP"
		),
		'key' => array(
			"PRIMARY KEY"      => "id_numero",
			"KEY numero"       => "numero" // on ne met pas unique pour le cas ou 2 contacts partagent le meme numero generique
		),
		'titre' => "titre AS titre, '' AS lang",
		'champs_editables'       => array( 'titre', 'numero' ),
		'champs_versionnes'      => array(),
		'rechercher_champs'      => array('titre' => 5, 'numero' => 5),
		'tables_jointures'       => array('spip_numeros_liens'),
		/* Les textes standard */
		'texte_modifier'         => 'coordonnees:modifier_numero',
		'texte_ajouter'          => 'coordonnees:ajouter_numero',
		'texte_logo_objet'       => 'coordonnees:logo_numero',
		'texte_creer'            => 'coordonnees:nouveau_numero',
		'texte_objet'            => 'coordonnees:numero',
		'texte_objets'           => 'coordonnees:numeros',
		'info_aucun_objet'       => 'coordonnees:info_aucun_numero',
		'info_1_objet'           => 'coordonnees:info_1_numero',
		'info_nb_objets'         => 'coordonnees:info_nb_numeros',
	);

	/* EMAILS */
	$tables['spip_emails'] = array(
		'type'                   => 'email',
		'principale'             => "oui",
		'field' => array(
			"id_email"         => "bigint(21) NOT NULL",
			"titre"            => "varchar(255) NOT NULL DEFAULT ''", // perso, boulot, etc.
			"email"            => "varchar(255) NOT NULL DEFAULT ''",
			"maj"              => "TIMESTAMP"
		),
		'key' => array(
			"PRIMARY KEY"      => "id_email",
			"KEY email"        => "email" // on ne met pas unique pour le cas ou 2 contacts partagent le meme mail generique
		),
		'titre' => "titre AS titre, '' AS lang",
		'champs_editables'       => array( 'titre', 'email' ),
		'champs_versionnes'      => array(),
		'rechercher_champs'      => array('titre' => 5, 'email' => 5),
		'tables_jointures'       => array('spip_emails_liens'),
		/* Les textes standard */
		'texte_modifier'         => 'coordonnees:modifier_email',
		'texte_ajouter'          => 'coordonnees:ajouter_email',
		'texte_logo_objet'       => 'coordonnees:logo_email',
		'texte_creer'            => 'coordonnees:nouvel_email',
		'texte_objet'            => 'coordonnees:email',
		'texte_objets'           => 'coordonnees:emails',
		'info_aucun_objet'       => 'coordonnees:info_aucun_email',
		'info_1_objet'           => 'coordonnees:info_1_email',
		'info_nb_objets'         => 'coordonnees:info_nb_emails',
	);

	return $tables;
}


/**
 * Déclaration des tables secondaires (liaisons)
 */
function coordonnees_declarer_tables_auxiliaires($tables) {

	$tables['spip_adresses_liens'] = array(
		'field' => array(
			"id_adresse"        => "bigint(21) DEFAULT '0' NOT NULL",
			"id_objet"          => "bigint(21) DEFAULT '0' NOT NULL",
			"objet"             => "VARCHAR(25) DEFAULT '' NOT NULL",
			"type"              => "VARCHAR(25) DEFAULT '' NOT NULL",
			"vu"                => "VARCHAR(6) DEFAULT 'non' NOT NULL"
		),
		'key' => array(
			"PRIMARY KEY"       => "id_adresse,id_objet,objet,type", // on rajoute le type car on en rajoute un par liaison et qu'il peut y en avoir plusieurs
			"KEY id_adresse"    => "id_adresse",
			"KEY id_objet"      => "id_objet",
			"KEY objet"         => "objet",
		)
	);
	$tables['spip_numeros_liens'] = array(
		'field' => array(
			"id_numero"         => "bigint(21) DEFAULT '0' NOT NULL",
			"id_objet"          => "bigint(21) DEFAULT '0' NOT NULL",
			"objet"             => "VARCHAR(25) DEFAULT '' NOT NULL",
			"type"              => "VARCHAR(25) DEFAULT '' NOT NULL",
			"vu"                => "VARCHAR(6) DEFAULT 'non' NOT NULL"
		),
		'key' => array(
			"PRIMARY KEY"       => "id_numero,id_objet,objet,type", // on rajoute le type car on en rajoute un par liaison et qu'il peut y en avoir plusieurs
			"KEY id_numero"     => "id_numero",
			"KEY id_objet"      => "id_objet",
			"KEY objet"         => "objet",
		)
	);
	$tables['spip_emails_liens'] = array(
		'field' => array(
			"id_email"          => "bigint(21) DEFAULT '0' NOT NULL",
			"id_objet"          => "bigint(21) DEFAULT '0' NOT NULL",
			"objet"             => "VARCHAR(25) DEFAULT '' NOT NULL",
			"type"              => "VARCHAR(25) DEFAULT '' NOT NULL",
			"vu"                => "VARCHAR(6) DEFAULT 'non' NOT NULL"
		),
		'key' => array(
			"PRIMARY KEY"       => "id_email,id_objet,objet,type", // on rajoute le type car on en rajoute un par liaison et qu'il peut y en avoir plusieurs
			"KEY id_email"      => "id_email",
			"KEY id_objet"      => "id_objet",
			"KEY objet"         => "objet",
		)
	);

	return $tables;
}
