<?php 

// inc/spiplistes_pipeline_ajouter_onglets.php

// $LastChangedRevision$
// $LastChangedBy$
// $LastChangedDate$

/*
	SPIP-Listes
	
	Ajoute l'onglet de configuration SPIP-Listes
	
	Nota: si mise � jour du plugin, il faut d�sactiver/r�activer le plugin
	pour voir appara�tre l'onglet
	
	From: SPIP-Listes-V, http://www.quesaco.org/
*/

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/spiplistes_api_globales');


// pipeline (plugin.xml)
function spiplistes_ajouter_onglets ($flux) {

	global $connect_statut
		, $connect_toutes_rubriques
		;

	// seuls les super-admins ont acc�s au bouton
	if(
			$connect_statut 
		&& $connect_toutes_rubriques
		&& ($flux['args'] == 'configuration')
	) {
		$flux['data']['spiplistes'] = new Bouton( 
			_DIR_PLUGIN_SPIPLISTES_IMG_PACK."courriers_listes-24.png"
			, _T("spiplistes:listes_de_diffusion_")
			, generer_url_ecrire(_SPIPLISTES_EXEC_CONFIGURE)
			)
			;
	}
	return ($flux);
}

?>