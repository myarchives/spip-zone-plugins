<?php

function bigbrother_affiche_droite($flux){
	/*if (in_array($flux['args']['exec'],array('articles_edit','breves_edit','rubriques_edit','mots_edit'))){
	include_spip('exec/inc_boites_infos');
	$flux['data'] .= boite_info_jeux_edit();
	}*/

	if ($flux['args']['exec'] == 'auteur_infos'){

		$boite = debut_boite_info(true)
			. icone_horizontale(
				_T('bigbrother:voir_statistiques_auteur'),
				generer_url_ecrire('bigbrother_visites_articles_auteurs','id_auteur='.$flux['args']['id_auteur']),
				find_in_path('bigbrother-24.png', 'images/', false),
				'',
				false
			)
			. fin_boite_info(true);

		$flux['data'] .= $boite;

	}
	elseif ($flux['args']['exec'] == 'articles'){

		$boite = debut_boite_info(true)
			. icone_horizontale(
				_T('bigbrother:voir_statistiques_article'),
				generer_url_ecrire('bigbrother_visites_articles_auteurs','id_article='.$flux['args']['id_article']),
				find_in_path('bigbrother-24.png', 'images/', false),
				'',
				false
			)
			. fin_boite_info(true);

		$flux['data'] .= $boite;

	}

	return $flux;
}


function bigbrother_insert_head($flux){

	$flux .= '<link rel="stylesheet" media="all" type="text/css" href="'.find_in_path('bigbrother.css', 'css/', false).'" />';
	return $flux;

}

function bigbrother_header_prive($flux){

	$flux .= '<link rel="stylesheet" media="all" type="text/css" href="'.find_in_path('bigbrother.css', 'css/', false).'" />';
	return $flux;

}

/**
 * Insertion dans le pipeline post_edition
 * On ajoute la journalisation pour la modification de contenu
 * ainsi que pour l'institution (changement de statut) d'objets
 * @param unknown_type $flux
 */
function bigbrother_post_edition($flux){
	if(lire_config('bigbrother/modifier')){
		$journal = charger_fonction('journal','inc');
		$qui = $GLOBALS['visiteur_session']['nom'] ? $GLOBALS['visiteur_session']['nom'] : $GLOBALS['ip'];
		$qui_ou_ip = $GLOBALS['visiteur_session']['id_auteur'] ? $GLOBALS['visiteur_session']['id_auteur'] : $GLOBALS['ip'];

		$quoi = $flux['args']['type'];
		if($flux['args']['action'] == 'instituer'){
			if(!$quoi){
				$table = $flux['args']['table'];
				$quoi = objet_type($table);
			}
			$faire = 'instituer';
			$texte = 'bigbrother:action_instituer_objet';
		}else{
			$faire = 'modifier';
			$texte = 'bigbrother:action_modifier_objet';
		}

		$texte_infos = array('qui'=>$qui,'type'=> $quoi,'id'=>$flux['args']['id_objet']);

		$journal(
			_T($texte,$texte_infos),
			array('qui' => $qui_ou_ip,'faire' => $faire,'quoi' => $quoi,'id' => $flux['args']['id_objet'])
		);
	}
}

/**
 * Insertion dans le pipeline post_insertion
 * On ajoute la journalisation pour la création de contenu
 * @param unknown_type $flux
 */
function bigbrother_post_insertion($flux){
	if(lire_config('bigbrother/inserer')){
		$journal = charger_fonction('journal','inc');
		$qui = $GLOBALS['visiteur_session']['nom'] ? $GLOBALS['visiteur_session']['nom'] : $GLOBALS['ip'];
		$qui_ou_ip = $GLOBALS['visiteur_session']['id_auteur'] ? $GLOBALS['visiteur_session']['id_auteur'] : $GLOBALS['ip'];

		$table = $flux['args']['table'];
		$quoi = objet_type($table);
		$faire = 'inserer';
		$texte = 'bigbrother:action_inserer_objet';

		$texte_infos = array('qui'=>$qui,'type'=> $quoi,'id'=>$flux['args']['id_objet']);

		$journal(
			_T($texte,$texte_infos),
			array('qui' => $qui_ou_ip,'faire' => $faire,'quoi' => $quoi,'id' => $flux['args']['id_objet'])
		);
	}
}

function bigbrother_jquery_plugins($array){
	$array[] = _DIR_LIB_FLOT.'/jquery.flot.js';
	$array[] = 'javascript/flot_extras.js';
	return $array;
}

function bigbrother_affichage_final($flux){
	// Si la config est ok, à chaque hit, on teste s'il faut enregistrer la visite ou pas
	if (lire_config('bigbrother/visite') == 'oui')
		bigbrother_tester_la_visite_du_site();
	return $flux;
}
?>
