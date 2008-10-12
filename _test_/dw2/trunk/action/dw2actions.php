<?php
/*
+--------------------------------------------+
| DW2 2.14 (03/2007) - SPIP 1.9.2
+--------------------------------------------+
| H. AROUX . Scoty . koakidi.com
| Script certifi� KOAK2.0 strict, mais si !
+--------------------------------------------+
| diverses actions. Ecriture BDD !
+--------------------------------------------+
*/

if (!defined("_ECRIRE_INC_VERSION")) return;

#
# action generique
#
function action_dw2actions() {

	global $action, $arg, $hash, $id_auteur;
	include_spip('inc/securiser_action');
	if (!verifier_action_auteur("$action-$arg", $hash, $id_auteur)) {
		include_spip('inc/minipres');
		minipres(_T('info_acces_interdit'));
	}

	preg_match('/^(\w+)\W(.*)$/', $arg, $r);
	$var_nom = 'action_dw2actions_' . $r[1];
	if (function_exists($var_nom)) {
		spip_log("$var_nom $r[2]");
		$var_nom($r[2]);
	}
	else {
		spip_log("action $action: $arg incompris");
	}
}

#
# les actions ...
#

//
// suppression fiche (depuis archive)
function action_dw2actions_supprimefiche($arg) {
	global $redirect;
	$arg = intval($arg);
	
	sql_delete("spip_dw2_doc","id_document=$arg");
	
	redirige_par_entete(rawurldecode($redirect));
}

//
// modifier nom, categorie ou compteur d une fiche
function action_dw2actions_modifierfiche($arg) {
	global $redirect;
	global $n_nom, $n_categorie, $n_total;
	$arg = intval($arg);
	
	// On controle que le champ "nom" pas vide
	if (!empty ($n_nom)) {
		sql_updateq("spip_dw2_doc",array('categorie'=>$n_categorie, 'nom'=>$n_nom, 'total'=>$n_total),"id_document=$arg");
	}
	redirige_par_entete(rawurldecode($redirect));
}

//
// deplace un Doc d un article a un autre (ou rubrique)
function action_dw2actions_deplacerdocument($arg) {
	global $redirect;
	global $new_doctype, $new_iddoctype, $anc_doctype;
	$arg = intval($arg); // id_document
	if(isset($new_iddoctype)) {
		sql_updateq("spip_dw2_doc",array('doctype'=>$new_doctype, 'id_doctype'=>$new_iddoctype),"id_document='$arg'");
		//sql_delete("spip_documents_".$anc_doctype."s","id_document='$arg'");
		sql_updateq("spip_documents_liens",array('objet'=>$new_doctype, 'id_objet'=>$new_iddoctype),"id_document='$arg'");
	}
	redirige_par_entete(rawurldecode($redirect));
}

//
// mise a jour du Titre et Descriptif du document
function action_dw2actions_majtitredocument($arg) {
	global $redirect;
	global $titre_document, $descriptif_document;
	$arg = intval($arg);
	
	include_spip('inc/filtres');
	
	$titre_document = addslashes(corriger_caracteres($titre_document));
	$descriptif_document = addslashes(corriger_caracteres($descriptif_document));
	
	sql_updateq("spip_documents",array('titre'=>$titre_document, 'descriptif'=>$descriptif_document),"id_document='$arg'");
	
	redirige_par_entete(rawurldecode($redirect));
}

//
// modifier nom, categorie ou compteur d une fiche
function action_dw2actions_modifiercategorie($arg) {
	global $redirect;
	global $nouv_categ;
	
	// On controle que nouv_categ (nouveau nom categorie) ne soit pas vide
	if (!empty ($nouv_categ)) {
		sql_updateq("spip_dw2_doc",array('categorie'=>$nouv_categ),"categorie='".$arg."'");
	}
	redirige_par_entete(rawurldecode($redirect));
}

//
// changer statut d'une Fiche de Doc
function action_dw2actions_changerstatut($arg) {
	global $redirect;
	global $chg_statut_doc, $num_arch, $inverse;
	
	// $arg -> 'archive' par defaut !!
	// inverser formulaire outils - rendre 'actif'
	if($inverse) { $arg='actif'; }
	
	// vient de dw2_outils, dw2_accueil
	if($num_arch) {
		$chg_statut_doc = explode(',',$num_arch);
		reset($chg_statut_doc);
	}
	
	// vient dw2_modif (var) ou ci-dessus (tableau)
	if(is_array($chg_statut_doc)) {
		foreach($chg_statut_doc as $k) {
			sql_updateq("spip_dw2_doc",array('statut'=>$arg),"id_document=$k");
		}
	}
	else {
		sql_updateq("spip_dw2_doc",array('statut'=>$arg),"id_document=$chg_statut_doc");
	}
	
	redirige_par_entete(rawurldecode($redirect));
}

//
// modifier intitule de serveur ftp
function action_dw2actions_modifierintitule($arg) {
	global $redirect;
	global $designe;
	$arg = intval($arg); // id_serv
	if($designe!='') {
		sql_updateq("spip_dw2_serv_ftp",array('designe'=>$designe),"id_serv=$arg");
	}
	redirige_par_entete(rawurldecode($redirect));
}


//
// effacer un serveur ftp
function action_dw2actions_effaceserveur($arg) {
	global $redirect;

	$arg = intval($arg);
	#$redirect = generer_url_ecrire("dw2_deloc");
	sql_delete("spip_dw2_serv_ftp","id_serv=$arg");

	redirige_par_entete(rawurldecode($redirect));
}

//
//
function action_dw2actions_inclusdocserveur($arg) {
	global $redirect;
	global $id_serv, $sitedist, $extension, $repert_dest, $taille, $fichier;
	
	
	// reconstruction chemin-fichier-spipien, type IMG/nnn/fichier
	if (ereg("\.([^.]+)$", $fichier, $match))
		{ $ext = strtolower($match[1]); }
	$lien_fichier = "IMG/".$ext."/".$fichier;

	// insert dans spip_documents
	$id_document = sql_insertq("spip_documents", array(
					'id_vignette' => '0' ,
					'extension' => $extension,
					'date' => "NOW()", 
					'fichier' => $lien_fichier, 
					'taille' => $taille,
					'mode' => 'document') );
	//$id_document = mysql_insert_id();
	
	// prim insert dans spip_dw2_doc
	$url = "/".$repert_dest.$fichier;
	sql_insertq("spip_dw2_doc", array(
				'id_document' => $id_document,
				'nom' => $fichier,
				'url' => $url, 
				'date_crea' => "NOW()", 
				'heberge'=> $sitedist,
				'id_serveur'=> $id_serv) );
		
	redirige_par_entete(rawurldecode($redirect."&id_document=".$id_document."&id_serv=".$id_serv));
}

//
//
function action_dw2actions_docserveurlier($arg) {
	include_spip("inc/dw2_inc_ajouts");
	
	$arg = intval($arg); // arg -> id_document
	
	global $trt_doc, $descrip_doc, $id_rub, 
			$proposition, //-> id_article
			$proposition, 
			$fichier, $type_categorie, 
			$id_serv;
			
			
	if(!$id_rub) {
		// si val vide retourne sur affect_doc
		$redirect=generer_url_ecrire("dw2_affect_doc");
		redirige_par_entete(rawurldecode($redirect."&id_document=".$arg."&id_serv=".$id_serv));
	}
	
	// enregistrer le #titre et #descriptif du doc
	include_spip('inc/filtres');
	$trt_doc = addslashes(corriger_caracteres($trt_doc));
	$descrip_doc = addslashes(corriger_caracteres($descrip_doc));
	sql_updateq("spip_documents",array('titre'=>$trt_doc, 'descriptif'=>$descrip_doc),"id_document=$arg");


	if($proposition=='') {
		// lier doc � la rubrique dans spip
		sql_insertq("spip_documents_liens", array('id_document'=>$arg,'id_objet'=>$id_rub,'objet'=>'rubrique') );
		$doctype='rubrique';
		$id_doctype=$id_rub;

	}
	else {
		sql_insertq("spip_documents_liens",array('id_document'=>$arg, 'id_objet'=>$proposition,'objet'=>'article') );
		$doctype='article';
		$id_doctype=$proposition;

	}
	
	// secteur ou rubrique
		$row=sql_fetsel("id_secteur","spip_rubriques","id_rubrique=$id_rub");
		if($row['id_secteur']!=$id_rub) { $id_sect = $row['id_secteur']; }
		
	// update final de spip_dw2_doc
		if ($type_categorie=="secteur")
			{ $class_cat=$id_sect; }
		else { $class_cat=$id_rub; }
		sql_updateq("spip_dw2_doc", array(
					'doctype'=>$doctype,
					'id_doctype'=>$id_doctype,
					'categorie'=> select_categorie_doc($class_cat) ),
					"id_document=$arg");
	
	$redirect=generer_url_ecrire("dw2_import");
	redirige_par_entete(rawurldecode($redirect."&id_serv=".$id_serv));
}


//
// annuler insert doc depuis serveur
function action_dw2actions_annuledocserveur($arg) {
	global $redirect;
	
	$arg = intval($arg); // arg -> id_document
	
	sql_delete("spip_dw2_doc","id_document=$arg");
	sql_delete("spip_documents","id_document=$arg");
	sql_delete("spip_documents_liens","id_document=$arg");
	
	redirige_par_entete(rawurldecode($redirect));
}


//
// changer association fichier/serveur
function action_dw2actions_changerassociation($arg) {
	global $redirect;
	// arg -> $id_document
	global $id_serveur, $heberge, $url, $erazfichier;
	
	// recup de l'ancienne url du fichier
	if ($erazfichier=='oui') { 
		$row = sql_fetsel("url","spip_dw2_doc","id_document=$arg");
		$anc_url = $row['url'];
	}
	
	// update de ces champs !
	$nomfichier = substr(strrchr($url,'/'), 1);
	sql_updateq("spip_dw2_doc",array(
				'heberge'=>$heberge,
				'url'=>$url,
				'id_serveur'=>$id_serveur),
				"id_document='$arg'");
	
	// supprimer le fichier local
	if ($erazfichier=='oui') {
		unlink("..".$anc_url);
	}

	redirige_par_entete(rawurldecode($redirect));
}



//
// enreg/modif/duplic un serveur
function action_dw2actions_serveredit($arg) {
	global $redirect;
	global $serv_ftp, $host_dir, $port, $login, $mot_passe, $site_distant, $chemin_distant, $id_serv, $duplic;
	
	// requis
	include_spip("inc/dw2_inc_deloc");
	
	$flag_err=array();
	
	if($duplic=="oui") { $faire_insert = true; }
	if(empty($id_serv)) { $faire_insert = true; }
	
		// On v�rifie si les champs sont vides
	if(empty($serv_ftp) OR empty($login) OR empty($mot_passe) OR empty($site_distant) OR empty($chemin_distant))
    	{
		$flag_err[] = "1";
		$faire_insert = false;
		}
	
	// Verif pas de '/' en fin site_distant  +  scheme'http'/'ftp' + 2 blocs sep. '.' du host
	if(ereg("/$", $site_distant)) { $flag_err[] = "2"; $faire_insert = false; }
	if (!verif_scheme_host($site_distant)) { $flag_err[] = "6"; $faire_insert = false; }
	
	// controles syntaxe ftp... trop vari� alors juste pas de slash de fin!
	if(ereg("/$", $serv_ftp)) { $flag_err[] = "5"; $faire_insert = false; }
					
	// pas de '/' en tete de $chemin_distant
	if(ereg("^/{1,}", $chemin_distant)) { $flag_err[] = "3"; $faire_insert = false; }
	if (!ereg("([^/]/{1})$", $chemin_distant)) { $flag_err[] = "4"; $faire_insert = false; }

	if(count($flag_err)=='0') {
		$maj = true;
	}
	
	// on corrige (tout est relatif) $port !
	$port = intval($port);
	
	if($faire_insert) {
		$id_serv = sql_insertq("spip_dw2_serv_ftp", array(
						'serv_ftp'=>$serv_ftp,
						'host_dir'=> $host_dir,
						'port'=>$port,
						'login'=>$login,
						'mot_passe'=>$mot_passe,
						'site_distant'=>$site_distant,
						'chemin_distant' => $chemin_distant,
						'date_crea'=>"NOW())" ) );

		sql_updateq("spip_dw2_serv_ftp",array('designe'=>_T('dw:serveur')." - $id_serv'"),"id_serv=$id_serv");
	}
	elseif($maj) {
		sql_updateq("spip_dw2_serv_ftp", array(
					'serv_ftp'=>$serv_ftp,
					'host_dir'=>$host_dir,
					'port'=>$port,
					'login'=>$login, 
					'mot_passe'=>$mot_passe,
					'site_distant'=>$site_distant,
					'chemin_distant'=>$chemin_distant),
					"id_serv=$id_serv");
	}
	
	if(count($flag_err)=='0') {
		// Controle de connexion
		$repertoire_dest = $host_dir.$chemin_distant;
		$retour_conex = connexion_serv($serv_ftp, $port, $login, $mot_passe, $repertoire_dest);
		$conex=$retour_conex[0];
		$message_conex=$retour_conex[1];
		@ftp_quit($conex);
		$retour = $message_conex;
	}
	else {
		$retour=join(",",$flag_err);
	}

	redirige_par_entete(rawurldecode($redirect."&id_serv=".$id_serv."&retour=".$retour));

}

// h.29/12 modif restriction telech generique
// pour document, article, rubrique et 'tous secteurs' (racine).
function action_dw2actions_restrictgen($arg) {
	global $redirect;
	global $restreint, $type;
	$arg = intval($arg); //id_
	$restreint = intval($restreint);
	
	if($type=='racine') {
		$q=sql_select("id_rubrique","spip_rubriques","id_parent='0'");
		while($r=sql_fetch($q)) {
			$idr=$r['id_rubrique'];
			$ex=sql_select("id","spip_dw2_acces_restreint","id_rubrique=$idr");
			// d�j� une ligne ?
			if($s=sql_count($ex)) {
				sql_updateq("spip_dw2_acces_restreint",array('restreint'=>$restreint),"id_rubrique=$idr");
			}
			else {
				sql_insertq("spip_dw2_acces_restreint",array('id_rubrique'=>$idr, 'restreint'=>$restreint));
			}
		}
	}
	else {
		$q=sql_select("id","spip_dw2_acces_restreint","id_$type=$arg");
		// d�j� une ligne ?
		if($s=sql_count($q)) {
			sql_updateq("spip_dw2_acces_restreint",array('restreint'=>$restreint),"id_$type=$arg");
		}
		else {
			sql_insertq("spip_dw2_acces_restreint",array('id_$type'=>$arg, 'restreint'=>$restreint));
		}
	}
	redirige_par_entete(rawurldecode($redirect));
}

//h.08/02
// Efface de table acces_restreint rub-racine si TOUTES =0
function action_dw2actions_menageracine($arg) {
	global $redirect;
	global $tbl_racine; // tbl des id_rub-racine
	# arg : nbr_secteurs
	$tbl = explode(',',$tbl_racine);

	foreach($tbl as $id) {
		sql_delete("spip_dw2_acces_restreint","id_rubrique=".$id);
	}
	redirige_par_entete(rawurldecode($redirect));
}


//h.12/02
// nettoyage catalogue DW2 (une 'tite erreur de manip ?!')
function action_dw2actions_netcat($arg) {
	global $redirect;
	global $choixselect; // choix sur 'date'
	global $jour, $mois, $annee, $heure, $minute;
	# arg : ne vaut rien ;-) ==>'rien'
	$date=$annee."-".$mois."-".$jour." ".$heure.":".$minute.":00";
	if($choixselect=='date') {
		sql_delete("spip_dw2_doc","date_crea BETWEEN '$date' AND NOW()");
	}
	
	redirige_par_entete(rawurldecode($redirect."&date=".$date));
}

?>