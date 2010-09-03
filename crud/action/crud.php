<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2009                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * $crud = charger_fonction('crud','action');
 * $crud('create','articles',null,array('id_rubrique'=>23));
 * $crud('update','rubriques',12,array('titre'=>'Super !'));
 * $crud('delete','syndic',5);
 *
 *
 * @param string $action
 *  create, update, delete
 * @param $table
 *  nom court de la table (articles, rubriques, syndic, ...)
 * @param int/string $id
 *  valeur de la cle pour update/delete, inutilise pour la creation
 * @param array $args
 *  liste des valeurs a affecter sous forme champ=>valeur
 *  ou conditions du where pour la lecture
 * @return array
 *  ($id,$ok,$erreur)
 */
function action_crud_dist($action=null,$table=null,$id=null,$args = array()){
	// si pas d'action fournie en arg, c'est un appel par url
	// avec un arg signe, qu'on decode
	// et un $args en _request
	if (is_null($action)){
		$securiser_action = charger_fonction('securiser_action','inc');
		$arg = $securiser_action();
		list($action,$table,$id) = explode('-',$arg);
		$args = _request('args');
	}

	$ok = $er = "";
	if (!in_array($action,array('create','update','delete'))){
		$er = _L("CRUD action $action erronee");
	}
	elseif (!preg_match(',^\w+$,',$table))
		$er = _L("CRUD table $table erronee");
	elseif(!include_spip("crud/$table")
		// tolerer un appel avec type plutot que table
		AND (!$table = table_objet($table) OR !include_spip("crud/$table")))
		$er = _L("CRUD table $table inconnue");
	elseif (!$f=charger_fonction("{$table}_{$action}","crud",true)
	  AND !$f=charger_fonction("{$action}","crud",true))
		$er = _L("CRUD action $action inconnue pour table $table");
	if ($er)
		return array($id,'',$er);

	// ok ici tout va bien !
	$res = $f($id,$args);

	// TODO : verifier que l'objet a ete supprime physiquement, et dans ce cas
	// trigger le pipeline de suppression des objets lies

	// interpretons un peu le retour pour le mettre en forme :
	if ($res['success'] AND !$res['message'])
		$res['message'] = _L("ok");

	return $res;

}

?>