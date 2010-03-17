<?php

// S�curit�
if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Lister les noisettes disponibles dans les dossiers noisettes/
 *
 * @staticvar array $liste_noisettes
 * @param text $type
 * @param bool $informer
 * @return array
 */
function noizetier_lister_noisettes($type='tout',$informer=true){
	static $liste_noisettes = null;

	if (is_null($liste_noisettes[$type][$informer])){
		$liste_noisettes[$type][$informer] = array();
		
		// Si $type='tout' on recherche toutes les noisettes sinon seules celles qui commencent par $type
		if ($type=='tout')
			$prefix = '';
		else
			$prefix = $type.'-';
		
		$match = "[^-]*[.]html$";

		// lister les noisettes disponibles
		$liste = find_all_in_path('noisettes/', $prefix.$match);
		if (count($liste)){
			foreach($liste as $squelette=>$chemin) {
				$noisette = preg_replace(',[.]html$,i', '', $squelette);
				$dossier = str_replace($squelette, '', $chemin);
				// On ne garde que les squelettes ayant un XML de config
				if (file_exists("$dossier$noisette.xml")
					AND (
						$infos_noisette = !$informer OR ($infos_noisette = noizetier_charger_infos_noisette($dossier.$noisette))
					)){
					$liste_noisettes[$type][$informer][$noisette] = $infos_noisette;
				}
			}
		}
	}
	return $liste_noisettes[$type][$informer];
}

/**
 * Decrire une noisette
 *
 * @staticvar array $infos
 * @param string $noisette
 * @return array
 */
function noizetier_informer_noisette($noisette){
	static $infos = array();
	if (!isset($infos[$noisette])){
		$fichier = find_in_path("noisettes/$noisette.html");
		$infos[$noisette] = noizetier_charger_infos_noisette($fichier);
	}
	return $infos[$noisette];
}

/**
 * Charger les informations contenues dans le xml d'une noisette
 *
 * @param string $noisette
 * @param string $info
 * @return array
 */
function noizetier_charger_infos_noisette($noisette, $info=""){
		// on peut appeler avec le nom du squelette
		$fichier = preg_replace(',[.]html$,i','',$noisette).".xml";
		include_spip('inc/xml');
		include_spip('inc/texte');
		$infos_noisette = array();
		if ($xml = spip_xml_load($fichier, false)){
			if (count($xml['noisette'])){
				$xml = reset($xml['noisette']);
				$infos_noisette['nom'] = _T_ou_typo(spip_xml_aplatit($xml['nom']));
				$infos_noisette['description'] = isset($xml['description']) ? _T_ou_typo(spip_xml_aplatit($xml['description'])) : '';
				$infos_noisette['icon'] = isset($xml['icon']) ? find_in_path(reset($xml['icon'])) : '';
				// D�composition des param�tres
				$infos_noisette['parametres'] = array();
				if (spip_xml_match_nodes(',^parametre,', $xml, $parametres)){
					foreach (array_keys($parametres) as $parametre){
						list($balise, $attributs) = spip_xml_decompose_tag($parametre);
						$infos_noisette['parametres'][$attributs['nom']] = array(
							'label' => $attributs['label'] ? _T($attributs['label']) : $attributs['nom'],
							'obligatoire' => $attributs['obligatoire'] == 'oui' ? true : false,
							'saisie' => $attributs['saisie'],
							'defaut' => $attributs['defaut']
						);
					}
				}
			}
		}
		if (!$info)
			return $infos_noisette;
		else 
			return isset($infos_noisette[$info]) ? $infos_noisette[$info] : "";
}

/**
 * Lister les pages pouvant recevoir des noisettes
 * Par d�faut, cette liste est bas�e sur le contenu du r�pertoire contenu/
 * Le tableau de r�sultats peut-�tre modifi� via le pipeline noizetier_lister_pages.
 *
 * @staticvar array $liste_pages
 * @return array
 */
function noizetier_lister_pages(){
	static $liste_pages = null;

	if (is_null($liste_pages)){
		$liste_pages = array();
		$match = ".+[.]html$";

		// lister les fonds disponibles dans le r�pertoire contenu
		$liste = find_all_in_path('contenu/', $match);
		if (count($liste)){
			foreach($liste as $squelette=>$chemin) {
				$page = preg_replace(',[.]html$,i', '', $squelette);
				$dossier = str_replace($squelette, '', $chemin);
				// Les �l�ments situ�s dans prive/contenu sont �cart�s
				if (substr($dossier,-14)!='prive/contenu/')
					$liste_pages[$page] = noizetier_charger_infos_page($dossier,$page);
			}
		}
		$liste_pages = pipeline('noizetier_lister_pages',$liste_pages);
	}
	return $liste_pages;
}

/**
 * Charger les informations d'une page, contenues dans un xml de config s'il existe
 *
 * @param string $dossier
 * @param string $page
 * @param string $info
 * @return array
 */
function noizetier_charger_infos_page($dossier,$page, $info=""){
		// on peut appeler avec le nom du squelette
		$page = preg_replace(',[.]html$,i','',$page);
		
		// On autorise le fait que le fichier xml ne soit pas dans le m�me plugin que le fichier .html
		// Au cas o� le fichier .html soit surcharg� sans que le fichier .xml ne le soit
		$fichier = find_in_path("contenu/$page.xml");
		
		include_spip('inc/xml');
		include_spip('inc/texte');
		$infos_page = array();
		// S'il existe un fichier xml de configuration (s'il s'agit d'une composition on utilise l'info de la composition)
		if (file_exists($fichier) AND $xml = spip_xml_load($fichier, false) AND count($xml['page']))
			$xml = reset($xml['page']);
		elseif (file_exists($fichier) AND $xml = spip_xml_load($fichier, false) AND count($xml['composition']))
			$xml = reset($xml['composition']);
		else
			$xml = '';
		if ($xml != '') {
			$infos_page['nom'] = _T_ou_typo(spip_xml_aplatit($xml['nom']));
			$infos_page['description'] = isset($xml['description']) ? _T_ou_typo(spip_xml_aplatit($xml['description'])) : '';
			$infos_page['icon'] = isset($xml['icon']) ? find_in_path(reset($xml['icon'])) : '';
			// D�composition des blocs
			if (spip_xml_match_nodes(',^bloc,', $xml, $blocs)){
				$infos_page['blocs'] = array();
				foreach (array_keys($bloc) as $bloc){
					list($balise, $attributs) = spip_xml_decompose_tag($bloc);
					$infos_page['blocs'][$attributs['id']] = array(
						'nom' => $attributs['nom'] ? _T($attributs['nom']) : $attributs['id'],
						'icon' => isset($attributs['icon']) ? find_in_path(reset($attributs['icon'])) : '',
						'description' => $attributs['description']
					);
				}
			}
		}
		// S'il n'y a pas de fichier XML de configuration
		else {
			$infos_page['nom'] = $page;
			$infos_page['icon'] = find_in_path('img/ic_page.png');
		}
		
		// Si les blocs n'ont pas �t� d�finis, on applique les blocs par d�faut
		if (!isset($infos_page['blocs']))
			$infos_page['blocs'] = noizetier_blocs_defaut();
		
		// On renvoie les infos
		if (!$info)
			return $infos_page;
		else 
			return isset($infos_page[$info]) ? $infos_page[$info] : "";
}

/**
 * Charger les informations d'une page, contenues dans un xml de config s'il existe
 * La liste des blocs par d�faut d'une page peut �tre modifi�e via le pipeline noizetier_blocs_defaut.
 *
 * @staticvar array $blocs_defaut
 * @return array
 */
function noizetier_blocs_defaut(){
	static $blocs_defaut = null;

	if (is_null($blocs_defaut)){
	$blocs_defaut = array (
		'contenu' => array(
			'nom' => _T('noizetier:nom_bloc_contenu'),
			'description' => _T('noizetier:description_bloc_contenu'),
			'icon' => find_in_path('img/ic_bloc_contenu.png')
			),
		'navigation' => array(
			'nom' => _T('noizetier:nom_bloc_navigation'),
			'description' => _T('noizetier:description_bloc_navigation'),
			'icon' => find_in_path('img/ic_bloc_navigation.png')
			),
		'extra' => array(
			'nom' => _T('noizetier:nom_bloc_extra'),
			'description' => _T('noizetier:description_bloc_extra'),
			'icon' => find_in_path('img/ic_bloc_extra.png')
			),
	);
	$blocs_defaut = pipeline('noizetier_blocs_defaut',$blocs_defaut);
	}
	return $blocs_defaut;
}

/**
 * Supprime de spip_noisettes les noisettes li�es � une page
 *
 * @param text $page
 * 
 */
function supprimer_noisettes_page_noizetier($page) {
	$type_compo = explode ('-',$page,2);
	$type = $type_compo[0];
	$page = $type_compo[1];
	
	sql_delete('spip_noisettes','type='.sql_quote($type).'and composition='.sql_quote($composition));

	// On invalide le cache
	include_spip('inc/invalideur');
	suivre_invalideur($page);
}

/**
 * Renvoie le type d'une page
 *
 * @param text $page
 * @return text
 */
function noizetier_page_type($page) {
	$type_compo = explode ('-',$page,2);
	return $type_compo[0];
}

/**
 * Renvoie la composition d'une page
 *
 * @param text $page
 * @return text
 */
function noizetier_page_composition($page) {
	$type_compo = explode ('-',$page,2);
	return $type_compo[1];
}

/**
 * Liste les blocs pour lesquels il y a des noisettes � ins�rer.
 *
 * @staticvar array $liste_blocs
 * @return array
 */
function noizetier_lister_blocs_avec_noisettes(){
	static $liste_blocs = null;
	
	if (is_null($liste_blocs)){
		$liste_blocs = array();
		$resultats = sql_allfetsel (
			"CONCAT(`bloc`,'/',`type`,'-',`composition`)",
			'spip_noisettes',
			'1',
			'`bloc`,`type`,`composition`'
		);
		foreach ($resultats as $res) {
			$res = array_values($res);
			if (substr($res[0],-1)=='-')
				$liste_blocs[] = substr($res[0],0,-1);
			else
				$liste_blocs[] = $res[0];
		}
	}
	
	return $liste_blocs;
}



?>
