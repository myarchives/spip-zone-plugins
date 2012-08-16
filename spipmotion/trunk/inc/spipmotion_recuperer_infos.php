<?php
/**
 * SPIPmotion
 * Gestion de l'encodage et des métadonnées de vidéos directement dans spip
 *
 * Auteurs :
 * kent1 (http://www.kent1.info - kent1@arscenic.info)
 * 2008-2012 - Distribué sous licence GNU/GPL
 *
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

/**
 * Récupération des informations techniques du document audio ou video
 * 
 * Si on a un id_document (en premier argument) on enregistre en base dans cette fonction
 * Si on a seulement un chemin de fichier (en second argument), on retourne un tableau des metas
 * 
 * @param int/false $id_document 
 *   id_document sur lequel récupérer les informations
 * @param string/null $fichier 
 *   chemin du fichier à analyser si pas de id_document
 * @param bool $logo
 *   si true, récupère une vignette du document
 * @param bool $only_return
 * 	si true, on n'insère rien en base depuis cette fonction (devra être fait après)
 * @return array $infos 
 * 	 Un tableau des informations récupérées
 */
function inc_spipmotion_recuperer_infos($id_document=false,$fichier=null,$logo=false,$only_return=false){
	if((!intval($id_document) && !isset($fichier)) OR ($GLOBALS['meta']['spipmotion_casse'] == 'oui')){
		spip_log('SPIPMOTION est cassé','spipmotion');
		return false;
	}

	if(!isset($fichier)){
		spip_log("SPIPMOTION : recuperation des infos du document $id_document","spipmotion");
		include_spip('inc/documents');
		$document = sql_fetsel("*", "spip_documents","id_document=".intval($id_document));
		$chemin = $document['fichier'];
		$fichier = get_spip_doc($chemin);
		$extension = $document['extension'];
	}else{
		spip_log("SPIPMOTION : recuperation des infos du document $fichier","spipmotion");
		$extension = strtolower(array_pop(explode('.',basename($fichier))));
	}

	/**
	 * Si c'est un flv on lui applique les metadatas pour éviter les problèmes
	 * Si c'est un mov ou MP4 on applique qt-faststart
	 */
	if($extension == 'flv'){
		/**
		 * Inscrire les metadatas dans la video finale
		 * On utilise soit :
		 * -* flvtool++
		 * -* flvtool2
		 */
		if(isset($GLOBALS['spipmotion_metas']['spipmotion_flvtoolplus'])){
			$flvtoolplus = unserialize($GLOBALS['spipmotion_metas']['spipmotion_flvtoolplus']);
		}
		if(isset($GLOBALS['spipmotion_metas']['spipmotion_flvtool2'])){
			$flvtool2 = unserialize($GLOBALS['spipmotion_metas']['spipmotion_flvtool2']);
		}
		if($flvtoolplus['flvtoolplus']){
			$fichier_tmp = $fichier.'_tmp';
			$metadatas_flv = "flvtool++ $fichier $fichier_tmp";
			
		}else if($flvtool2['flvtool2']){
			$metadatas_flv = "flvtool2 -xUP $fichier";
		}
		if($metadatas_flv){
			exec($metadatas_flv,$retour,$retour_int);
		}
	}
	if(in_array($extension,array('mov','mp4','m4v')) && !$GLOBALS['meta']['spipmotion_qt-faststart_casse']){
		exec("qt-faststart $fichier $fichier._temp",$retour,$retour_int);
	}
	
	if(file_exists($fichier.'._tmp')){
		rename($fichier.'._tmp',$fichier);
	}
	if(file_exists($fichier.'._temp')){
		rename($fichier.'._temp',$fichier);
	}
	
	/**
	 * Récupération des métadonnées par mediainfo
	 */
	if(!$GLOBALS['meta']['spipmotion_mediainfo_casse']){
		$mediainfo = charger_fonction('spipmotion_mediainfo','inc');
		$infos = $mediainfo($fichier);
	}
	
	if(strlen($document['titre']) > 0){
		unset($infos['titre']);
	}
	if(strlen($document['descriptif']) > 0){
		unset($infos['descriptif']);
	}
	foreach($infos as $key => $val){
		if(!$val){
			unset($infos[$key]);
		}	
	}
	
	/**
	 * Si les champs sont vides, on ne les enregistre pas
	 * Par contre s'ils sont présents dans le $_POST ou $_GET,
	 * on les utilise (fin de conversion où on récupère le titre et autres infos du document original)
	 */
	foreach(array('titre','descriptif','credit') as $champ){
		if(!isset($infos[$champ]))
			$infos[$champ] = '';
		if(is_null($infos[$champ]) OR ($infos[$champ]=='')){
			if(_request($champ)){
				$infos[$champ] = _request($champ);
			}else {
				unset($infos[$champ]);	
			}
		}
	}
	$infos['taille'] = @intval(filesize($fichier));

	// Filesize tout seul est limité à 2Go
	// cf http://php.net/manual/fr/function.filesize.php#refsect1-function.filesize-returnvalues
	if($infos['taille'] == '2147483647'){
		$infos['taille'] = sprintf("%u", filesize($fichier));
	}
	
	if($logo){
		$recuperer_logo = charger_fonction("spipmotion_recuperer_logo","inc");
		$id_vignette = $recuperer_logo($id_document,2,$fichier,$infos,true);
		spip_log('l id vignette est '.$id_vignette);
		if(intval($id_vignette))
			$infos['id_vignette'] = $id_vignette;
	}else{
		spip_log('on ne récup pas de logo');
	}
	/**
	 * Si on a $only_return à true, on souhaite juste retourner les metas, sinon on les enregistre en base
	 * Utile pour metadatas/video par exemple
	 */
	if(!$only_return && (intval($id_document) && (count($infos) > 0))){
		foreach($infos as $champ=>$val){
			if($document[$champ] == $val)
				unset($infos[$champ]);
		}
		if(count($infos) > 0){
			include_spip('action/editer_document');
			document_modifier($id_document, $infos);
		}
		return true;
	}
	return $infos;
}
?>