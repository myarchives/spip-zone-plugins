<?
//déclaration des tables du plugin jeux //

include_spip('base/serial'); // pour eviter une reinit posterieure des tables modifiees

global $tables_principales;
$jeux = array(
	'id_jeu'	=>'bigint(21) NOT NULL AUTO INCREMENT',
	'date'		=>"datetime DEFAULT '0000-00-00 00:00:00' NOT NULL",
	'contenu'	=>'text NOT NULL',
	'divers'	=>'text NOT NULL'
	);

$jeux_key = array(
	'PRIMARY KEY'	=>'id_jeu');
$jeux_resultats = array(
	'id_jeu'		=> 'bigint(21) NOT NULL',
	'id_auteur'		=> 'bigint(21) NOT NULL',
	'date'			=>	"datetime DEFAULT '0000-00-00 00:00:00' NOT NULL",
	'score_court'	=>	'int(12)',
	'score_long'	=>	'text NOT NULL');
$jeux_resultats_key=array('KEY id_jeu'	=>'id_jeu',
	'KEY id_auteur'	=>'id_auteur');

$tables_principales['spip_jeux']=
	array('field' => $jeux, 'key' => $jeux_key);
$tables_principales['spip_jeux_resultats']=
	array('field' => $jeux_resultats, 'key' => $jeux_resultats_key);

$table_des_traitements['CONTENU'][]= 'propre(%s)';
?>