<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2006                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

//
// Faire l'encodage d'une video en .flv
//

function inc_encodage_dist($source,$attente){
	  return encodage($source,$attente);
}

function encodage($source,$video_attente){
	include_spip('inc/documents');
	$chemin = get_spip_doc($source['fichier']);

	spip_log("encodage de $chemin","spipmotion");
	
	// Calcul de la hauteur en fonction de la largeur souhaitée et de la taille de la video originale	
	$width = $source['largeur'];
	$height = $source['hauteur'];
	$width_finale = lire_config('spipmotion/width') ? lire_config('spipmotion/width') : 480;
	
	if($width<$width_finale){
		$width_finale = $width;
		$height_finale = $height;
	}
	else{
		$height_finale = $source['hauteur']/($source['largeur']/$width_finale);
	}
	
	spip_log("document original ($chemin) = $width/$height - document final = $width_finale/$height_finale");
	
	$fichier = basename($source['fichier']);
	$string = "$fichier-$width-$height";
	$query = md5($string);
	$dossier = _DIR_VAR;
	$fichier_temp = "$dossier$query.flv";
	spip_log("le nom temporaire durant l'encodage est $fichier_temp");
	
	$encodageflv = find_in_path('script_bash/spipmotion.sh').' --e '.$chemin.' --s '.$fichier_temp.' --size '.$width_finale.'x'.$height_finale.' --bitrate '.lire_config("spipmotion/bitrate","448").' --audiobitrate '.lire_config("spipmotion/bitrate_audio","64").' --audiofreq '. lire_config("spipmotion/frequence_audio","22050").' --fps '.lire_config("spipmotion/fps","15").' --p '.lire_config("spipmotion/chemin","/usr/local/bin/ffmpeg");
	spip_log("$encodageflv");
	$lancement_encodage = shell_exec($encodageflv);
	spip_log($lancement_encodage);
	spip_log("l'encodage est terminé");
	
	$fichier_final = substr($fichier,0,-4).'.flv';
	
	$mode = 'document';
	$invalider = true;
	
	$attente = sql_fetsel("*","spip_spipmotion_attentes","id_spipmotion_attente=$video_attente");
	$type_doc = $attente['objet'];
	$id_objet = $attente['id_objet'];
	
	$ajouter_documents = charger_fonction('ajouter_documents', 'inc');
	$x = $ajouter_documents($fichier_temp, $fichier_final, $type_doc, $id_objet, $mode, $id_document, $actifs);
	spip_log("on ajoute le nouveau fichier qui devient $x");
	unlink($fichier_temp);
	
	sql_updateq("spip_spipmotion_attentes",array('encode'=>'oui'),"id_spipmotion_attente=$video_attente");
	// la récupération des infos et du logo est faite automatiquement par le pipeline post-edition
	
		if ($invalider) {
			include_spip('inc/invalideur');
			suivre_invalideur("0",true);
			spip_log('invalider', 'spipmotion');
		}
	return;
}
?>