<?php
/**
 * Plugin Agenda pour Spip 2.0
 * Licence GPL
 * 
 *
 */
include_spip('inc/actions');
include_spip('inc/editer');

function formulaires_editer_evenement_charger_dist($id_evenement,$id_article){
	
	$valeurs = formulaires_editer_objet_charger('evenement',$id_evenement,$id_article,0,'','');
	
	// les mots
	$valeurs['mots'] = sql_allfetsel('id_mot','spip_mots_evenements','id_evenement='.intval($id_evenement));

	// les repetitions
	$valeurs['repetitions'] = sql_allfetsel("date_debut","spip_evenements","id_evenement_source=".intval($id_evenement));
	foreach($valeurs['repetitions'] as $k=>$d)
		$valeurs['repetitions'][$k] = date('m/d/Y',strtotime($d));

	// fixer la date par defaut en cas de creation d'evenement
	if (!intval($id_evenement)){
		$t=time();
		$valeurs["date_debut"] = date('Y-m-d H:i:00',$t);
		$valeurs["date_fin"] = date('Y-m-d H:i:00',$t+3600);
	}
	// dispatcher date et heure
	list($valeurs["date_debut"],$valeurs["heure_debut"]) = explode(' ',date('d/m/Y H:i',strtotime($valeurs["date_debut"])));
	list($valeurs["date_fin"],$valeurs["heure_fin"]) = explode(' ',date('d/m/Y H:i',strtotime($valeurs["date_fin"])));
	
	// traiter specifiquement l'horaire qui est une checkbox
	if (_request('date_debut') AND !_request('horaire'))
		$valeurs['horaire'] = 'oui';
	return $valeurs;
}

function agenda_verifier_corriger_date_saisie($suffixe,$horaire,&$erreurs){
	include_spip('inc/filtres');
	$date = _request("date_$suffixe").($horaire?' '.trim(_request("heure_$suffixe")).':00':'');
	$date = recup_date($date);
	$ret = null;
	if (!$ret=mktime(0,0,0,$date[1],$date[2],$date[0]))
		$erreurs["date_$suffixe"] = _L('date incorrecte');
	elseif (!$ret=mktime($date[3],$date[4],$date[5],$date[1],$date[2],$date[0]))
		$erreurs["date_$suffixe"] = _L('heure incorrecte');
	if ($ret){
		if (trim(_request("date_$suffixe")!==($d=date('d/m/Y',$ret)))){
			$erreurs["date_$suffixe"] = _L('saisie corrigee');
			set_request("date_$suffixe",$d);
		}
		if ($horaire AND trim(_request("heure_$suffixe")!==($h=date('H:i',$ret)))){
			$erreurs["heure_$suffixe"] = _L('saisie corrigee');
			set_request("heure_$suffixe",$h);
		}
	}
	return $ret;
}

function formulaires_editer_evenement_verifier_dist($id_evenement,$id_article){
	$erreurs = formulaires_editer_objet_verifier('evenement',$id_evenement,array('titre','date_debut','date_fin'));

	
	$horaire = _request('horaire')=='non'?false:true;	
	$date_debut = agenda_verifier_corriger_date_saisie('debut',$horaire,$erreurs);
	$date_fin = agenda_verifier_corriger_date_saisie('fin',$horaire,$erreurs);
	
	if ($date_debut AND $date_fin AND $date_fin<$date_debut)
		$erreurs['date_fin'] = _L('la date de fin doit etre posterieure a la date de debut');

	if (!count($erreurs))
		$erreurs['message_erreur'] = 'ok?';
	return $erreurs;
}

function formulaires_editer_evenement_traiter_dist($id_evenement,$id_article){
	
}

function Agenda_action_formulaire_article($id_article,$id_evenement=NULL, $c=NULL){
	include_spip('base/abstract_sql');

	$horaire = _request('horaire')=='non'?false:true;	
	$date_debut = agenda_verifier_corriger_date_saisie('debut',$horaire,$erreurs);
	$date_fin = agenda_verifier_corriger_date_saisie('fin',$horaire,$erreurs);
	
	// gestion des requetes de mises a jour dans la base
	$insert = _request('evenement_insert',$c);
	$modif = _request('evenement_modif',$c);
	if (($insert || $modif)){

		if ( ($insert) && (!$id_evenement) ){
			if (!$id_evenement = Agenda_action_insere_evenement(array("id_evenement_source"=>0, "maj"=>"NOW()"))){
				return 0;	
			}
	 	}
		if ($id_article){
			// mettre a jour le lien evenement-article
			Agenda_action_update_evenement($id_evenement, array("id_article"=>$id_article));
	 	}
		$titre = _request('evenement_titre',$c);
		$descriptif = _request('evenement_descriptif',$c);
		$lieu = _request('evenement_lieu',$c);
		$horaire = _request('evenement_horaire',$c);
		if ($horaire!='oui') $horaire='non';


		Agenda_action_update_evenement(
			$id_evenement,
			array(
				"titre" => $titre,
				"descriptif" => $descriptif,
				"lieu" => $lieu,
				"horaire" => $horaire,
				"date_debut" => $date_deb,
				"date_fin" => $date_fin));

		// les mots cles : par groupes
		$res = sql_select("*", "spip_groupes_mots", "tables_liees REGEXP '(^|,)evenements($|,)'", "titre");
		$liste_mots = array();
		while ($row = sql_fetch($res)){
			$id_groupe = $row['id_groupe'];
			$id_mot_a = _request("evenement_groupe_mot_select_$id_groupe",$c); // un array
			if (is_array($id_mot_a) && count($id_mot_a)){
				if ($row['unseul']=='oui')
					$liste_mots[] = intval(reset($id_mot_a));
				else
					foreach($id_mot_a as $id_mot)
						$liste_mots[] = intval($id_mot);
			}
		}

		Agenda_action_update_liste_mots($id_evenement,$liste_mots);

		// gestion des repetitions
		if (($repetitions = _request('selected_date_repetitions',$c))!=NULL){
			$repetitions = explode(',',$repetitions);
			$rep = array();
			foreach($repetitions as $key=>$date){
				if (preg_match(",[0-9][0-9]?/[0-9][0-9]?/[0-9][0-9][0-9][0-9],",$date)){
					$date = explode('/',$date);
					$date = $date[2]."/".$date[0]."/".$date[1];
					$date = strtotime($date);
				}
				else {
					$date = preg_replace(",[0-2][0-9]:[0-6][0-9]:[0-6][0-9]\s*(UTC|GMT)(\+|\-)[0-9]{4},","",$date);
					$date = explode(' ',$date);
					$date = strtotime($date[2]." ".$date[1]." ".$date[3]);
				}
				if (!in_array($date,$repetitions))
					$rep[] = $date;
			}
			$repetitions = $rep;
		}
		else
			$repetitions = array();
		Agenda_action_update_repetitions($id_evenement, $repetitions, $liste_mots);
	}
	return $id_evenement;
}

?>