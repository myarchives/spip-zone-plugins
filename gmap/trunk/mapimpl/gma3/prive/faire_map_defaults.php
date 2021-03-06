<?php
/*
 * GMap plugin
 * Insertion de carte Google Maps sur les �l�ments SPIP
 *
 * Auteur :
 * Fabrice ALBERT
 * (c) 2011 - licence GNU/GPL
 *
 * Interface de configuration de l'interface pour Google Maps v3
 *
 * Usage :
 * $faire_map_defaults = charger_fonction("faire_map_defaults", "mapimpl/$api/prive");
 * $faire_map_defaults();
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/gmap_config_utils');

// Enregistrement des param�tres pass�s dans la requ�te
function mapimpl_gma3_prive_faire_map_defaults_dist($profile = 'interface')
{
	// Clefs d'acc�s aux valeurs enregistr�es
	if (!isset($profile))
		$profile = 'interface';
	$apiConfigKey = 'gmap_gma3_'.$profile;
	
	// Fonds de carte
	gmap_ecrire_config($apiConfigKey, 'type_carte_plan', ((_request('type_carte_plan') === "oui") ? "oui" : "non"));
	gmap_ecrire_config($apiConfigKey, 'type_carte_satellite', ((_request('type_carte_satellite') === "oui") ? "oui" : "non"));
	gmap_ecrire_config($apiConfigKey, 'type_carte_mixte', ((_request('type_carte_mixte') === "oui") ? "oui" : "non"));
	gmap_ecrire_config($apiConfigKey, 'type_carte_physic', ((_request('type_carte_physic') === "oui") ? "oui" : "non"));
	if (strlen(gmap_lire_config('gmap_api_gma3', 'key', "")) > 0)
		gmap_ecrire_config($apiConfigKey, 'type_carte_earth', ((_request('type_carte_earth') === "oui") ? "oui" : "non"));
	else
		gmap_ecrire_config($apiConfigKey, 'type_carte_earth', "non");
	gmap_ecrire_config($apiConfigKey, 'type_defaut', _request('type_carte_defaut'));

	// Choix du type de contr�les
	gmap_ecrire_config($apiConfigKey, 'types_control_style', _request('types_control_style'));
	gmap_ecrire_config($apiConfigKey, 'types_control_position', _request('types_control_position'));
//	gmap_ecrire_config($apiConfigKey, 'nav_control_style', _request('nav_control_style'));
//	gmap_ecrire_config($apiConfigKey, 'nav_control_position', _request('nav_control_position'));
	gmap_ecrire_config($apiConfigKey, 'zoom_control_style', _request('zoom_control_style'));
	gmap_ecrire_config($apiConfigKey, 'zoom_control_position', _request('zoom_control_position'));
	gmap_ecrire_config($apiConfigKey, 'pan_control_style', _request('pan_control_style'));
	gmap_ecrire_config($apiConfigKey, 'pan_control_position', _request('pan_control_position'));
	gmap_ecrire_config($apiConfigKey, 'scale_control_style', _request('scale_control_style'));
	gmap_ecrire_config($apiConfigKey, 'scale_control_position', _request('scale_control_position'));
	gmap_ecrire_config($apiConfigKey, 'streetview_control_style', _request('streetview_control_style'));
	gmap_ecrire_config($apiConfigKey, 'streetview_control_position', _request('streetview_control_position'));
	gmap_ecrire_config($apiConfigKey, 'rotate_control_style', _request('rotate_control_style'));
	gmap_ecrire_config($apiConfigKey, 'rotate_control_position', _request('rotate_control_position'));
	gmap_ecrire_config($apiConfigKey, 'overview_control_style', _request('overview_control_style'));
	
	// Param�tres
	gmap_ecrire_config($apiConfigKey, 'allow_dblclk_zoom', ((_request('allow_dblclk_zoom') === "oui") ? "oui" : "non"));
	gmap_ecrire_config($apiConfigKey, 'allow_map_dragging', ((_request('allow_map_dragging') === "oui") ? "oui" : "non"));
	gmap_ecrire_config($apiConfigKey, 'allow_wheel_zoom', ((_request('allow_wheel_zoom') === "oui") ? "oui" : "non"));
	gmap_ecrire_config($apiConfigKey, 'allow_keyboard', ((_request('allow_keyboard') === "oui") ? "oui" : "non"));
}

?>
