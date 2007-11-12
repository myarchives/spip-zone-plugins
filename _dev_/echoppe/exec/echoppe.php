<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/echoppe');
include_spip('inc/commencer_page');
include_spip('inc/abstract_sql');

function exec_echoppe(){
	
	if ($GLOBALS['meta']['version_installee'] <= '1.927'){
		echo debut_page(_T('echoppe:echoppe'), "redacteurs", "echoppe");	
	}else{
		echo inc_commencer_page_dist(_T('echoppe:echoppe'), "redacteurs", "echoppe");
	}
	
	echo debut_gauche();
	
	
		echo debut_boite_info();
			echo (_T('echoppe:descriptif_echoppe'));
			/* A coder :
	
			1) Verif des droits
			2) Y a t il des categorie de creer ?
				-> non : on propose d'en creer une. Obligatoire.
				-> oui : on liste les categorie "racine".
			
			*/
		echo fin_boite_info();
		
		
		$raccourcis .= icone_horizontale(_T('echoppe:creer_nouvelle_categorie'), generer_url_ecrire("echoppe_edit_categorie","new=oui&id_parent=0"), _DIR_PLUGIN_ECHOPPE."images/categorie-24.png","creer.gif", false);
		$sql_nombre_categories = "SELECT id_categorie FROM spip_echoppe_categories;";
		$res_nombre_categories = spip_query($sql_nombre_categories);
		if (spip_num_rows($res_nombre_categories) > 0){
			$raccourcis .= icone_horizontale(_T('echoppe:nouveau_produit'), generer_url_ecrire("echoppe_produits","new=oui"), _DIR_PLUGIN_ECHOPPE."images/produits-24.png","creer.gif", false);
		}
		
		echo bloc_des_raccourcis($raccourcis);
		
		
		/* A coder :
		1) Affichage des boutons de creation des outils
		*/
	
	echo creer_colonne_droite();
	echo debut_droite(_T('echoppe:echoppe'));
	echo gros_titre(_T("echoppe:echoppe"));
	echo '<br />';
	if ($GLOBALS['connect_statut'] == "0minirezo"){
		
		$sql_categories = "SELECT cat.id_categorie, cat_desc.titre, cat_desc.descriptif FROM spip_echoppe_categories cat, spip_echoppe_categories_descriptions cat_desc WHERE id_parent = '0' AND cat.id_categorie = cat_desc.id_categorie AND cat_desc.lang = '' ORDER BY cat.id_categorie;";
		//echo $sql_categories;
		$res_categories = spip_query($sql_categories);
		
		while($categorie = spip_fetch_array($res_categories)){
			//var_dump($categorie);
			echo '
				<div class="cadre-sous_rub" style="width: 40%;float: left; margin: 10px 0px 0px 10px;">
					<div class="cadre-padding">
						<b><a href="'.generer_url_ecrire('echoppe_categorie', 'id_categorie='.$categorie['id_categorie']).'">'.$categorie['titre'].'</a></b><br />
						<div class="verdana1">'.couper($categorie['descriptif'],'150').'</div>
					</div>
				</div>';
		}
		
		
	}else{
		echo echoppe_echec_autorisation();
	}
	
	
	echo fin_gauche();
	echo fin_page();
}

?>
