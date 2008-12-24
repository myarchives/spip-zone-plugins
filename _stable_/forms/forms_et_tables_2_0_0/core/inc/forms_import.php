<?php
/*
 * forms
 * Gestion de formulaires editables dynamiques
 *
 * Auteurs :
 * Antoine Pitrou
 * Cedric Morin
 * Renato
 * (c) 2005-2009 - Distribue sous licence GNU/GPL
 *
 */

function forms_csvimport_ajoute_table_csv($data, $id_form, $assoc_field, &$erreur, $simu = false){
	include_spip('inc/forms_type_champs');
	$assoc = array_flip($assoc_field);
	$res = spip_query("SELECT * FROM spip_forms WHERE id_form=".intval($id_form)." AND type_form NOT IN ('','sondage')");
	if (!$row = spip_fetch_array($res)) {
		$erreur[0][] = _L("Table introuvable");
		return;
	}

	$structure = forms_structure($id_form);
	$cle = (isset($assoc_field['id_donnee']) AND ($assoc_field['id_donnee']!='-1'))?$assoc_field['id_donnee']:false;
	$output = "";
	if ($data!=false){
		$count_lignes = 0;
		foreach($data as $key=>$ligne) {
      $count_lignes ++;
			// creation de la donnee si necessaire
			$creation = true;
			$cle_libre = true;
			$id_donnee = 0;
			// verifier la validite de l'import
			$c = array();
			foreach($structure as $champ=>$infos){
				if ($infos['type'] != 'multiple'){
					$c[$champ] = "";
				  if ((isset($assoc[$champ]))&&(isset($ligne[$assoc[$champ]]))){
				  	$c[$champ] = $ligne[$assoc[$champ]];
				  	if (isset($infos['choix']) && !isset($infos['choix'][$c[$champ]]) && isset($infos['choixrev'][$c[$champ]]))
				  		$c[$champ] = $infos['choixrev'][$c[$champ]];
				  }
				}
				else {
					$c[$champ] = array();
					foreach($infos['choix'] as $choix=>$t)
					  if ((isset($assoc[$choix]))&&(isset($ligne[$assoc[$choix]])))
					  	if (strlen($ligne[$assoc[$choix]]))
					  		$c[$champ][] = $choix;
				}
	 		}
	 		$err = forms_valide_champs_reponse_post($id_auteur, $id_donnee, $c , $structure);
	 		if (is_array($err) && count($err)) $erreur[$count_lignes] = $err;
	 		else if (!$simu) {
				if ($cle) {
					$id_donnee = $ligne[$cle];
					$res = spip_query("SELECT id_form,statut FROM spip_forms_donnees WHERE id_donnee=".intval($id_donnee));
					if ($row = spip_fetch_array($res) AND ($cle_libre = ($row['id_form']==$id_form))){
						$creation = false;
						$set = "";
						foreach(array('date','url','ip','id_auteur') as $champ)
							if (isset($assoc_field[$champ])) $set .= "$champ="._q($ligne[$assoc_field['date']]).", ";
						$set.=" maj=NOW()";
						if ($row['statut']=='poubelle')
							$set .= ", statut = 'publie'";
						spip_query("UPDATE spip_forms_donnees SET $set WHERE id_donnee=".intval($id_donnee)." AND id_form=".intval($id_form));
					}
				}
				if ($creation){
					$id_auteur = $GLOBALS['auteur_session'] ? intval($GLOBALS['auteur_session']['id_auteur']) : 0;
					$ip = $GLOBALS['REMOTE_ADDR'];
					$url = _DIR_RESTREINT_ABS;
					if ($cle AND $cle_libre){
						if (intval($id_donnee))
							spip_abstract_insert("spip_forms_donnees","(id_donnee,id_form,date,ip,id_auteur,url,confirmation,statut,maj)","(".intval($id_donnee).",".intval($id_form).", NOW(),"._q($ip).","._q($id_auteur).","._q($url).", 'valide', 'publie', NOW() )");
					}
					else
						spip_abstract_insert("spip_forms_donnees","(id_form,date,ip,id_auteur,url,confirmation,statut,maj)","(".intval($id_form).", NOW(),"._q($ip).","._q($id_auteur).","._q($url).", 'valide', 'publie', NOW() )");
					$id_donnee = spip_insert_id();
				}
				if ($id_donnee){
					foreach($c as $champ=>$values){
					  	if (!$creation)
					  		spip_query("DELETE FROM spip_forms_donnees_champs WHERE id_donnee=".intval($id_donnee)." AND champ="._q($champ));
					  	if (!is_array($values)) $values = array($values);
					  	foreach($values as $v)
					  		if (strlen($v))
					  			spip_query("INSERT INTO spip_forms_donnees_champs (id_donnee,champ,valeur,maj) VALUES (".intval($id_donnee).","._q($champ).","._q($v).", NOW() )");
			 		}
				}
				else
				  $erreur[$count_lignes][] = "ajout impossible ::id_donnee nul::<br />";
	 		}
		}
	}
}

?>