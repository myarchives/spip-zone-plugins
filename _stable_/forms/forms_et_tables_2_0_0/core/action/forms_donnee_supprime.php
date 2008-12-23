<?php
/*
 * forms
 * Gestion de formulaires editables dynamiques
 *
 * Auteurs :
 * Antoine Pitrou
 * Cedric Morin
 * Renato
 * (c) 2005-2009 - Distribue sous licence GNU/GPL
 *
 */
include_spip('inc/forms');
include_spip('inc/autoriser');

function action_forms_donnee_supprime(){
	$securiser_action = charger_fonction('securiser_action','inc');
	$args = $securiser_action();

	list($id_form,$id_donnee) = explode(':',$args);
	$id_form = intval($id_form);
	$id_donnee = intval($id_donnee);
	if (autoriser('supprimer','donnee',$id_donnee,NULL,array('id_form'=>$id_form))){
		if (sql_delete("spip_forms_donnees","id_form=".intval($id_form)." AND id_donnee=".intval($id_donnee)))
			sql_delete("spip_forms_donnees_champs","id_donnee=".intval($id_donnee));
	}

}

?>