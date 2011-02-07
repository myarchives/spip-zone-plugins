<?php

function autobr_pre_typo($flux) {
	// Laisser les formulaires
	if(strpos($flux, '<input')!==false) return $flux;
	// Bug du filtre post_autobr sur les echappements :-(
	$flux = str_replace('base64', '@ABR@', $flux);
	if(!defined('_CS_AUTOBR_RACC'))
		$flux = post_autobr($flux, '<br />');
	else while ($fin = strpos($flux, '</alinea>')) {
			$zone = substr($flux, 0, $fin);
			if(($deb = strpos($zone, '<alinea>'))!==false)	$zone = substr($zone, $deb + 8);
			$flux = substr($flux, 0, $deb) . post_autobr(trim($zone), '<br />') . substr($flux, $fin + strlen('</alinea>'));
		}
	return str_replace('@ABR@', 'base64', $flux);
}

if(defined('_CS_AUTOBR_RACC')) {
	// liste des nouveaux raccourcis ajoutes par l'outil
	// si cette fonction n'existe pas, le plugin cherche alors  _T('couteauprive:un_outil:aide');
	function autobr_raccourcis() {
		return _T('couteauprive:autobr_racc');
	}
}

function autobr_PP_icones($flux) {
	if(defined('_CS_AUTOBR_RACC')) $flux['autobr'] = 'autobr.png';
	return $flux;
}

function autobr_CS_pre_charger($flux) {
	if(!defined('_CS_AUTOBR_RACC')) return $flux;
	$r = array(array(
		"id" => 'autobr',
		"name" => _T('couteau:pp_autobr'),
		"className" => 'autobr',
		"openWith"    => "\n&lt;alinea&gt;", 
		"closeWith"   => "&lt;/alinea&gt;\n",
		"selectionType" => "line",
		"display" => true));
	foreach(cs_pp_liste_barres('autobr') as $b)
		$flux[$b] = isset($flux[$b])?array_merge($flux[$b], $r):$r;
	return $flux;
}

?>