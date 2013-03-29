<?php
/**
 * Plugin Emballe Medias / Wrap medias
 *
 * Auteurs :
 * kent1 (kent1@arscenic.info)
 *
 * © 2008/2010 - Distribue sous licence GNU/GPL
 *
 * Action de changement d'url
 *
 **/

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Redirige uniquement vers la bonne url avec le bon type
 * @return
 */
function action_emballe_medias_changer_url_type_dist()
{
	$type = _request('em_changer_type');
	if($type == 'normal')
		$type = '';
	$redirect = rawurldecode(_request('redirect'));

	$redirect = parametre_url($redirect,'em_type',$type,'&');
	redirige_par_entete($redirect, true);
}

?>
