<?php
if (!defined("_ECRIRE_INC_VERSION")) return;


function boussole_lister_caches() {
	$caches = array();

	$dir_caches = _DIR_VAR . 'cache-boussoles';
	if ($fichiers_cache = glob($dir_caches . "/boussole*.xml")) {
		include_spip('inc/config');
		$boussoles = lire_config('boussole/serveur/boussoles_disponibles');
		$boussoles = pipeline('declarer_boussoles', $boussoles);

		foreach ($fichiers_cache as $_fichier) {
			$cache = array();
			$cache['fichier'] = $_fichier;
			$cache['nom'] = basename($_fichier);
			$cache['maj'] = date('Y-m-d H:i:s', filemtime($_fichier));

			$cache['sha'] = '';
			$cache['plugin'] = '';
			$cache['alias'] = '';
			$cache['manuelle'] = false;

			lire_fichier($_fichier, $contenu);
			$convertir = charger_fonction('simplexml_to_array', 'inc');
			$converti = $convertir(simplexml_load_string($contenu), false);
			$tableau = $converti['root'];
			if ($cache['nom'] == 'boussoles.xml') {
				// C'est le cache qui liste les boussoles hébergées
				$cache['description'] = _T('boussole:info_cache_boussoles');
				if  (isset($tableau['name'])
				AND ($tableau['name'] == 'boussoles')) {
					$cache['sha'] = $tableau['attributes']['sha'];
				}
			}
			else {
				// C'est le cache d'une boussole hébergée
				$alias_boussole = str_replace('boussole-', '', basename($_fichier, '.xml'));
				$cache['alias'] = $alias_boussole;
				$cache['description'] = _T('boussole:info_cache_boussole', array('boussole' => $alias_boussole));
				if  (isset($tableau['name'])
				AND ($tableau['name'] == 'boussole')) {
					$cache['sha'] = $tableau['attributes']['sha'];
					$cache['nom'] .= " ({$tableau['attributes']['version']})";
				}
				if (isset($boussoles[$alias_boussole]['prefixe'])
				AND ($boussoles[$alias_boussole]['prefixe'])) {
					// Boussole utilisant un plugin
					$informer = charger_fonction('informer_plugin', 'inc');
					$infos = $informer($boussoles[$alias_boussole]['prefixe']);
					if ($infos)
						$cache['plugin'] = "{$infos['nom']} ({$boussoles[$alias_boussole]['prefixe']}/{$infos['version']})";
				}
				else {
					// Boussole n'utilisant pas un plugin, nommée boussole manuelle
					$cache['manuelle'] = true;
					$cache['plugin'] = _T('boussole:info_boussole_manuelle');

					// Ajout de la version dans le fichier XML source de la boussole
					$fichier_source = find_in_path("boussole_traduite-${alias_boussole}.xml");
					lire_fichier($fichier_source, $contenu_source);
					$tableau_source = $convertir(simplexml_load_string($contenu_source), false);
					$tableau_source = $tableau_source['root'];
					if  (isset($tableau_source['name'])
					AND ($tableau_source['name'] == 'boussole')) {
						$cache['plugin'] .= " ({$tableau_source['attributes']['version']})";
					}
				}
			}
			$caches[] = $cache;
		}
	}

	return $caches;
}


function boussole_compteur_hebergement() {
	include_spip('inc/config');
	$boussoles = lire_config('boussole/serveur/boussoles_disponibles');
	$boussoles = pipeline('declarer_boussoles', $boussoles);

	return count($boussoles);
}
?>
