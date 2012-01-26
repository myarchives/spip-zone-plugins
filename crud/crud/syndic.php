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
include_spip('action/editer_site');

/**
 * Interface C(r)UD
 */
function crud_syndic_create_dist($dummy,$set=null){
	if ($id = insert_syndic($set['id_rubrique']))
		list($e,$ok) = revisions_sites($id,$set);
	else
		$e = _T('crud:erreur_creation',array('objet'=>'site'));
	return array('success'=>$e?false:true,'message'=>$e?$e:$ok,'result'=>array('id'=>$id));
}
function crud_syndic_update_dist($id,$set=null){
	list($e,$ok) = revisions_sites($id,$set);
	return array('success'=>$e?false:true,'message'=>$e?$e:$ok,'result'=>array('id'=>$id));
}
function crud_syndic_delete_dist($id){
	list($e,$ok) = revisions_sites($id,array('statut'=>'poubelle'));
	return array('success'=>$e?false:true,'message'=>$e?$e:$ok,'result'=>array('id'=>$id));
}

?>