<?php

// Transforme en tableau une liste de type de la forme :
// type, texte
// type2, texte2
function a2a_types2array($type){
	$tableau 	= array();
	$lignes 	= explode("\n",$type);
	foreach ($lignes as $l){
		$donnees					= explode(',',$l);
		if ($donnees[1])
			$tableau[trim($donnees[0])]	= trim ($donnees[1]);
		else
			$tableau[trim($donnees[0])] = '';
	}
	
	return $tableau;
}
function formulaires_configurer_a2a_charger(){
	return lire_config('a2a');	
}

function formulaires_configurer_a2a_verifier(){
	$erreurs = array();
	$types 	= a2a_types2array(_request('types'));
	$types_actuels = lire_config('a2a/types');
	$diff 	= array_diff_key($types_actuels,$types); // les clefs supprimés 
	$sup_pb = array(); // tableau associatifs listant les types supprimés problématiques, car il y a des relations portant ce type
	foreach ($diff as $type=>$nom){
		$relations = sql_allfetsel('id_article','spip_articles_lies','type_liaison='.sql_quote($type));
		
		if (count($relations) > 0){
			$sup_pb[$type] = $relations;	
		} 	
	}
	if (count($sup_pb) > 0){ // si un pb
		$erreurs['sup_pb'] = $sup_pb;
	}
	return $erreurs;

}

function formulaires_configurer_a2a_traiter(){
	$cfg = array();
	$cfg['types']  = a2a_types2array(_request('types'));
	$cfg['type_obligatoire'] = _request('type_obligatoire');
	ecrire_config('a2a',$cfg);
	$cfg['message_ok']='oui';
	return $cfg;
}

?>