<?php

/** Recalcule sur chaque page (hors cache) 
*/
function geoportail_affichage_final($page)
{	// on regarde rapidement si la page inclus un geoportail
	if (strpos($page, '<!--_SPIP_GEOPORTAIL_')===FALSE) return $page;

	// Inclure le hash code de maniere dynamique
	charger_fonction('securiser_action','inc');
	$action = calculer_action_auteur('geoportail');

	// Version debug de l'API
	if ($GLOBALS['geoportail_debug']) $api = "http://depot.ign.fr/geoportail/api/js/1.2/lib/geoportal/lib/Geoportal.js";
	// Version locale de l'API
	else if ($GLOBALS['meta']['geoportail_js']) $api = find_in_path ("js/GeoportalExtended.js");
	// ...ou sur le site de l'API
	else $api = "http://api.ign.fr/geoportail/api/js/1.2/GeoportalExtended.js";
	
	$engine=
'<script>jQuery.geoportail.hash = "'.$action.'";</script>
<script language=javascript>jQuery(document).ready(	function() { jQuery.geoportail.initMap("'._DIR_PLUGIN_GEOPORTAIL.'"); });</script>

<!-- API Geoportail -->
<script type="text/javascript" src="'.$api.'">// <![CDATA[
    // ]]></script>
<script type="text/javascript" src="'._DIR_PLUGIN_GEOPORTAIL.'js/Layer/Locator.js">// <![CDATA[
    // ]]></script>
<script type="text/javascript" src="'._DIR_PLUGIN_GEOPORTAIL.'js/Format/Ceoconcept_rip.js">// <![CDATA[
    // ]]></script>
<script type="text/javascript" src="'._DIR_PLUGIN_GEOPORTAIL.'js/Layer/GXT.js">// <![CDATA[
    // ]]></script>
<script type="text/javascript" src="'._DIR_PLUGIN_GEOPORTAIL.'js/Popup/SpipPopup.js">// <![CDATA[
    // ]]></script>
    
<script src="http://api.ign.fr/geoportail/api?v=1.2-e&key='.$GLOBALS['meta']['geoportail_key'].'&includeEngine=false"></script>


<!-- OpenLayers styles : -->
<link id="__OpenLayersCss__" rel="stylesheet" type="text/css" href="http://api.ign.fr/geoportail/api/js/1.2/theme/default/style.css"/>
<link id="__FramedCloudOpenLayersCss__" rel="stylesheet" type="text/css" href="http://api.ign.fr/geoportail/api/js/1.2/theme/default/framedCloud.css"/>
<link id="__GeoportalCss__" rel="stylesheet" type="text/css" href="http://api.ign.fr/geoportail/api/js/1.2/theme/geoportal/style.css"/>
';
	if (strpos($page, '<!--_SPIP_GEOPORTAIL_YHOO-->'))
	{	$ykey = $GLOBALS['meta']['geoportail_yahoo_key'];
		if ($ykey) 
			$engine .= '<script src="http://api.maps.yahoo.com/ajaxymap?v=3.0&appid='.($ykey?$ykey:'TEST').'"></script>';
		else $engine .= '<script type="text/javascript">alert ("NO Yahoo Map key defined")</script>';
	}
	/*
	if (strpos($page, '<!--_SPIP_GEOPORTAIL_BING-->'))
	{	// $engine .= '<script src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=6.2&mkt=en-us"></script>';
	}
	*/
	if (strpos($page, '<!--_SPIP_GEOPORTAIL_GMAP-->'))
	{	$engine .= '<script src="http://maps.google.com/maps/api/js?v=3.2&sensor=false"></script>'
				.'<link id="__GoogleOpenLayersCss__" rel="stylesheet" type="text/css" href="http://api.ign.fr/geoportail/api/js/1.2/theme/default/google.css"/>';
	}
		
	// Inclure l'API dans le Header
	return preg_replace('/<!--_GEOPORTAIL_HEADER_-->/', $engine, $page, 1);
}

?>