<?php
/**
 * Déclarations relatives à la base de données
 *
 * @plugin     Sélections éditoriales
 * @copyright  2014
 * @author     Les Développements Durables
 * @licence    GNU/GPL v3
 * @package    SPIP\Selections_editoriales\Pipelines
 */

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
function selections_editoriales_declarer_tables_interfaces($interfaces) {
	$interfaces['table_des_tables']['selections'] = 'selections';
	$interfaces['table_des_tables']['selections_contenus'] = 'selections_contenus';

	$interfaces['table_des_traitements']['URL']['selections_contenus'] = 'calculer_url(%s)';

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
function selections_editoriales_declarer_tables_objets_sql($tables) {

	$tables['spip_selections'] = array(
		'type' => 'selection',
		'principale' => 'oui',
		'field'=> array(
			'id_selection'       => 'bigint(21) NOT NULL',
			'titre'              => 'text NOT NULL DEFAULT ""',
			'descriptif'         => 'text NOT NULL DEFAULT ""',
			'css' 				 => 'varchar(255) NOT NULL DEFAULT ""',
			'identifiant'        => 'varchar(255) NOT NULL DEFAULT ""',
			'limite'             => 'int(6) NOT NULL DEFAULT 0',
			'maj'                => 'TIMESTAMP'
		),
		'key' => array(
			'PRIMARY KEY'        => 'id_selection',
		),
		'titre' => "titre AS titre, '' AS lang",
		 #'date' => '',
		'modeles' => array('selection_edito'),
		'champs_editables'  => array('titre', 'descriptif', 'identifiant', 'css', 'limite'),
		'champs_versionnes' => array('titre', 'descriptif', 'identifiant', 'css', 'limite'),
		'rechercher_champs' => array('titre' => 8, 'descriptif' => 4, 'identifiant' => 8),
		'rechercher_jointures' => array(
			'selections_contenu' => array('titre' => 6, 'descriptif' => 2)
		),
		'tables_jointures'  => array('spip_selections_liens')
	);

	$tables['spip_selections_contenus'] = array(
		'type' => 'selections_contenu',
		'principale' => 'oui',
		// table_objet('selections_contenu') => 'selections_contenus'
		'table_objet_surnoms' => array('selectionscontenu'),
		'field'=> array(
			'id_selections_contenu' => 'bigint(21) NOT NULL',
			'id_selection'       => 'bigint(21) NOT NULL DEFAULT 0',
			'rang'               => 'int NOT NULL DEFAULT 0',
			'titre'              => 'text NOT NULL DEFAULT ""',
			'url'                => 'text NOT NULL DEFAULT ""',
			'descriptif'         => 'text NOT NULL DEFAULT ""',
			'css'                => 'varchar(255) not null default ""',
			'id_objet'           => 'bigint(21) NOT NULL DEFAULT 0',
			'objet'              => 'VARCHAR(25) NOT NULL DEFAULT ""',
			'maj'                => 'TIMESTAMP'
		),
		'key' => array(
			'PRIMARY KEY'        => 'id_selections_contenu',
			'KEY id_selection'        => 'id_selection',
		),
		'titre' => "titre AS titre, '' AS lang",
		 #'date' => "",
		'champs_editables'  => array('rang', 'objet', 'id_objet', 'titre', 'url', 'descriptif', 'id_selection', 'css'),
		'champs_versionnes' => array('objet', 'id_objet', 'titre', 'url', 'descriptif', 'css'),
		'rechercher_champs' => array('titre' => 8, 'descriptif' => 4),
		'tables_jointures'  => array(),
		'parent' => array('type' => 'selection', 'champ' => 'id_selection'),
	);


	$tables[]['champs_versionnes'][] = 'jointure_selections';
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
function selections_editoriales_declarer_tables_auxiliaires($tables) {
	$tables['spip_selections_liens'] = array(
		'field' => array(
			'id_selection'       => 'bigint(21) DEFAULT "0" NOT NULL',
			'id_objet'           => 'bigint(21) DEFAULT "0" NOT NULL',
			'objet'              => 'VARCHAR(25) DEFAULT "" NOT NULL',
			'vu'                 => 'VARCHAR(6) DEFAULT "non" NOT NULL'
		),
		'key' => array(
			'PRIMARY KEY'        => 'id_selection,id_objet,objet',
			'KEY id_selection'   => 'id_selection'
		)
	);
	return $tables;
}
