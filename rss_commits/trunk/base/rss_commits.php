<?php
/**
 * Déclarations relatives à la base de données
 *
 * @plugin     Commits de projet
 * @copyright  2014-2017
 * @author     Teddy Payet
 * @licence    GNU/GPL
 * @package    SPIP\RSSCommits\Pipelines
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}


/**
 * Déclaration des alias de tables et filtres automatiques de champs
 *
 * @pipeline declarer_tables_interfaces
 *
 * @param array $interfaces
 *     Déclarations d'interface pour le compilateur
 *
 * @return array
 *     Déclarations d'interface pour le compilateur
 */
function rss_commits_declarer_tables_interfaces($interfaces) {

	$interfaces['table_des_tables']['commits'] = 'commits';

	return $interfaces;
}


/**
 * Déclaration des objets éditoriaux
 *
 * @pipeline declarer_tables_objets_sql
 *
 * @param array $tables
 *     Description des tables
 *
 * @return array
 *     Description complétée des tables
 */
function rss_commits_declarer_tables_objets_sql($tables) {

	$tables['spip_commits'] = array(
		'type' => 'commit',
		'principale' => "oui",
		'field' => array(
			"id_commit" => "bigint(21) NOT NULL",
			"titre" => "text NOT NULL DEFAULT ''",
			"descriptif" => "text NOT NULL DEFAULT ''",
			"texte" => "text NOT NULL DEFAULT ''",
			"auteur" => "varchar(255) NOT NULL DEFAULT ''",
			"url_revision" => "text NOT NULL DEFAULT ''",
			"guid" => "text NOT NULL DEFAULT ''",
			"id_projet" => "bigint(21) NOT NULL DEFAULT 0",
			"date_creation" => "datetime NOT NULL DEFAULT '0000-00-00 00:00:00'",
			"maj" => "TIMESTAMP",
		),
		'key' => array(
			"PRIMARY KEY" => "id_commit",
			"KEY id_projet" => "id_projet",
		),
		'titre' => "titre AS titre, '' AS lang",
		'date' => "date_creation",
		'champs_editables' => array(
			'titre',
			'descriptif',
			'texte',
			'auteur',
			'url_revision',
			'guid',
			'id_projet',
		),
		'champs_versionnes' => array(
			'titre',
			'descriptif',
			'texte',
			'auteur',
			'url_revision',
			'guid',
			'id_projet',
		),
		'rechercher_champs' => array(
			"titre" => 6,
			"descriptif" => 7,
			"texte" => 7,
			"auteur" => 8,
			"url_revision" => 5,
		),
		'tables_jointures' => array(),


	);

	return $tables;
}

