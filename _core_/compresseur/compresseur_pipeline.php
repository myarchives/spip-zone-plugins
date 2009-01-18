<?php

function compresseur_header_prive($flux){
	include_spip('filtres/compresseur');
	return compacte_head($flux);
}

function compresseur_affiche_milieu($flux){

	if ($flux['args']['exec']=='config_fonctions'){
		$compresseur = charger_fonction('compresseur', 'configuration');
		$flux['data'] .= $compresseur(); // Compression http et compactages CSS ou JS
	}
	
	return $flux;
}

function compresseur_configurer_liste_metas($metas){
	$metas['auto_compress_js']='non';
	$metas['auto_compress_css']='non';
	return $metas;
}

?>