<?php

// cette classe charge les fonctions de lecture et ecriture d'un depot (dans inc/depot/)
//
// Ces depots ont une version qui evoluera en fonction si des changements d'api apparaissent

// version 2 (fonctions)
// - charger_args
// - lire, ecrire, effacer
//
// version 1 (fonctions)
// - lire, modifier, modifier(true)


class cfg_depot_dist{
	
	var $nom;
	var $depot;
	
	//
	// Constructeur de la classe
	// 'depot' est le nom du fichier php stocke dans /inc/depot/{depot}.php
	// qui contient une classe 'cfg_depot_{depot}' ou 'cfg_depot_{depot}_dist'
	//
	// $params est un tableau de parametres passes a la classe cfg_depot_{depot} qui peut contenir :
	// 'champs' => array(
	//		'nom'=>array(
	//			'balise' => 'select|textarea|input', // nom de la balise
	//			'type' => 'checkbox|hidden|text...', // type d'un input 
	//			'tableau' => bool, // est-ce un champ tableau name="champ[]" ?
	//			'type_verif' => 'xx', // classe css commencant par type_xx
	//			'cfg' => 'xx',   // classe css commencant par css_xx
	//			'id' => y, // cle du tableau 'champs_id' (emplacement qui possede ce champ)
	//		),
	// 'champs_id' => array(
	//		cle => 'nom' // nom d'un champ de type id
	//		),
	//	'param' => array(
	//		'parametre_cfg' => 'valeur' // les parametres <!-- param=valeur --> passes dans les formulaires cfg
	//		),
	//	'val' => array(
	//		'nom' => 'valeur' // les valeurs des champs sont stockes dedans
	//		)
	//	);
	//
	//
	function cfg_depot_dist($depot='metapack', &$cfg=false, $params=array()){
		include_spip('inc/depot/'.$depot);
		if (class_exists($class = 'cfg_depot_'.$depot)) {
			$this->depot = &new $class($params);
		} elseif (class_exists($class = 'cfg_'.$depot)) {
			$this->depot = &new $class($cfg);
		} else {
			die("CFG ne trouve pas le d&eacute;pot $depot");
		}
		
		$this->nom = $depot;
	}
	
	// ajoute les parametres transmis dans l'objet du depot
	function add_params($params){
		foreach ($params as $o=>&$v) {
			$this->depot->$o = &$v;
		}	
	}
	
	function lire($params = array()){
		$this->add_params($params);
		$r = $this->depot->lire();
		if ($this->depot->version>1) return $r; // array($ok, $val)
		else return array(true, $r);
	}
		
	function ecrire($params = array()){
		$this->add_params($params);
		if ($this->depot->version>1) return $this->depot->ecrire(); // array($ok, $val)
		else return array($this->depot->modifier(false), $this->depot->val);
	}
	
	function effacer($params = array()){
		$this->add_params($params);
		if ($this->depot->version>1) return $this->depot->effacer(); // array($ok, $val)
		else return array($this->depot->modifier(true), array());
	}	
	
	function lire_config(){
		list($ok, $s) = $this->depot->lire();
		if ($ok && ($nom = $this->nom_champ()))
			return $s[$nom];
			
		return null;
	}
	
	function ecrire_config($valeur){
		if ($nom = $this->nom_champ())
			$this->depot->val = array($nom=>$valeur);
		
		list($ok, $s) =  $this->depot->ecrire();
		return $ok;	
	}
	
	function effacer_config(){
		if ($nom = $this->nom_champ()){
			$this->depot->val[$nom] = false;
			list($ok, $s) =  $this->depot->effacer();
			return $ok;	
		}
	}	
	
	function nom_champ(){
		if (count($this->depot->champs)==1){
			foreach ($this->depot->champs as $nom=>$def){
				return $nom;	
			}
		}
		return false;			
	}
	
	// charge les arguments d'un lire/ecrire/effacer_config
	// dans le depot : lire_config($args = 'metapack::prefixe/casier/champ');
	function charger_args($args){
		if (method_exists($this->depot, 'charger_args')){
			return $this->depot->charger_args($args);	
		}
		return false;
	}
}
?>
