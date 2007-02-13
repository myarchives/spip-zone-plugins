<?php
//
// exec/edittable.php
//
if (!defined("_ECRIRE_INC_VERSION")) return;

$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__))));
define('_DIR_PLUGIN_EDITTABLE',(_DIR_PLUGINS.end($p)));

include_spip("inc/presentation");
include_spip("inc/barre");

function exec_edittable(){
	echo debut_page(_T('edittable:spip_edittable'));
		echo debut_gauche();
			echo debut_boite_info();
				echo "Hello World !";
			echo fin_boite_info();
			echo debut_raccourcis();
				//echo '<a href="?exec=edittable_edit&id=new">'._T('edittable:ajouter_un_edittable').'</a><br />';
				echo '<a href="?exec=edittable">'._T('edittable:les_table').'</a>';
			echo fin_raccourcis();
		echo debut_droite();
			$sql_list_edittable = "SELECT * FROM spip_articles;";
			$res_list_edittable = spip_query($sql_list_edittable);
			debut_cadre_trait_couleur("../"._DIR_PLUGIN_edittable."/img_pack/digg.png", false, '', _T('edittable:mes_edittable_en'));
			echo '<table>';
			while ($row_edittable = spip_fetch_array($res_list_edittable)){
				echo '<tr><td>'.$row_edittable['id_article'].'</td><td><a href="?exec=edittable_voir&amp;id_article='.$row_edittable['id_article'].'">'.$row_edittable['titre'].'</a></td></tr>';
			}
			echo '</table>';
			fin_cadre_trait_couleur(false);
			
			
	if ($GLOBALS['spip_version_code']>=1.92) { echo fin_gauche(); }
	echo fin_page();
}
?>
