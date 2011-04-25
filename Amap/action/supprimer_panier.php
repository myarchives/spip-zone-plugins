<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_supprimer_panier_dist() {
	$securiser_action = charger_fonction('securiser_action', 'inc');
	$arg = $securiser_action();

	if (!preg_match(",^(\d+)$,", $arg, $r)) {
		 spip_log("action_supprimer_panier_dist $arg pas compris");
	} else {
		action_supprimer_panier_post($r[1]);
	}
}

function action_supprimer_panier_post($id_panier) {
	sql_delete("spip_paniers", "id_panier=" . sql_quote($id_panier));

	include_spip('inc/invalideur');
	suivre_invalideur("id='id_panier/$id_panier'");
}
?>
