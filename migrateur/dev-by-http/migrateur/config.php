<?php

// Étapes
// ------

$GLOBALS['MIGRATEUR_ETAPES'] = array(
	'00_rien' => 'Il vous faut surcharger <code>migrateur/config.php</code>',
);

/*
 * Exemple simple
 * Les étapes mig_* sont présentes dans le plugin 'migrateur' par défaut.
 * Les autres sont à créer pour ses propres besoins.
 */
/*
$GLOBALS['MIGRATEUR_ETAPES'] = array(
	'mig_sync_img'                  => 'Synchroniser le répertoire IMG',
	'mig_bdd_source_make_dump'      => 'Crée un dump SQL de la base de données source (sur le site source dans tmp/dump)',
	'mig_bdd_source_get_dump'       => 'Copie le dernier dump SQL du site source (sur ce site dans tmp/dump)',
	'mig_bdd_destination_put_dump'  => 'Écrase la base de données actuelle par le dernier dump SQL présent dans tmp/dump)',

	'supprimer_tables_inutiles' => 'Suppression des tables SQL inutiles',
	'activer_plugins' => 'Activer les plugins',
	'configurer_site' => 'Changer les configurations du site',
);
*/
