<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2010                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('action/editer_breve');


/**
 * Interface C(r)UD
 */
function crud_breves_create_dist($dummy,$set=null){
	if ($id = insert_breve($set['id_rubrique']))
		list($e,$ok) = revisions_breves($id,$set);
	else
		$e = _T('crud:erreur_creation',array('objet'=>'breve'));
	return array('success'=>$e?false:true,'message'=>$e?$e:$ok,'result'=>array('id'=>$id));
}
function crud_breves_update_dist($id,$set=null){
	list($e,$ok) = revisions_breves($id,$set);
	return array('success'=>$e?false:true,'message'=>$e?$e:$ok,'result'=>array('id'=>$id));
}
function crud_breves_delete_dist($id){
	list($e,$ok) = revisions_breves($id,array('statut'=>'poubelle'));
	return array('success'=>$e?false:true,'message'=>$e?$e:$ok,'result'=>array('id'=>$id));
}

?>