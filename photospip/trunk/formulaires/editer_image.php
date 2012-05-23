<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/actions');
include_spip('inc/autoriser');
include_spip('inc/documents');
include_spip('inc/filtres_images');
include_spip('photospip_fonctions');

function formulaires_editer_image_charger_dist($id_document='new', $retour=''){
	$valeurs = array();
	$id_document = sql_getfetsel('id_document','spip_documents','id_document='.intval($id_document));
	$valeurs['id_document'] = $id_document;

	if(!$id_document){
		$valeurs['editable'] = false;
		$valeurs['message_erreur'] = _T('phpotospip:erreur_doc_numero');
		return $valeurs;
	}
	
	$limite = lire_config('photospip/limite_version',1000000);
	$nb_versions = sql_countsel('spip_documents_inters','id_document='.intval($id_document));
	if($nb_versions >= $limite){
		$valeurs['modifiable'] = false;
		$valeurs['message_erreur'] = _T('phpotospip:erreur_nb_versions_atteint',array('nb'=>$limite));
		return $valeurs;
	}
		
	/**
	 * Restaurer les inputs en cas de test
	 */
	foreach(array('filtre',
		'ratio',
		'recadre_width',
		'recadre_height',
		'recadre_x1',
		'recadre_x2',
		'recadre_y1',
		'recadre_y2',
		'reduire_width',
		'reduire_height',
		'passe_partout_width',
		'passe_partout_height',
		'params_tourner',
		'params_image_sepia',
		'params_image_gamma',
		'params_image_flou',
		'params_image_saturer',
		'params_image_rotation',
		'params_image_niveaux_gris_auto',
		'type_modification') as $input){
		if(_request($input))
			$valeurs[$input] = _request($input);	
	}
	
	$valeurs['largeur_previsu'] = test_espace_prive()? 548 : lire_config('photospip/largeur_previsu','450');
	
	$resultats = lire_config('photospip/resultats',array('remplacer_image','creer_nouvelle_image','creer_version_image'));
	if(count($resultats) == 1){
		$valeurs['_hidden'] .= '<input type="hidden" name="type_modification" value="'.$resultats[0].'" />';
	}
	
	if(!autoriser('modifier','document',$id_document)){
		$valeurs['message_erreur'] = _T('photospip:erreur_auth_modifier');
		$valeurs['editable'] = false;
	}
	else if($GLOBALS['meta']['image_process'] != 'gd2'){
		$valeurs['message_erreur'] = _T('photospip:erreur_image_process');
		$valeurs['editable'] = false;
	}
	return $valeurs;
}

function formulaires_editer_image_verifier_dist($id_document='new', $retour=''){
	if(!$var_filtre = _request('filtre'))
		$erreurs['message_erreur'] = _T('photospip:erreur_form_filtre');
	
	elseif(!$type_resultat = _request('type_modification'))
		$erreurs['message_erreur'] = _T('photospip:erreur_form_type_resultat');
	/**
	 * On test uniquement
	 */
	elseif(_request('tester')){
		if(in_array($var_filtre,array('tourner','image_recadre'))){
			$erreurs['message_erreur'] = _T('photospip:erreur_form_filtre_sstest');
		}
		else{
			list($param1, $param2, $param3,$params) = photospip_recuperer_params_form($var_filtre);
			$erreurs['message'] = 'previsu';
			$erreurs['filtre'] = $var_filtre;
			$erreurs['param'] = $params;
			$erreurs['param1'] = $param1;
			if($param2){
				$erreurs['param2'] = $param2;
			}
			if($param3){
				$erreurs['param3'] = $param3;
			}
		}
	}
	return $erreurs;
}

function formulaires_editer_image_traiter_dist($id_document='new', $retour=''){
	$res = array();
	
	$var_filtre = _request('filtre');
	$type_modif = _request('type_modification');
	$params = photospip_recuperer_params_form($var_filtre);
	
	$row = sql_fetsel('*','spip_documents','id_document='.intval($id_document)); 
	$src = get_spip_doc($row['fichier']);
	
	$version = sql_countsel('spip_documents_inters','id_document='.intval($row['id_document']))+1;
	spip_log($version,"photospip");
	/**
	 * L'image temporaire est crée dans tmp/
	 * Elle a pour nom : tmp/image_orig-xxxx.ext où xxxx est le md5 de la date
	 */
	$src_tmp = preg_replace(",\-photospip\w+([^\-]),","$1", $src);
	spip_log("src_tmp = $src_tmp",'photospip');
	$tmp_img = _DIR_TMP.preg_replace(",\.[^.]+$,","-photospip".md5(date('Y-m-d H:i:s'))."$0", basename($src_tmp));
	$dest = preg_replace(",\.[^.]+$,","-photospip".md5(date('Y-m-d H:i:s'))."$0", $src_tmp);
	spip_log("la destination sera $dest","photospip");
	
	// on transforme l'image en png non destructif
	//$src = extraire_attribut(image_alpha($src,0),'src');
	//spip_log("On transforme l'image source en PNG non destructif","photospip");
	spip_log("application du filtre $var_filtre $src : $tmp_img","photospip");
	
	if($var_filtre == "tourner"){
		include_spip('inc/filtres');
		include_spip('public/parametrer'); // charger les fichiers fonctions #bugfix spip 2.1.0
		$tmp_img = filtrer('image_rotation',$src,$params[3]);
		$tmp_img = filtrer('image_format',$tmp_img,$row['extension']);
		$tmp_img = extraire_attribut($tmp_img,'src');
	}
	
	else{
		$sortie = photospipfiltre($src, $tmp_img, $var_filtre,$params);
		if(!$sortie){
			$res['message_erreur'] = 'photospip n a pas pu appliquer le filtre '.$var_filtre;
			return $res;
		}
	}

	if($type_modif == 'creer_version_image'){
		$size_image = getimagesize($tmp_img);
		spip_log("taille de l'image $size_image[0] x $size_image[1]","photospip");
		$largeur = $size_image[0];
		$hauteur = $size_image[1];
		$ext = substr(basename($tmp_img), strpos(basename($tmp_img), ".")+1, strlen(basename($tmp_img)));
		$poids = filesize($tmp_img);
		/**
		 * Crée une version de l'image
		 */
		if(is_array($params))
			$params = serialize($params);
		include_spip('inc/getdocument');
		sql_insertq("spip_documents_inters",array("id_document" => $row['id_document'],"id_auteur" => $id_auteur,"extension" => $row['extension'], "fichier" => $row['fichier'], "taille" => $row['taille'],"hauteur" => $row['hauteur'], "largeur" => $row['largeur'],"mode" => $row['mode'], "version" => ($version? $version:1), "filtre" => $var_filtre, "param" => $params));
		deplacer_fichier_upload($tmp_img,$dest,true);
		spip_log("move $tmp_img => $dest",'photospip');
		sql_updateq('spip_documents', array('fichier' => set_spip_doc($dest), 'taille' => $poids, 'largeur'=>$largeur, 'hauteur'=>$hauteur, 'extension' => $ext), "id_document=".intval($row['id_document']));
		spip_log("Update de l'image dans la base poid= $poids, extension = $ext, hauteur= $hauteur, largeur = $largeur, fichier = $dest","photospip");
	}else {
		$files[0]['tmp_name'] = $tmp_img;
		$files[0]['name'] = basename($dest);
		if($type_modif == 'remplacer_image'){
			/**
			 * Remplace l'image actuelle par une nouvelle
			 */
			 spip_log('on remplace','photospip');
			 $ajouter_document = charger_fonction('ajouter_documents','action');
			 $id_document = $ajouter_document($row['id_document'], $files, $objet, $id_objet, $row['mode']);
			 include_spip('inc/flock');
			 spip_unlink($tmp_img);
		}
		if($type_modif == 'creer_nouvelle_image'){
			/**
			 * Crée un nouveau document
			 */
			 spip_log('on crée un nouveau doc','photospip');
			 $ajouter_document = charger_fonction('ajouter_documents','action');
			 $objet_lie = sql_fetsel('*','spip_documents_liens','id_document='.intval($row['id_document']));
			 $id_document = $ajouter_document('new', $files, $objet_lie['objet'], $objet_lie['id_objet'], $row['mode']);
			 spip_log($id_document,'photospip');
			 $res['redirect'] = parametre_url(parametre_url(self(),'redirect',''),'id_document',$id_document[0]);
			 include_spip('inc/flock');
			 spip_unlink($tmp_img);
		}
	}
	
	include_spip('inc/invalideur');
	suivre_invalideur("id='id_document/$id_document'");
		
	if (!isset($res['redirect']))
		$res['redirect'] = parametre_url(self(),'redirect','');
	if (!isset($res['message_erreur']))
		$res['message_ok'] = _L('Votre modification a &eacute;t&eacute; enregistr&eacute;e');
	return $res;
}

function photospip_recuperer_params_form($var_filtre){
	$param1 = $param2 = $param3 = $params = null;
	if ($var_filtre == "tourner"){
		$params = _request('params_tourner');
	}
	else if($var_filtre == "image_reduire"){
		$param1 = _request('reduire_width');
		$param2 = _request('reduire_height');
		$params = array($param1,$param2);
	}
	else if($var_filtre == "image_passe_partout"){
		$param1 = _request('passe_partout_width');
		$param2 = _request('passe_partout_height');
		$params = array($param1,$param2);
	}
	else if ($var_filtre == "image_recadre"){
		$param1 = _request('recadre_width');
		$param2 = _request('recadre_height');
		$param_left = _request('recadre_x1');
		$param_top = _request('recadre_y1');
		$param3 = 'left='.$param_left.' top='.$param_top;
		$params = array($param1,$param2,$param3);
	}
	else if ($var_filtre == 'image_sepia'){
		$params = _request('params_image_sepia');
		$param1 = str_replace('#','',$params);
	}
	else if($var_filtre == 'image_gamma'){
		$param1 = _request('params_image_gamma');
	}
	else if($var_filtre == 'image_flou'){
		$param1 = _request('params_image_flou');
	}
	else if($var_filtre == 'image_saturer'){
		$param1 = _request('params_image_saturer');
	}
	else if($var_filtre == 'image_rotation'){
		$param1 = _request('params_image_rotation');
	}
	else if($var_filtre == 'image_niveaux_gris_auto'){
		$param1 = '';
	}
	return array($param1,$param2,$param3,$params);
}
?>