<?php
/*
 * snippets
 * Gestion d'import/export XML de contenu
 *
 * Auteurs :
 * Cedric Morin
 * � 2006 - Distribue sous licence GNU/GPL
 *
 */

function snippets_fonction_importer($table){
	if (substr($table,0,5)=="spip_") $table = substr($table,5);
	return ($f = charger_fonction("importer","snippets/$table"));
}
function snippets_fond_exporter($table,$find = true){
	if (substr($table,0,5)=="spip_") $table = substr($table,5);
	$f = "snippets/$table/exporter";
	if ($find)
		$f = find_in_path("$f.html");
	return $f;
}

function snippets_liste_imports($table){
	$pattern = $table;
	if (substr($table,0,5)=="spip_") $table = substr($table,5);
	
	$pattern = ".*[.]xml$";
	$snippets = find_all_in_path("snippets/$table/",$pattern);
	return $snippets;
}

function boite_snippets($titre,$table,$id,$contexte="",$retour = ""){
	include_spip('inc/autoriser');
	if (!strlen($retour))
		$retour = _DIR_RESTREINT_ABS . self();
	$out = debut_boite_info(true);
	
	$auth = false;
	$type = $table;
	if (substr($type,-1)=="s") $type = substr($type,0,strlen($type)-1);
	if (substr($type,0,5)=="spip_") $type = substr($type,5);
	if (intval($id)==$id) {
		$auth = autoriser('modifier',$type,$id);
	}
	else {
		$auth = true;
		if ( (count($t = explode('=',$contexte))==2) AND ($id_contexte=intval($t[1])) ) {
			$type_contexte = $t[0];
			if (substr($type_contexte,0,3)=="id_") $type_contexte = substr($type_contexte,3);
			$auth = autoriser('modifier',$type_contexte,$id_contexte);
		}
		$auth &= autoriser('creer',$type,$id);
	}
	if (!$auth) return "";
	
	if (intval($id) AND $f = snippets_fond_exporter($table)){
		$action = generer_action_auteur('snippet_exporte',"$table:$id",$retour);
		$out .= "<a href='$action' title='"._T('snippets:exporte')."'>"._T('snippets:exporte')."</a><hr/>";
	}
	
	$liste = snippets_liste_imports($table);
	foreach($liste as $snippet){
		if (!_DIR_RESTREINT) $snippet = substr($snippet,strlen(_DIR_RACINE));
		$action = generer_action_auteur('snippet_importe',"$table:$id:$contexte:$snippet",$retour);
		$out .= "<a href='$action' title='"._T('snippets:importe')."'>".basename($snippet)."</a><br/>";
	}

	$action = generer_action_auteur('snippet_importe',"$table:$id",$retour);
	$out .= "<form action='$action' method='POST' enctype='multipart/form-data'>";
	$out .= form_hidden($action);
	$out .= "<strong><label for='file_name'>"._T("snippets:importer_fichier")."</label></strong> ";
	$out .= "<br />";
	$out .= "<input type='file' name='snippet_xml' id='file_name' class='formo'>";
	$out .= "<div style='text-align:$spip_lang_right'>";
	$out .= "<input type='submit' name='Valider' value='"._T('bouton_valider')."' class='fondo'>";
	$out .= "</div>";
	$out .= "</form></p>\n";

	$out .= fin_boite_info(true);
	return $out;
}


?>