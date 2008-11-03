<?php
/*
 * Spip Geomap/GoogleMap plugin
 * Insetar google maps en SPIP
 *
 * Autores :
 * Horacio Gonzalez, Berio Molina
 * (c) 2007 - Distribudo baixo licencia GNU/GPL
 *
 */
include_spip('inc/distant');

function inc_geomap_script_init_dist(){
	static $deja_insere = false;
	if ($deja_insere) return ""; 
	$deja_insere = true;
	$config = lire_meta('geomap_googlemapkey');
	$version = lire_meta('geomap_googlemapversion');
	$geomap = compacte_js(find_in_path('js/geomap.js'));
	$gmap_script = compacte_js(recuperer_page('http://maps.google.com/maps?file=api&v='.$version.'&key='.$config.'&hl='.$GLOBALS['spip_lang']));
	$out = '
	<script type="text/javascript" src="'.$geomap.'"></script>
	<script type="application/javascript">'.$gmap_script.'</script>
	<script type="application/javascript" src="'._DIR_PLUGIN_GEOMAP.'js/customControls.js"></script>';
	return $out;
}

?>
