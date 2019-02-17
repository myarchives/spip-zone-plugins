<?php
/**
 * Ce fichier contient les fonctions de service nécessité par le plugin Cache Factory.
 *
 */
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}


/**
 * Renvoie la configuration spécifique des caches de Taxonomie.
 *
 * @param string $plugin
 *        Identifiant qui permet de distinguer le module appelant qui peut-être un plugin comme le noiZetier ou
 *        un script. Pour un plugin, le plus pertinent est d'utiliser le préfixe.
 *
 * @return array
 *        Tableau de la configuration brute du plugin Taxonomie.
 */
function spiperipsum_cache_configurer($plugin) {

	// Initialisation du tableau de configuration avec les valeurs par défaut du plugin Cache.
	$configuration = array(
		'racine'          => '_DIR_VAR',
		'sous_dossier'    => true,
		'nom_obligatoire' => array('date', 'langage'),
		'nom_facultatif'  => array(),
		'extension'       => '.txt',
		'securisation'    => false,
		'serialisation'   => true,
		'separateur'      => '_' ,
		'conservation'    => 86400 * 365
	);

	return $configuration;
}


/**
 * Complète la description canonique d'un cache.
 * Le plugin Spiper Ipsum...
 *
 * @param string $plugin
 *        Identifiant qui permet de distinguer le module appelant qui peut-être un plugin comme le noiZetier
 *        ou un script. Pour un plugin, le plus pertinent est d'utiliser le préfixe.
 * @param array  $cache
 *       Tableau identifiant le cache pour lequel on veut construire le nom.
 * @param string $fichier_cache
 *        Fichier cache désigné par son chemin complet.
 * @param array  $configuration
 *        Configuration complète des caches du plugin utilisateur lue à partir de la meta de stockage.
 *
 * @return array
 *         Description du cache complétée par un ensemble de données propres au plugin.
 */
function spiperipsum_cache_completer($plugin, $cache, $fichier_cache, $configuration) {

	return $cache;
}
