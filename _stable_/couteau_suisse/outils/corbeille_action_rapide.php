<?php

// module inclu dans la description de l'outil en page de configuration

include_spip('inc/actions');

function corbeille_action_rapide() {
	foreach(cs_corbeille_table_infos() as $table=>$obj) {
		list($nb, $nb_lies, $ids) = cs_corbeille_gerer($table, -1);
		$ids = join(',', $ids);
		$infos = 
			($nb?_T('couteauprive:corbeille_objets', array('nb'=>$nb)):_T('couteauprive:corbeille_objets_vide'))
			.($nb_lies>0?' '._T('couteauprive:corbeille_objets_lies', array('nb_lies'=>$nb_lies)):'');
		$objets[] = "<label><input type='checkbox' value='$table:$ids'".($nb?" checked='checked'":"")." name='$table'/>$obj[libelle_court].
<span class='ar_edit_info'>$infos</span></label>";
	}
	return ajax_action_auteur('action_rapide', 'corbeille', 'admin_couteau_suisse', "arg=retour_normal&cmd=descrip&outil=corbeille#cs_action_rapide",
			"\n<div style='padding:0.4em;'><fieldset><legend>"._T('couteauprive:corbeille_vider').'</legend>'
			. join("<br/>\n",$objets) . "<div style='text-align: right;'><input class='fondo' type='submit' value=\""
			. attribut_html(_T('couteauprive:corbeille_objets_vider'))
			. '" /></div></fieldset></div>');
}

// pour ajouter des tables dans la corbeille, utiliser le tableau : global $corbeille_params['nvelle_table_SPIP'];
/*
 "nvelle_table_SPIP" => array (
	"statut" => nom du statut dans la base de donnees (bdd),
	"titre" => nom du champ retourne dans le listing,
	"table" => nom de la table spip dans la bdd,
	"id" => clef primaire dans la table,
	"temps" => aucune idee a quoi �a peut servir,
	"page_voir" => parametres pour voir le detail d'un objet
	"libelle" => texte long dans la partie droite de l'affichage,
	"libelle_court" => texte court dans le menu gauche,
	"tableliee"  => tableau des tables spip � vider en meme temps    ) 
*/
function cs_corbeille_table_infos($table=false) {
	static $params = null;
	if(is_null($params)) {
		global $corbeille_params;
		$params = array (
			"articles" => array( "statut" => "poubelle",
				"tableliee"=> array("spip_auteurs_articles","spip_documents_liens","spip_mots_articles","spip_signatures","spip_versions","spip_versions_fragments","spip_forum"),
				"temps" => "date",
				"libelle_court" => _T('icone_articles')
				),
			"auteurs" => array( "statut" => "5poubelle",
				"temps" => "maj",
				"libelle_court" => _T('icone_auteurs')
				),					
			"breves" => array( "statut" => "refuse", 
				"temps" => "date_heure",
				"libelle_court" => _T('icone_breves')
				),
			"forums_publics" => array( "statut" => "off",
				"table"=>"forum",
				"temps" => "date_heure",
				"libelle_court" => _T('titre_forum')
				),
			"forums_prives" => array( "statut" => "privoff",
				"table"=>"forum",
				"temps" => "date_heure",
				"libelle_court" => _T('icone_forum_administrateur')
				),
			"signatures" => array( "statut" => "poubelle", 
				"temps" => "date_time",
				"page_voir" => array("signatures",'id_document'),
				"libelle_court" => _T('couteau:objet_petitions'),
				),
			"sites" => array( "statut" => "refuse",
				"table" => "syndic",
				"tableliee"=> array("spip_syndic_articles","spip_mots_syndic"),
				"temps" => "maj",
				"page_voir" => array("sites",'id_syndic'),
				"libelle_court" => _T('couteau:objet_syndics')
				)	,
		);
		if(is_array($corbeille_params)) $params = array_merge($params, $corbeille_params);
	}
	if(!$table) return $params;
	if(isset($params[$table])) return $params[$table];
	return false;
}

/**
 * supprime/compte les elements listes d'un type donne
 *
 * @param nom $table
 * @param tableau $ids (si $id==-1, on vide/compte tout)
 * @param booleen $compter
 * @return array(nb objets, nb objets lies, ids trouves)
 */
function cs_corbeille_gerer($table, $ids=array(), $vider=false) {
	$params = cs_corbeille_table_infos($table);
	if (isset($params['table'])) $table = $params['table'];
	include_spip('base/abstract_sql');
	$type = objet_type($table);
	$table_sql = 'spip_' . $table; // table_objet_sql($type) buggue car le pluriel de 'jeu' est 'jeux' et non 'jeus'
	$id_table = isset($params['id'])?$params['id']:id_table_objet($type);
	if (!$params['statut']) return false;
//echo "$type - $table_sql - $id_table - ",table_objet_sql($type),'<hr>';
	// determine les index des elements a supprimer
	$ids = $ids===-1
		?array_map('reset',sql_allfetsel($id_table,$table_sql,'statut='.sql_quote($params['statut'])))
		:array_map('reset',sql_allfetsel($id_table,$table_sql,sql_in($id_table,$ids).' AND statut='.sql_quote($params['statut'])));
	if (!count($ids)) return array(0, 0, array());
	// compte/supprime les elements definis par la liste des index
	if($vider) sql_delete($table_sql,sql_in($id_table,$ids));
	$nb = count($ids);

	// compte/supprime des elements lies
	$nb_lies = 0;
	$f = $vider?'sql_delete':'sql_countsel';
	if ($table_liee=$params['tableliee']) {
		$trouver_table = charger_fonction('trouver_table','base');
		foreach($table_liee as $unetable) {
			$desc = $trouver_table($unetable);
			if (isset($desc['field'][$id_table]))
				$nb_lies += $f($unetable,sql_in($id_table,$ids));
			elseif(isset($desc['field']['id_objet']) AND isset($desc['field']['objet']))
				$nb_lies += $f($unetable,sql_in('id_objet',$ids)." AND objet=".sql_quote($type));
		}
	}
	return array($nb, $vider?'-1':$nb_lies, $ids);
}

function action_rapide_purge_corbeille() {
	foreach(cs_corbeille_table_infos() as $table=>$objet)	
		if(preg_match(',^(.*?):(.*)$,', _request($table), $regs)) {
			$ids = explode(',', $regs[2]);
			// purger !
			cs_corbeille_gerer($regs[1], $ids, true);
		}
}

?>