<?php
/**
 * Déclarations relatives à la base de données
 *
 * @plugin     Albums
 * @copyright  2014
 * @author     Tetue, Charles Razack
 * @licence    GNU/GPL
 * @package    SPIP\Albums\Fonctions
 */

// Sécurité
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}


/**
 * Déclaration des alias de tables et filtres automatiques de champs
 *
 * @pipeline declarer_tables_interfaces
 * @param array $interfaces
 *     Déclarations d'interface pour le compilateur
 * @return array
 *     Déclarations d'interface pour le compilateur
 */
function albums_declarer_tables_interfaces($interfaces) {

	$interfaces['table_des_tables']['albums'] = 'albums';

	return $interfaces;
}


/**
 * Déclaration des objets éditoriaux
 *
 * @pipeline declarer_tables_objets_sql
 * @param array $tables
 *     Description des tables
 * @return array
 *     Description complétée des tables
 */
function albums_declarer_tables_objets_sql($tables) {

	/* ALBUMS */
	$tables['spip_albums'] = array(
		'type'                  => 'album',
		'principale'            => 'oui',
		'field'=> array(
			'id_album'          => 'bigint(21) NOT NULL',
			'titre'             => "text DEFAULT '' NOT NULL",
			'descriptif'        => "text DEFAULT '' NOT NULL",
			'date'              => "datetime DEFAULT '0000-00-00 00:00:00' NOT NULL",
			'statut'            => "varchar(10) DEFAULT '' NOT NULL",
			'lang'              => "VARCHAR(10) DEFAULT '' NOT NULL",
			'langue_choisie'    => "VARCHAR(3) DEFAULT 'non'",
			'id_trad'           => "bigint(21) DEFAULT '0' NOT NULL",
			'maj'               => 'TIMESTAMP'
		),
		'key' => array(
			'PRIMARY KEY'       => 'id_album',
			'KEY lang'          => 'lang',
			'KEY id_trad'       => 'id_trad',
			'KEY statut'        => 'statut',
		),
		'titre'                 => 'titre, lang AS lang',
		'date'                  => 'date',
		'champs_editables'      => array('titre', 'descriptif'),
		'champs_versionnes'     => array('titre', 'descriptif'),
		'rechercher_champs'     => array(
			'titre' => 10,
			'descriptif' => 4
		),
		'tables_jointures'      => array(
		),
		'modeles'               => array('album'),
		'statut'=> array(
			array(
				'champ'         => 'statut',
				'publie'        => 'publie',
				'previsu'       => 'prepa,publie',
				'post_date'     => 'date',
				'exception'     => array('statut','tout')
			)
		),
		'statut_textes_instituer' => array(
			'prepa'             => 'album:texte_statut_prepa',
			'publie'            => 'album:texte_statut_publie',
			'poubelle'          => 'album:texte_statut_poubelle',
		),
		'texte_changer_statut'  => 'album:texte_changer_statut',
	);

	// jointures sur les albums pour tous les objets
	// passe apres id_auteur=>auteurs_liens et evite de le casser
	$tables[]['tables_jointures'][]= 'albums_liens';
	$tables[]['tables_jointures'][]= 'albums';

	return $tables;
}


/**
 * Déclaration des tables secondaires (liaisons)
 *
 * @pipeline declarer_tables_auxiliaires
 * @param array $tables
 *     Description des tables
 * @return array
 *     Description complétée des tables
 */
function albums_declarer_tables_auxiliaires($tables) {

	$tables['spip_albums_liens'] = array(
		'field' => array(
			'id_album'     => "bigint(21) DEFAULT '0' NOT NULL",
			'id_objet'     => "bigint(21) DEFAULT '0' NOT NULL",
			'objet'        => "VARCHAR (25) DEFAULT '' NOT NULL",
			'vu'           => "ENUM('non', 'oui') DEFAULT 'non' NOT NULL"
		),
		'key' => array(
			'PRIMARY KEY'  => 'id_album,id_objet,objet',
			'KEY id_album' => 'id_album',
		)
	);

	return $tables;
}
