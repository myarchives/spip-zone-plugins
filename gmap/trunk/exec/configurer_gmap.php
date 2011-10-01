<?php
/*
 * Google Maps in SPIP plugin
 * Insertion de carte Google Maps sur les �l�ments SPIP
 *
 * Auteur :
 * Fabrice ALBERT
 * (c) 2009 - licence GNU/GPL
 *
 * Page de param�trage du plugin
 *
 */

include_spip('inc/presentation');
include_spip('inc/gmap_presentation');
include_spip('inc/gmap_config_utils');
include_spip('configuration/gmap_config_onglets');

if (!defined("_ECRIRE_INC_VERSION")) return;

// Choix de l'interface GIS
function gmap_formulaire_configuration_gis()
{
	$corps = "";
	
	// Texte explicatif
	$corps .= '
	<div class="texte"><p>'._T("gmap:configuration_gis_explic").'</p></div>';
	
	// Lire la configuration
	$apis = gmap_apis_connues();
	$apiSelected = gmap_lire_config('gmap_api', 'api', "gma3");

	// Param�trage de l'API utilis�e
	$corps .= '
		<div class="config_group">
			<select name="api_code" id="api_code" size="1">';
	foreach ($apis as $api => $infos)
	{
		$corps .= '
				<option value="'.$api.'"'.(!strcmp($apiSelected, $api) ? ' selected="selected"' : '').'>'.$infos['name'].'</option>';
	}
	$corps .= '
			</select>
			<p class="texte" id="api_code_desc"></p>
		</div>'."\n";

	// Script de mise � jour des explications
	$corps .= '<script type="text/javascript">'."\n".'	//<![CDATA['."\n";
	$corps .= '
function updateAPIDescription()
{
	var api = jQuery("#api_code").val();
	var desc = "";
	switch (api)
	{'."\n";
	foreach ($apis as $api => $infos)
	{
		$corps .= '
	case "'.$api.'" : desc = "'.$infos['explic'].'"; break;'."\n";
	}
	$corps .= '	default : desc = "'._T('gmap:gis_api_none_desc').'"; break;
	}
	jQuery("#api_code_desc").html(desc);
}
jQuery("#api_code").change(function() { updateAPIDescription(); });
jQuery(document).ready(function() { updateAPIDescription(); });
';
	$corps .= '	//]]>'."\n".'</script>'."\n";
		
	return gmap_formulaire_submit('configuration_gis', $corps, find_in_path('images/logo-config-gis.png'), _T('gmap:configuration_gis'));
}
function gmap_formulaire_configuration_gis_action()
{
	gmap_ecrire_config('gmap_api', 'api', _request('api_code'));
}

// Page de configuration
function exec_configurer_gmap_dist($class = null)
{
	// v�rifier une nouvelle fois les autorisations
	if (!autoriser('webmestre'))
	{
		include_spip('inc/minipres');
		echo minipres();
		exit;
	}
	
	// Traitements du formulaire post pour ce qui n'est pas en Ajax
	if (_request('config') == 'configuration_gis')
		gmap_formulaire_configuration_gis_action();
	$api = gmap_lire_config('gmap_api', 'api', "gma3");
	if (_request('config') == 'configuration_api')
	{
		$faire_api = charger_fonction('faire_api', 'configuration');
		$faire_api();
	}
	
	// Pipeline pour customiser
	pipeline('exec_init',array('args'=>array('exec'=>'configurer_gmap'),'data'=>''));
	
	// affichages de SPIP
	$commencer_page = charger_fonction('commencer_page', 'inc');
	echo $commencer_page(_T('gmap:configuration_titre'), 'configurer_gmap', 'configurer_gmap');
	echo "<br /><br /><br />\n";
	$logo = '<img src="'.find_in_path('images/logo-config-title-big.png').'" alt="" style="vertical-align: center" />';
	echo gros_titre(_T('gmap:configuration_titre'), $logo, false);
	echo barre_onglets("configurer_gmap", "cg_main");
	echo debut_gauche('', true);
	echo pipeline('affiche_gauche',array('args'=>array('exec'=>'configurer_gmap'),'data'=>''));
	echo creer_colonne_droite('', true);
	echo pipeline('affiche_droite',array('args'=>array('exec'=>'configurer_gmap'),'data'=>''));
	echo debut_droite("", true);
	
	// Configuration de l'API utilis�e
	// Cette partie n'est pas en ajax, parce que les autres param�tres en d�pendent
	echo gmap_formulaire_configuration_gis();
	
	// Selon l'API, autre param�trages
	// Cette partie n'est pas en ajax, parce que les autres param�tres en d�pendent
	$api_conf = charger_fonction('api', 'configuration');
	echo $api_conf();

	// Configuration des rubriques g�olocalisables
	$rubgeo = charger_fonction('rubgeo', 'configuration');
	echo $rubgeo();

	// Configuration des rubriques g�olocalisables
	$eparams = charger_fonction('editparams', 'configuration');
	echo $eparams();

	// pied de page SPIP
	echo fin_gauche() . fin_page();
}

?>
