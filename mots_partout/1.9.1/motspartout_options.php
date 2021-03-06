<?php

$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(dirname(__FILE__)))));
define('_DIR_PLUGIN_MOTS_PARTOUT',(_DIR_PLUGINS.end($p)));

global $tables_jointures;
global $tables_auxiliaires;


$tables_installees = unserialize(lire_meta('MotsPartout:tables_installees'));	
if (!$tables_installees){
  $tables_installees=array("articles"=>true,"rubriques"=>true,"breves"=>true,"forum"=>true,"syndic"=>true);
  ecrire_meta('MotsPartout:tables_installees',serialize($tables_installees));
  ecrire_metas();
 }
	
foreach($tables_installees as $chose => $m) { $choses[]= $chose; }
global $choses_possibles;
include(_DIR_PLUGIN_MOTS_PARTOUT."/mots_partout_choses.php");

//hack tout moche, mots_partout_choses serait bien mieux dans un dire inc/
if(!count($choses_possibles))
   include(_DIR_PLUGIN_MOTS_PARTOUT."/1.9.1/mots_partout_choses.php"); 
   

foreach ($choses as $chose){
  $id_chose = $choses_possibles[$chose]['id_chose'];
  $table_principale = $choses_possibles[$chose]['table_principale'];
	

  $spip_mots_choses = array(
							"id_mot"	=> "BIGINT (21) DEFAULT '0' NOT NULL",
							$id_chose	=> "BIGINT (21) DEFAULT '0' NOT NULL");

  $spip_mots_choses_key = array(
								"PRIMARY KEY"	=> "$id_chose, id_mot",
								"KEY id_mot"	=> "id_mot");

  $tables_auxiliaires[str_replace('spip_','spip_mots_',$table_principale)] = array(
																				   'field' => &$spip_mots_choses,
																				   'key' => &$spip_mots_choses_key);

  $tables_jointures[$table_principale][]= 'mots';
  $tables_jointures['spip_mots'][]= str_replace('spip_','mots_',$table_principale);
}

?>
