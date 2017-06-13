<?php
/**
* Plugin Analyclick
*
* @author: Jean-Marc Viglino (ign.fr) V0.1
* @author: Pierre KUHN V1
*
* Copyright (c) 2011-12
* Logiciel distribue sous licence GPL.
*
**/

if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

function action_anaclic_config_dist() 
{	$securiser_action = charger_fonction('securiser_action', 'inc');
	$arg = $securiser_action();

	if (autoriser('configurer','anaclic')) 
	{	// Modifier le delais
 		if (isset($_POST['modifier']))
		{	$val = intVal(_request('delai'));
			if (!$val && _request('delai') != '0') $val = 3600;
			ecrire_meta('anaclic_delai',$val);
 			ecrire_metas();
 		}
	}
}


