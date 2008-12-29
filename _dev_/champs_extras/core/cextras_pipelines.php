<?php
if (!defined("_ECRIRE_INC_VERSION")) return;

// pouvoir utiliser la class ChampExtra
include_spip('inc/cextras');

// Calcule des elements pour le contexte de compilation
// des squelettes de champs extras
// en fonction des parametres donnes dans la classe ChampExtra
function cextras_creer_contexte($c, $contexte_flux) {
	$contexte = array();
	$contexte['champ_extra'] = $c->champ;
	$contexte['label_extra'] = _T($c->label);
	$contexte['precisions_extra'] = _T($c->precisions);
	
	// retrouver la valeur du champ demande
	$table = table_objet_sql($c->table);
	$_id = id_table_objet($c->table);

	// attention, l'ordre est important car les pipelines afficher et editer
	// ne transmettent pas les memes arguments
	if (isset($contexte_flux[$_id])) {
		$id = $contexte_flux[$_id];		
	} elseif (isset($contexte_flux['id_objet'])) {
		$id = $contexte_flux['id_objet'];
	} elseif (isset($contexte_flux['id']) and intval($contexte_flux['id'])) { // peut valoir 'new'
		$id = $contexte_flux['id'];
	}
	
	// ajouter 'erreur_extra' dans le contexte s'il y a une erreur sur le champ
	if (isset($contexte_flux['erreurs']) 
	and is_array($contexte_flux['erreurs'])
	and array_key_exists($c->champ, $contexte_flux['erreurs'])) {
		$contexte['erreur_extra'] = $contexte_flux['erreurs'][$c->champ];
	}

	$contexte['valeur_extra'] = $contexte[$c->champ] = sql_getfetsel($c->champ, $table, $_id . '=' . sql_quote($id));
	return array_merge($contexte_flux, $contexte);
}
	
// ajouter les champs sur les formulaires CVT editer_xx
function cextras_editer_contenu_objet($flux){
	// recuperer les champs crees par les plugins
	if ($champs = pipeline('declarer_champs_extras', array())) {
		
		// liste des champs presents pour ce formulaire pour le
		// controle d'integrite md5 pour les conflits d'edition
		$extras = array();
			
		foreach ($champs as $c) {	
			// si le champ est du meme type que le flux
			if ($flux['args']['type']==objet_type($c->table) and $c->champ and $c->sql) {

				$contexte = cextras_creer_contexte($c, $flux['args']['contexte']);
				$extras[$c->champ] = $contexte[$c->champ];
				
				// calculer le bon squelette et l'ajouter
				if (!find_in_path(
				($f = 'extra-saisies/'.$c->type).'.html')) {
					// si on ne sait pas, on se base sur le contenu
					// pour choisir ligne ou bloc
					$f = strstr($contexte[$c->champ], "\n")
						? 'extra-saisies/bloc'
						: 'extra-saisies/ligne';
				}
				$extra = recuperer_fond($f, $contexte);
				$flux['data'] = preg_replace('%(<!--extra-->)%is', $extra."\n".'$1', $flux['data']);
			}
		}
		
		// s'il y a des champs, creer les controles md5
		if ($extras) {
			$flux['data'] = preg_replace('%(<!--extra-->)%is', controles_md5($extras)."\n".'$1', $flux['data']);
		}
	}
	
	return $flux;
}


// ajouter les champs extras soumis par les formulaire CVT editer_xx
function cextras_pre_edition($flux){
	
	// recuperer les champs crees par les plugins
	if ($champs = pipeline('declarer_champs_extras', array())) {
		foreach ($champs as $c) {
			// si le champ est du meme type que le flux
			if ($flux['args']['table']==table_objet_sql($c->table) and $c->champ and $c->sql) {
				if (($extra = _request($c->champ)) !== null) {
					$flux['data'][$c->champ] = corriger_caracteres($extra);
				}
			}
		}
	}
	
	return $flux;
}


// ajouter le champ extra sur la visualisation de l'objet
function cextras_afficher_contenu_objet($flux){
	// recuperer les champs crees par les plugins
	if ($champs = pipeline('declarer_champs_extras', array())) {
		foreach ($champs as $c) {
			// si le champ est du meme type que le flux
			if ($flux['args']['type']==objet_type($c->table) and $c->champ and $c->sql) {
				$contexte = cextras_creer_contexte($c, $flux['args']['contexte']);

				// calculer le bon squelette et l'ajouter
				if (!find_in_path(
				($f = 'extra-vues/'.$c->type).'.html')) {
					// si on ne sait pas, on se base sur le contenu
					// pour choisir ligne ou bloc
					$f = strstr($contexte[$c->champ], "\n")
						? 'extra-vues/bloc'
						: 'extra-vues/ligne';
				}
				$extra = recuperer_fond($f, $contexte);
				$flux['data'] .= "\n".$extra;
			}
		}
	}
	return $flux;
}

?>
