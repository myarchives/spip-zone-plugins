<?php
/***************************************************************************\
 *  Associaspip, extension de SPIP pour gestion d'associations             *
 *                                                                         *
 *  Copyright (c) 2007 Bernard Blazin & Fran�ois de Montlivault (V1)       *
 *  Copyright (c) 2010-2011 Emmanuel Saint-James & Jeannot Lapin (V2)       *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/



if (!defined("_ECRIRE_INC_VERSION")) return;

// Declaration des tables
function association_declarer_tables_principales($tables_principales){



//-- Table CATEGORIES COTISATION ------------------------------------------
$spip_asso_categories = array(
	"id_categorie" 	=> "int(10) unsigned NOT NULL auto_increment",
	"valeur" 			=> "tinytext NOT NULL",
	"libelle" 			=> "text NOT NULL",
	"duree" 			=> "text NOT NULL",
	"cotisation" 		=> "float NOT NULL default '0'",
	"commentaires" 	=> "text NOT NULL",
	"maj" 				=> "timestamp NOT NULL"
);

$spip_asso_categories_key = array(
	"PRIMARY KEY" => "id_categorie"
);	

$tables_principales['spip_asso_categories'] = array(
	'field' => &$spip_asso_categories, 
	'key' => &$spip_asso_categories_key
);

//-- Table DONS ------------------------------------------
$spip_asso_dons = array(
	"id_don" 			=> "bigint(21) NOT NULL auto_increment",
	"date_don" 		=> "date NOT NULL default '0000-00-00'",
	"bienfaiteur" 		=> "text NOT NULL",
	"id_adherent" 	=> "int(11) NOT NULL",
	"argent" 			=> "tinytext",
	"colis" 			=> "text",
	"valeur" 			=> "text NOT NULL",
	"contrepartie" 	=> "tinytext",
	"commentaire" 	=> "text",
	"maj" 				=> "timestamp NOT NULL"
);
$spip_asso_dons_key = array(
	"PRIMARY KEY" => "id_don"
);
$tables_principales['spip_asso_dons'] = array(
	'field' => &$spip_asso_dons, 
	'key' => &$spip_asso_dons_key
);	

//-- Table VENTES ------------------------------------------
$spip_asso_ventes = array(
	"id_vente" 		=> "BIGINT(21) AUTO_INCREMENT",
	"article"		=> "TINYTEXT NOT NULL",
	"code"			=> "TEXT NOT NULL",
	"acheteur" 		=> "TINYTEXT NOT NULL",
	"id_acheteur"	=> "BIGINT(20) NOT NULL",
	"quantite" 		=> "TINYTEXT NOT NULL",
	"date_vente"	=> "DATE NOT NULL DEFAULT '0000-00-00'",
	"date_envoi" 	=> "DATE DEFAULT '0000-00-00'",
	"prix_vente" 	=> "TINYTEXT",
	"frais_envoi" 	=> "float NOT NULL default '0'",
	"commentaire" 	=> "TEXT",
	"maj" 			=> "timestamp NOT NULL"
);
$spip_asso_ventes_key = array(
	"PRIMARY KEY" => "id_vente"
);
$tables_principales['spip_asso_ventes'] = array(
	'field' => &$spip_asso_ventes, 
	'key' => &$spip_asso_ventes_key
);

//-- Table COMPTES ------------------------------------------
$spip_asso_comptes = array(
	"id_compte" 	=> "bigint(21) NOT NULL auto_increment",
	"date"		=> "date default NULL",
	"recette" 	=> "float NOT NULL default '0'",
	"depense" 	=> "float NOT NULL default '0'",
	"justification" => "text",
	"imputation" 	=> "text",
	"journal" 	=> "tinytext",
	"id_journal" 	=> "int(11) NOT NULL default '0'",
	"vu"		=> "boolean default 0",
	"maj" 		=> "timestamp NOT NULL"
);						
$spip_asso_comptes_key = array(
	"PRIMARY KEY" => "id_compte"
);
$tables_principales['spip_asso_comptes'] = array(
	'field' => &$spip_asso_comptes, 
	'key' => &$spip_asso_comptes_key
);

//-- Table PLAN COMPTABLE ------------------------------------------
$spip_asso_plan = array(
	"id_plan" 			=> "int(11) NOT NULL auto_increment",
	"code" 				=> "text NOT NULL",
	"intitule" 			=> "text NOT NULL",
	"classe"			=>"text NOT NULL",
	"type_op"		=> "ENUM('credit','debit', 'multi') NOT NULL default 'multi'",
	"solde_anterieur"	=> "float NOT NULL default '0'",
	"date_anterieure"	=> "date NOT NULL default '0000-00-00'",
	"commentaire" 		=> "text NOT NULL",
	"active"		=> "boolean default 1",
	"maj" 				=> "timestamp NOT NULL"
);						
$spip_asso_plan_key = array(
	"PRIMARY KEY" => "id_plan"
);
$tables_principales['spip_asso_plan'] = array(
	'field' => &$spip_asso_plan, 
	'key' => &$spip_asso_plan_key
);

//-- Tables DESTINATION ----------------------------------------
$spip_asso_destination = array(
	"id_destination"	=> "int(11) NOT NULL auto_increment",
	"intitule" 		=> "text NOT NULL",	
	"commentaire" 		=> "text NOT NULL",
);
$spip_asso_destination_key = array(
	"PRIMARY KEY" => "id_destination"
);
$tables_principales['spip_asso_destination'] = array(
	'field' => &$spip_asso_destination, 
	'key' => &$spip_asso_destination_key
);

$spip_asso_destination_op = array(
	"id_dest_op"	=> "int(11) NOT NULL auto_increment",
	"id_compte" 		=> "int(11) NOT NULL",	
	"id_destination"	=> "int(11) NOT NULL",
	"recette" 	=> "float NOT NULL default '0'",
	"depense" 	=> "float NOT NULL default '0'",
);
$spip_asso_destination_op_key = array(
	"PRIMARY KEY" => "id_dest_op"
);
$tables_principales['spip_asso_destination_op'] = array(
	'field' => &$spip_asso_destination_op, 
	'key' => &$spip_asso_destination_op_key
);
//-- Table RESSOURCES ------------------------------------------
$spip_asso_ressources = array(
	"id_ressource"		=> "bigint(20) NOT NULL auto_increment",
	"code" 				=> "text NOT NULL",
	"intitule" 			=> "text NOT NULL",
	"date_acquisition"	=> "date NOT NULL default '0000-00-00'",
	"pu" 				=> "float NOT NULL default '0'",
	"statut"			=> "text NOT NULL",
	"commentaire" 		=> "text NOT NULL",
	"maj" 				=> "timestamp NOT NULL"
);		
$spip_asso_ressources_key = array(
	"PRIMARY KEY" => "id_ressource"
);
$tables_principales['spip_asso_ressources'] = array(
	'field' => &$spip_asso_ressources, 
	'key' => &$spip_asso_ressources_key
);

//-- Table PRETS ------------------------------------------
$spip_asso_prets = array(
	"id_pret"				=> "bigint(20) NOT NULL auto_increment",
	"id_ressource"			=> "varchar(20) NOT NULL",
	"date_sortie" 			=> "date NOT NULL default '0000-00-00'",
	"duree"					=> "int(11) NOT NULL default '0'",
	"date_retour" 			=> "date NOT NULL default '0000-00-00'",
	"id_emprunteur" 		=> "text NOT NULL",
	"statut"				=> "text NOT NULL",
	"commentaire_sortie" 	=> "text NOT NULL",
	"commentaire_retour" 	=> "text NOT NULL",
	"maj" 					=> "timestamp NOT NULL"
);		
$spip_asso_prets_key = array(
	"PRIMARY KEY" => "id_pret"
);
$tables_principales['spip_asso_prets'] = array(
	'field' => &$spip_asso_prets, 
	'key' => &$spip_asso_prets_key
);

//-- Table ACTIVITES ------------------------------------------
$spip_asso_activites = array(
	"id_activite"	=> "bigint(20) NOT NULL auto_increment",
	"id_evenement"	=> "bigint(20) NOT NULL",
	"nom"			=> "text NOT NULL",
	"id_adherent"	=> "bigint(20) NOT NULL",
	"membres" 		=> "text NOT NULL",
	"non_membres" 	=> "text NOT NULL",
  		"inscrits"		=> "int(11) NOT NULL default '0'",
	"date"			=> "date NOT NULL default '0000-00-00'",
	"telephone"		=> "text NOT NULL",
	"adresse"		=> "text NOT NULL",
	"email"			=> "text NOT NULL",
	"commentaire"	=> "text NOT NULL",
	"montant"		=> "float NOT NULL default '0'",
	"date_paiement"	=> "date NOT NULL default '0000-00-00'",
	"statut"		=> "text NOT NULL",
	"maj"			=> "timestamp NOT NULL"

);						
$spip_asso_activites_key = array(
	"PRIMARY KEY" => "id_activite"
);
$tables_principales['spip_asso_activites'] = array(
	'field' => &$spip_asso_activites, 
	'key' => &$spip_asso_activites_key
);


//-- Table groupes de membres: deux tables: groupe et liaison -----------------
$spip_asso_groupes= array(
	"id_groupe"		=> "bigint(20) NOT NULL auto_increment",
	"nom"			=> "varchar(128) NOT NULL",
	"commentaires"	=> "text",
	"affichage"		=> "tinyint NOT NULL default 0",
	"maj"			=> "timestamp NOT NULL"
				);
$spip_asso_groupes_key = array(
	"PRIMARY KEY" => "id_groupe"
);
$tables_principales['spip_asso_groupes'] = array(
	'field' => &$spip_asso_groupes, 
	'key' => &$spip_asso_groupes_key
);

$spip_asso_groupes_liaisons= array(
	"id_groupe" => "bigint(20) NOT NULL",
	"id_auteur" => "bigint(20) NOT NULL",
	"fonction" => "varchar(128) NOT NULL",
	"date_debut" => "date NOT NULL default '0000-00-00'",
	"date_fin" => "date NOT NULL default '0000-00-00'",
	"commentaires"	=> "text",
	"maj"			=> "timestamp NOT NULL"
				);
$spip_asso_groupes_liaisons_key = array(
	"PRIMARY KEY" => "id_groupe,id_auteur"
);
$tables_principales['spip_asso_groupes_liaisons'] = array(
	'field' => &$spip_asso_groupes_liaisons, 
	'key' => &$spip_asso_groupes_liaisons_key
);


$spip_asso_membres= array(
  "id_auteur" => "bigint(21) NOT NULL auto_increment",
  "id_asso" => "text NOT NULL",
  "nom_famille" => "text NOT NULL",
  "prenom" => "text NOT NULL",
  "sexe" => "tinytext NOT NULL",
  "categorie" => "text NOT NULL",
  "statut_interne" => "text NOT NULL",
  "commentaire" => "text NOT NULL",
  "validite" => "date NOT NULL default '0000-00-00'"
			    );
$spip_asso_membres_key= array(
	"PRIMARY KEY" => "id_auteur"
				);
$tables_principales['spip_asso_membres'] = array(
	'field' => &$spip_asso_membres, 
	'key' => &$spip_asso_membres_key);

//-- Tables EXERCICES ----------------------------------------
$spip_asso_exercices = array(
	"id_exercice" => "int(11) NOT NULL auto_increment",
	"intitule" => "text NOT NULL",
	"commentaire" => "text NOT NULL",
	"debut" => "date NOT NULL default '0000-00-00'",
	"fin" => "date NOT NULL default '0000-00-00'"
);
$spip_asso_exercices_key = array(
	"PRIMARY KEY" => "id_exercice"
);
$tables_principales['spip_asso_exercices'] = array(
	'field' => &$spip_asso_exercices,
	'key' => &$spip_asso_exercices_key
);

	return $tables_principales;
	
}


function association_declarer_tables_auxiliaires($tables_auxiliaires)
{

$spip_asso_metas = array(
		"nom"	=> "VARCHAR (255) NOT NULL",
		"valeur"	=> "text DEFAULT ''",
		"impt"	=> "ENUM('non', 'oui') DEFAULT 'oui' NOT NULL",
		"maj"	=> "TIMESTAMP");

$spip_asso_metas_key = array(
		"PRIMARY KEY"	=> "nom");

$tables_auxiliaires['spip_association_metas'] = array(
	'field' => &$spip_asso_metas, 
	'key' => &$spip_asso_metas_key
);
return $tables_auxiliaires;
}


function association_declarer_tables_interfaces($tables_interfaces)
{
	
$tables_interfaces['table_des_tables']['asso_dons'] = 'asso_dons';
$tables_interfaces['table_des_tables']['asso_ventes'] = 'asso_ventes';
$tables_interfaces['table_des_tables']['asso_comptes'] = 'asso_comptes';
$tables_interfaces['table_des_tables']['comptes'] = 'asso_comptes';
$tables_interfaces['table_des_tables']['asso_categories'] = 'asso_categories';
$tables_interfaces['table_des_tables']['asso_plan'] = 'asso_plan';
$tables_interfaces['table_des_tables']['asso_ressources'] = 'asso_ressources';
$tables_interfaces['table_des_tables']['asso_prets'] = 'asso_prets';
$tables_interfaces['table_des_tables']['asso_activites'] = 'asso_activites';
$tables_interfaces['table_des_tables']['asso_membres'] = 'asso_membres';
$tables_interfaces['table_des_tables']['association_metas'] = 'association_metas';
$tables_interfaces['table_des_tables']['asso_destination'] = 'asso_destination';
$tables_interfaces['table_des_tables']['asso_destination_op'] = 'asso_destination_op';	
$tables_interfaces['table_des_tables']['asso_groupes'] = 'asso_groupes';	
$tables_interfaces['table_des_tables']['asso_groupes_liaisons'] = 'asso_groupes_liaisons';
$tables_interfaces['table_des_tables']['asso_exercices'] = 'asso_exercices';

// Pour que les raccourcis ci-dessous heritent d'une zone de clic pertinente
//$tables_interfaces['table_titre']['asso_membres']= "nom_famille AS titre, '' AS lang";
$tables_interfaces['table_titre']['asso_dons']= "CONCAT('don ', id_don) AS titre, '' AS lang";

	/* jointures */
	$tables_interfaces['tables_jointures']['spip_asso_membres']['id_auteur'] = 'asso_groupes_liaisons';
 return  $tables_interfaces;
	
}


?>
