<?php
	/**
	* Plugin Association
	*
	* Copyright (c) 2007
	* Bernard Blazin & Fran�ois de Montlivault
	* http://www.plugandspip.com 
	* Ce programme est un logiciel libre distribue sous licence GNU/GPL.
	* Pour plus de details voir le fichier COPYING.txt.
	*  
	**/
if (!defined("_ECRIRE_INC_VERSION")) return;

function action_supprimer_prets() {
		
	$securiser_action = charger_fonction('securiser_action', 'inc');
	$arg = $securiser_action();
	if (!preg_match('/^(\d+)\D(\d+)/', $arg, $r))
		spip_log("action_supprimer_prets: $arg incompris");
	else {
		list(,$id_pret,$id_ressource) = $r;
		sql_delete('spip_asso_prets', "id_pret=$id_pret" );
		sql_delete('spip_asso_comptes', "id_journal=$id_pret" );
		sql_updateq('spip_asso_ressources',
			array('statut'=>'ok'),
			"id_ressource=" . $id_ressource );
	}
}

?>
