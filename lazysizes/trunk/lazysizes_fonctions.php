<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}



/*
 * function lazysizes_addons
 *
 */
function lazysizes_addons() {
	$lazy_addons = array(
		'artdirect' => 'ls.artdirect',
		'aspectratio' => 'ls.aspectratio',
		'attrchange' => 'ls.attrchange',
		'bgset' => 'ls.bgset',
		'blur-up' => 'ls.blur-up',
		'custommedia' => 'ls.custommedia',
		'fix-io-sizes' => 'fix-ios-sizes',
		'include' => 'ls.include',
		'noscript' => 'ls.noscript',
		'object-fit' => 'ls.object-fit',
		'optimumx' => 'ls.optimumx',
		'parent-fit' => 'ls.parent-fit',
		'print' => 'ls.print',
		'progressive' => 'ls.progressive',
		'respimg' => 'ls.respimg',
		'rias' => 'ls.rias',
		'static-gecko-picture' => 'ls.static-gecko-picture',
		'twitter' => 'ls.twitter',
		'unload' => 'ls.unload',
		'unveilhooks' => 'ls.unveilhooks',
		'video-embed' => 'ls.video-embed'
	);

	return $lazy_addons;
}

function lazysizes_insertion_js($flux = ''){
	include_spip('inc/config');
	$lazy_cfg = lire_config('lazysizes');
	$js_init_options = produire_fond_statique('lazysizes_config.js',$lazy_cfg) ;
	$flux .= "<script type='text/javascript' src='$js_init_options' ></script>\n";;

	// Addons
	$ls_addons = lazysizes_addons();

	if (is_array($lazy_cfg['addons'])) {
		foreach($lazy_cfg['addons'] as $addon => $state){
			if(array_key_exists($addon, $ls_addons)){
				$file = timestamp(find_in_path('javascript/addons/'.$addon.'/'.$ls_addons[$addon].'.js'));
				$flux .= "<script type='text/javascript' src='$file' ></script>\n";
			}
		}
	}

	$lazysizes = timestamp(find_in_path('javascript/lazysizes.js'));
	$flux .= "<script type='text/javascript' src='$lazysizes' ></script>\n";


	$flux .= "<script type='text/javascript'>window.lazySizes.init();</script>";

	return $flux;
}
/*
 * lazysizes_string2array
 *
 *  Pour ne pas necessiter Saisie juste pour saisies_chaine2tableau
 * ne gère que des cle|valeur 
 *
 * @param string $string
 *   cle|valeur
 *   cle|valeur
 */
function lazysizes_string2array($string){
	// récupérer les lignes
	$res = array();
	$lignes = explode("\n",$string);
	foreach($lignes as $i => $ligne){
		list($cle,$valeur) = explode('|', $ligne, 2);
		$res[$cle] = trim($valeur);
	}
 	return $res;
}

/**
 * filtre_unlazy_dist
 *
 * supprime les data-src des modèles documents pour rétablir le src du $fichier
 * utilisé dans les gabarits de newsletter
 *
 */
function filtre_unlazy_dist($flux){

	if(preg_match_all("/(<img\ [^>]*>)/",$flux,$matches)){
		foreach($matches[1] as $img){
			if(null !== extraire_attribut($img,'data-src')){
				$src = ' src="'.extraire_attribut($img,'data-src').'"';
				( extraire_attribut($img,'alt') ) ? $alt = ' alt="'.extraire_attribut($img,'alt').'"' : $alt = null;
				( extraire_attribut($img,'width') ) ? $width = ' width="'.extraire_attribut($img,'width').'"' : $width = null ;
				( extraire_attribut($img,'height') ) ? $height = ' height="'.extraire_attribut($img,'height').'"' : $height = null;

				$flux = str_replace($img,'<img'.$src.$alt.$width.$height.'>',$flux);
			}
		}
	}

	return $flux;
}
/*
 * function titrer_document
 *
 * transforme un nom de fichier en chaine lisible
 * tire de la fonction ajouter_document du core
 * https://zone.spip.org/trac/spip-zone/browser/_core_/plugins/medias/action/ajouter_documents.php#L149
 *
 * @param $fichier
 * @return string
 */

function titrer_document($fichier) {
	$titre = substr($fichier, 0, strrpos($fichier, '.')); // Enlever l'extension du nom du fichier
	$titre = preg_replace(',[[:punct:][:space:]]+,u', ' ', $titre);
	return preg_replace(',\.([^.]+)$,', '', $titre);
}
