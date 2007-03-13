<?php
function tagname($tag){
	if (preg_match(',^([a-z][\w:]*),i',$tag,$reg))
		return $reg[1];
	return "";
}
function spip_xml_decompose_tag($tag){
	$tagname = tagname($tag);
	$liste = array();
	$p=strpos($tag,' ');
	$tag = substr($tag,$p);
	$p=strpos($tag,'=');
	while($p!==false){
		$attr = trim(substr($tag,0,$p));
		$tag = ltrim(substr($tag,$p+1));
		$quote = $tag{0};
		$p=strpos($tag,$quote,1);
		$cont = substr($tag,1,$p-1);
		$liste[$attr] = $cont;
		$tag = substr($tag,$p+1);
		$p=strpos($tag,'=');
	}
	return array($tagname,$liste);
}

function spip_xml_match_nodes($regexp,&$arbre,&$matches){
	if(is_array($arbre) && count($arbre))
		foreach(array_keys($arbre) as $tag){
			if (preg_match($regexp,$tag))
				$matches[$tag] = &$arbre[$tag];
			foreach(array_keys($arbre[$tag]) as $occurences)
				spip_xml_match_nodes($regexp,$arbre[$tag][$occurences],$matches);
		}
	return (count($matches));
}


function opml2table($niveau,&$arbre,&$table,&$colonnes){
	if(is_array($arbre) && count($arbre))
		foreach($arbre as $tag=>$sousarbre){
			list($tagname,$attributs) = spip_xml_decompose_tag($tag);
			$colonnes = array_merge($colonnes,$attributs);
			$table[] = array($niveau,$attributs);
			foreach($sousarbre as $opmls)
				opml2table($niveau+1,$opmls,$table,$colonnes);
		}
}

function inc_outline_importer($opml_arbre,$nom_fichier){
	$titre = _L("Sans titre");
	$descriptif = $nom_fichier;
	if (spip_xml_match_nodes(",^head,i",$opml_arbre,$heads)){
		if (spip_xml_match_nodes(",^title,i",$heads,$titles))
			$titre = spip_xml_aplatit(end($titles),' ');
	}
	$colonnes = array();
	$table = array();
	if (spip_xml_match_nodes(",^body,i",$opml_arbre,$body_matched)){
		foreach($body_matched as $bodys)
			foreach($bodys as $body){
				opml2table(1,$body,$table,$colonnes);
			}
	}
	
	include_spip('base/forms_api');
	$f = find_in_path('base/Outliner.xml');
	$id_form = Forms_creer_table($f,'outline',false,array('titre'=>$titre,'descriptif'=>$descriptif));

	$trans=array('text'=>'ligne_1','_status'=>'_status');
	foreach(array_keys($colonnes) as $col){
		if(!isset($trans[$col])){
			$trans[$col]=Forms_creer_champ($id_form,'texte',$col,array('public'=>'oui'));
		}
	}

	foreach($table as $ligne){
		list($niveau,$values) = $ligne;
		$c=array('select_1'=>"select_1_$niveau");
		foreach($values as $col=>$v)
			$c[$trans[$col]] = $v;
		Forms_creer_donnee($id_form,$c);
	}
}

?>