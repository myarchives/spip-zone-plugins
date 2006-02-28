<?php

/*
 * Recherche entendue
 * plug-in d'outils pour la recherche et l'indexation
 * Panneaux de controle admin_index et index_tous
 * Boucle INDEX
 * filtre google_like
 *
 *
 * Auteur :
 * cedric.morin@yterium.com
 * pdepaepe et Nicolas Steinmetz pour google_like
 * � 2005 - Distribue sous licence GNU/GPL
 *
 */
define('_DIR_PLUGIN_ADVANCED_SEARCH',(_DIR_PLUGINS.end(explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__)))))));

function RechercheEtendue_prepare_index_recherche($recherche, $cond=false){
	include_spip('inc/indexation');


	static $cache = array();
	static $fcache = array();
	// traiter le cas {recherche?}
	if ($cond AND !strlen($recherche))
		return array("''" /* as points */, /* where */ '1');

	// Premier passage : chercher eventuel un cache des donnees sur le disque
	if (!$cache[$recherche]['hash']) {
		$dircache = _DIR_CACHE.creer_repertoire(_DIR_CACHE,'rech');
		$fcache[$recherche] =
			$dircache.'rech_'.substr(md5($recherche),0,10).'.txt';
		if (lire_fichier($fcache[$recherche], $contenu))
			$cache[$recherche] = @unserialize($contenu);
	}

	// si on n'a pas encore traite les donnees dans une boucle precedente
	if (!$cache[$recherche]['index']) {
		if (!$cache[$recherche]['hash'])
			$cache[$recherche]['hash'] = requete_hash($recherche);
		list($hash_recherche, $hash_recherche_strict)
			= $cache[$recherche]['hash'];

		$select = "SUM( index.points * ( 1 +99 * ( index.hash
IN ($hash_recherche_strict) ) ) )";
		$where = calcul_mysql_in('hash',$hash_recherche);

		$cache[$recherche]['index'] = array($select,$where);

		// ecrire le cache de la recherche sur le disque
		ecrire_fichier($fcache[$recherche], serialize($cache[$recherche]));
		// purger le petit cache
		nettoyer_petit_cache('rech', 300);
	}
	return $cache[$recherche]['index'];
}

?>