<?php
/*
 * Plugin TestBuilder
 * (c) 2010 Cedric MORIN Yterium
 * Distribue sous licence GPL
 *
 */

include_spip('inc/tb_lib');
function formulaires_editer_test_unit_charger_dist($filename,$funcname){
	$valeurs = array(
		'essais'=>array(),
		'_args'=>array(),
		'args'=>array(),
		'_filename'=>$filename,
		'_funcname'=>$funcname
	);

	$funcs = tb_liste_fonctions($filename);
	// la liste des arguments de la fonction
	$valeurs['_args'] = reset($funcs[$funcname]);
	// les valeurs saisies pour chaque argument
	$valeurs['args'] = array();
	// recuperer les tests precedents si possible
	if ($filetest=tb_hastest($funcname,true)){
		$valeurs['_essais'] = tb_test_essais($funcname,$filetest);
		$valeurs['_hidden'] = "<input type='hidden' name='ctrl_essais' value='".md5(serialize($valeurs['essais']))."' />";
	}
	// regarder si un demande a modifier un jeu d'essai
	$modif = -1;
	if (count($valeurs['_essais'])){
		foreach($valeurs['_essais'] as $k=>$t)
			if (_request("modif_$k")){
				set_request('args'); // effacer la saisie
				$valeurs['args'] = $t;
				array_shift($valeurs['args']); // enlever la premiere valeur
				$valeurs['args'] = array_map('tb_export',$valeurs['args']);
				$modif = $k;
				continue;
			}
	}
	if ($modif>=0 OR $modif=_request('modif_essai')){
		$valeurs['_hidden'] .= "<input type='hidden' name='modif_essai' value='$modif' />";
		$valeurs['_modif_essai'] = $modif;
	}

	return $valeurs;
}

function formulaires_editer_test_unit_verifier_dist($filename,$funcname){
	$erreurs = array();
	$args = _request('args');
	// enlever les arguments vide de fin (facultatifs)
	while (count($args) AND !strlen(end($args)))
		array_pop($args);
	// verifier qu'un args n'est pas vide au milieu
	foreach($args as $k=>$v)
		if (!strlen($v))
			$erreurs["args_$k"]=_T("tb:erreur_argument_vide");
	set_request('args',$args);
	#var_dump($args);

	if (_request('combi') AND !count($args)){
		$erreurs['message_erreur'] = _T("tb:erreur_test_combinatoire_types_requis");
	}
	// demande de test sur un jeu d'essai
	if (!count($erreurs) AND _request('tester')){
		$args = eval("return array(".implode(', ',$args).");");
		tb_try_essai($filename,$funcname,$args,$output_test);
		$erreurs['message_erreur'] = $output_test;
	}

	return $erreurs;
}

function formulaires_editer_test_unit_traiter_dist($filename,$funcname){
	if (!$filetest=tb_hastest($funcname))
		$filetest = tb_generate_new_blank_test($filename,$funcname);
	$message_ok = "";

	$essais = tb_test_essais($funcname,$filetest);
	if (_request('enregistrer')){
		$args = _request('args');
		$essai = eval("return array('??TBD??', ".implode(', ',$args).");");
		if (!is_null($m=_request('modif_essai'))){
			$essais[$m] = $essai;
			set_request('modif_essai');
		} else
			$essais[] = $essai;
		tb_test_essais($funcname,$filetest,$essais);
		tb_refresh_test($filename,$funcname,$filetest);
		set_request('args',array());
		$message_ok = _T('tb:ok_test_ajoute');
	}
	elseif(_request('combi')){
		$args = _request('args');
		$argss = tb_essai_combinatoire($args);
		foreach($argss as $args){
			array_unshift($args, "??TBD??");
			$essais[] = $args;
		}
		tb_test_essais($funcname,$filetest,$essais);
		tb_refresh_test($filename,$funcname,$filetest);
		set_request('args',array());
		$message_ok = _T("tb:ok_n_tests_combi_crees",array('nb'=>count($argss)));
	}
	elseif(_request('supprimer_tous')){
		tb_test_essais($funcname,$filetest,array());
		set_request('args',array());
		$message_ok = _T('tb:ok_tests_supprimes');
	}
	else {
		$save = false;
		foreach($essais as $k=>$t)
			if (_request("del_$k")){
				unset($essais[$k]);
				$save = true;
				set_request('modif_essai','');
			}
		if ($save){
			tb_test_essais($funcname,$filetest,$essais);
			$message_ok = _T("tb:ok_test_supprime");
		}
	}
	return array('message_ok'=>$message_ok,'fichier_test'=>$filetest,'editable'=>true);
	
}

function tb_affiche_essais($essais,$funcname,$expose=null){
	$output = "";
	if (is_array($essais) AND count($essais)){
		foreach($essais as $k=>$essai){
			$res = array_shift($essai);
			$affiche = "$funcname(".implode(',',array_map('tb_export',$essai)).")=".tb_export($res);
			$affiche = str_replace(array('&','<','>'),array('&amp;','&lt;','&gt;'),$affiche);
			$on = (!is_null($expose) AND $expose==$k)?' on':'';
			$output .= "<li class='item$on'>"
			  ."<input type='submit' class='submit' name='del_$k' value='X' />"
			  ." <input type='submit' class='submit' name='modif_$k' value='Modif' />"
			  ." <code>$affiche</code></li>";
		}
		$output = "<h3>"
		  . singulier_ou_pluriel(count($essais), 'tb:un_essai', 'tb:nb_essais')
			. "</h3><ul class='liste_items'>$output</ul>";
	}
	//var_dump($output);
	return $output;
}
?>