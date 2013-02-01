<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Insertion dans le pipeline diogene_ajouter_saisies (plugin Diogene)
 * 
 * On ajoute la carte et les saisies supplémentaires liées à diogene_geo
 * 
 * @param array $flux le contexte du pipeline
 */
function diogene_geo_diogene_ajouter_saisies($flux){
	$objet = str_replace('editer_','',$flux['args']['contexte']['form']);
	$id_objet = $flux['args']['contexte']['id_'.$objet];
	if(in_array($objet,array('article','rubrique')) && is_array(unserialize($flux['args']['champs_ajoutes'])) && in_array('geo',unserialize($flux['args']['champs_ajoutes']))){
		if(intval($id_objet)){
			$valeurs_gis = sql_fetsel("*","spip_gis AS gis LEFT JOIN spip_gis_liens AS lien USING(id_gis)","lien.id_objet=$id_objet AND lien.objet=".sql_quote($objet));
			if(is_array($valeurs_gis)){
				$valeurs_gis['gis_titre'] = $valeurs_gis['titre'];
				$valeurs_gis['gis_descriptif'] = $valeurs_gis['descriptif'];
				unset($valeurs_gis['titre']);
				unset($valeurs_gis['gis_descriptif']);
				$flux['args']['contexte'] = array_merge($flux['args']['contexte'],$valeurs_gis);
			}
		}
		$flux['data'] .= recuperer_fond('formulaires/diogene_ajouter_medias_geo',$flux['args']['contexte']);
	}
    return $flux;
}

/**
 * Insertion dans le pipeline diogene_traiter (plugin Diogene)
 * 
 * On crée un point ou le met à jour si on a les infos de géoloc
 * 
 * @param array $flux le contexte du pipeline
 */
function diogene_geo_diogene_traiter($flux){
	if($flux['args']['action'] == 'modifier'){
		$objet = $flux['args']['type'];
		$id_objet = $flux['args']['id_objet'];
		if(_request('gis_supprimer')){
			include_spip('action/editer_gis');
			$id_gis = _request('id_gis');
			delier_gis($id_gis, $objet, $id_objet);
			$nb_gis = sql_countsel('spip_gis_liens','id_gis='.intval($id_gis));
			if($nb_gis == 0)
				supprimer_gis($id_gis);
				
			/**
			 * On vide ensuite les request sur les données géo
			 */
			set_request('lat','');
			set_request('lon','');
			set_request('zoom','');
			set_request('gis_titre','');
			set_request('gis_descriptif','');
			set_request('adresse','');
			set_request('code_postal','');
			set_request('ville','');
			set_request('region','');
			set_request('pays','');
		}
		else if(($lat = _request('lat')) && ($lon = _request('lon'))){
			include_spip('action/editer_gis');
			// On crée l'array pour l'update et pour la création des coordonnées
			$zoom = _request('zoom');
			$titre = _request('gis_titre');
			$descriptif = _request('gis_descriptif');
			$id_gis = _request('id_gis');
			$datas = array(
				'titre' => $titre,
				'descriptif' => $descriptif,
				'lat' => $lat,
				'lon' => $lon,
				'zoom' => $zoom,
				'titre' => $titre,
				'adresse' => _request('adresse'),
				'code_postal' => _request('code_postal'),
				'ville' => _request('ville'),
				'region' => _request('region'),
				'pays' => _request('pays')
			);
			if(!intval($id_gis)){
				$id_gis = insert_gis();
			}
			sql_updateq('spip_gis',$datas,'id_gis='.intval($id_gis));
			if($objet && $id_objet)
				lier_gis($id_gis, $objet, $id_objet);
		}
	}
	return $flux;
}

/**
 * Insertion dans le pipeline diogene_verifier (Plugin Diogene)
 * Vérifie la validité des champs lat, lon, zoom, gis_titre, gis_descriptif
 * - Si au moins une de ces valeurs est présente (sauf le descriptif), lat, lon, zoom, et titre
 * deviennent obligatoires
 * - Si lat et lon sont présents mais ne sont pas de type float => erreur
 * - Si zoom est présent et n'est pas un int => erreur
 * 
 * @param array $flux Le contexte du pipeline
 */
function diogene_geo_diogene_verifier($flux){
	if(!_request('gis_supprimer')){
		$erreurs = &$flux['args']['erreurs'];
		
		$lat = _request('lat');
		$lon = _request('lon');
		$zoom = _request('zoom');
		$titre = _request('gis_titre');
		
		if($lat OR $lon OR $zoom OR $titre){
			if(!$lat){
				$flux['data']['lat'] = _T('info_obligatoire');
			}
			if(!$lon){
				$flux['data']['lon'] = _T('info_obligatoire');
			}
			if(!$zoom){
				$flux['data']['zoom'] = _T('info_obligatoire');
			}
			if(!$titre){
				$flux['data']['gis_titre'] = _T('info_obligatoire');
			}
		}
	
		if((!$erreur['lat']) && $lat){
			if((!empty($lat)) && !is_numeric($lat)){
				$flux['data']['lat'] = _T('diogene:erreur_valeur_float',array('champ'=> _T('diogene_geo:latitude')));
			}
		}
		if((!$erreur['lon']) && $lon){
			if((!empty($lon)) && !is_numeric($lon)){
				$flux['data']['lonx'] = _T('diogene:erreur_valeur_float',array('champ'=> _T('diogene_geo:longitude')));
			}
		}
		if((!$erreur['zoom']) && $zoom){
			if((!empty($zoom)) && !ctype_digit($zoom)){
				$flux['data']['zoom'] = _T('diogene:erreur_valeur_int',array('champ'=>_T('diogene_geo:zoom')));
			}
		}
	}
	return $flux;
}


/**
 * Insertion dans le pipeline diogene_charger (plugin Diogène)
 * On récupère les valeurs de lat, lon, zoom, gis_titre et gis_descriptif dans ce qui a été auparavant posté
 * (On évite le $_GET de l'url) pour le réinsérer en cas d'erreur dans le formulaire
 * 
 * @param array $flux Le contexte du pipeline
 */
function diogene_geo_diogene_charger($flux){
	$flux['data']['lat'] = $_POST['lat'];
	$flux['data']['lon'] = $_POST['lon'];
	$flux['data']['zoom'] = $_POST['zoom'];
	$flux['data']['gis_titre'] = $_POST['gis_titre'];
	$flux['data']['gis_descriptif'] = $_POST['gis_descriptif'];
	$flux['data']['adresse'] = $_POST['adresse'];
	$flux['data']['code_postal'] = $_POST['code_postal'];
	$flux['data']['ville'] = $_POST['ville'];
	$flux['data']['region'] = $_POST['region'];
	$flux['data']['pays'] = $_POST['pays'];
	$flux['data']['position_auto'] = _request('position_auto');
	return $flux;
}

/**
 * Insertion dans le pipeline diogene_champs_sup (plugin Diogene)
 * On ajoute la possibilité d'avoir une partie de formulaire pour gis pour les articles, les rubriques, 
 * les pages spécifiques et emballe_medias
 * 
 * @param array $flux Le contexte du flux
 */
function diogene_geo_diogene_champs_sup($flux){
	$flux['article']['geo'] = $flux['page']['geo'] = $flux['emballe_media']['geo'] = _T('diogene_geo:form_legend');
	$flux['rubrique']['geo'] = _T('diogene_geo:form_legend');
	return $flux;
}

/**
 * Insertion dans le pipeline em_post_upload_medias (plugin Emballe médias)
 * Dans le cas des fichiers jpg, si on a récup une géoloc, on l'ajoute à l'article aussi
 * 
 * @param array $flux Le contexte du flux
 */
function diogene_geo_em_post_upload_medias($flux){
	$id_gis = sql_getfetsel('id_gis','spip_gis_liens','objet='.sql_quote('document').' AND id_objet='.intval($flux['args']['id_document']));
	if(intval($id_gis)){
		include_spip('action/editer_gis');
		sql_delete('spip_gis_liens','objet='.sql_quote($flux['args']['objet']).' AND id_objet='.intval($flux['args']['id_objet']));
		lier_gis($id_gis, $flux['args']['objet'], $flux['args']['id_objet']);
		set_request('position_auto',true);
	}
	return $flux;
}

/**
 * Insertion dans le pipeline diogene_champs_texte (plugin Diogene)
 * On ajoute dans le formulaire d'édition de diogène la possibilité de demander de cacher la carte par défaut
 * car elle prend beaucoup de place (utile pour les sites qui ne sont pas basés sur la géolocalisation d'objets)
 * 
 * @param array $flux Le contexte du flux
 */
function diogene_geo_diogene_champs_texte($flux){
	if(in_array($flux['args']['objet'],array('article','page','emballe_media'))){
		$flux['data'] .= recuperer_fond('formulaires/diogene_geo_cacher',$flux['args']);
	}
	return $flux;
}

function diogene_geo_diogene_champs_pre_edition($array){
	$array[] = 'geo_cacher';
	return $array;
}
?>