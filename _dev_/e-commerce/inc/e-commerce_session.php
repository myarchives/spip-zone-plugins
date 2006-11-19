<?php

/*
 * boutique
 * version plug-in de spip_boutique
 *
 * Auteur :
 * RIEFFEL Laurent
 * 
 * � 2006 - Distribue sous licence GNU/GPL
 *
 */


function afficher_sessions ($titre_table, $requete, $icone = '') 
	{
	global $couleur_claire, $couleur_foncee;
	global $connect_id_auteur;

	$tous_id = array();
	$select = $requete['SELECT'] ? $requete['SELECT'] : '*';
	$from = $requete['FROM'] ? $requete['FROM'] : 'spip_boutiques AS boutiques';
	$join = $requete['JOIN'] ? (' LEFT JOIN ' . $requete['JOIN']) : '';
	$where = $requete['WHERE'] ? (' WHERE ' . $requete['WHERE']) : '';
	$order = $requete['ORDER BY'] ? (' ORDER BY ' . $requete['ORDER BY']) : '';
	$group = $requete['GROUP BY'] ? (' GROUP BY ' . $requete['GROUP BY']) : '';
	$limit = $requete['LIMIT'] ? (' LIMIT ' . $requete['LIMIT']) : '';

	$cpt = "$from$join$where$group";

	$tmp_var = substr(md5($cpt), 0, 4);

	if (!$group)
		{
		$cpt = spip_fetch_array(spip_query("SELECT COUNT(*) AS n FROM $cpt"));
		if (! ($cpt = $cpt['n'])) return $tous_id ;
		}
	else
		$cpt = spip_num_rows(spip_query("SELECT $select FROM $cpt"));
	if ($requete['LIMIT']) $cpt = min($requete['LIMIT'], $cpt);
	$nb_aff = 1.5 * _TRANCHES;
	$deb_aff = intval(_request('t_' .$tmp_var));
	if ($cpt > $nb_aff)
		{
		$nb_aff = (_TRANCHES); 
		$tranches = afficher_tranches_requete($cpt, 3, $tmp_var, '', $nb_aff);
		}
//
// DEBUGGING MODE
//
//	echo "<p><strong>"._L("affiche boutique [id_boutique -> $cpt $tmp_var $deb_aff $nb_aff]")."</strong> ";
//	exit;
//
// FIN
//	

	if (!$icone) $icone = "../"._DIR_PLUGIN_BOUTIQUE."/img_pack/euro.png";
	if ($cpt) 
		{
		if ($titre_table) echo "<div style='height: 12px;'></div>";
		echo "<div class='liste'>";
		bandeau_titre_boite2($titre_table, $icone, $couleur_claire, "black");
		echo "<table width='100%' cellpadding='5' cellspacing='0' border='0'>";
		echo $tranches;

		$result = spip_query("SELECT $select FROM $from$join$where$group$order LIMIT $deb_aff, $nb_aff");
		$num_rows = spip_num_rows($result);
		$ifond = 0;
		$premier = true;
		$compteur_liste = 0;
		$s='' ;
		$t='';
		while ($row = spip_fetch_array($result)) 
			{
			$s='';
			$vals='';
			$somme_chapo=0;
			$somme_quantite=0;

			$id_boutique = $row['id_boutique'];
			$nom = $row['nom'];
			$prenom = $row['prenom'];
			$statut = $row['statut'];
			$email = $row['email'];
			$adresse_livraison = $row['adresse_livraison'];
			$adresse_facturation = $row['adresse_facturation'];
			$maj = $row['maj'];
			$tous_id[] = $id_boutique;
			$s .= debut_cadre_relief("../"._DIR_PLUGIN_BOUTIQUE."/img_pack/panier.png", true);
			$s .= "<div style='padding: 0px; background-color: $couleur_claire; text-align: center; color: black;'>";
			$s .= "<div class='verdana2'>";
			$s .= _T("boutique:".$nom." ".$prenom." ".urldecode($email));
				$s .= "<div style='border: 0px solid #00ff00 ; padding: 0px; width:50% ;float:left ;background-color: $couleur_claire; text-align: left; color: black;'>";
					$s .= _T("Livraison:".$adresse_livraison);
				$s .= "</div>";
				$s .= "<div style='border: 0px solid #0000ff ; padding: 0px; width:50% ;float:left ;color: #0000ff; background-color: $couleur_foncee; text-align: left; color: black;'>";
					$s .= _T("Facturation:".$adresse_facturation);
				$s .= "</div>";
			$s .= "</div>";
			$s .= "</div>\n";
			$s .= "<br />";
			$result_chapo=spip_query("SELECT chapo, spip_paniers.quantite FROM spip_articles, spip_paniers where spip_articles.id_article=spip_paniers.id_article and spip_paniers.id_boutique=".$id_boutique);
			$num_rows_chapo = spip_num_rows($result_chapo);
			while ($row_chapo = spip_fetch_array($result_chapo)) 
				{
				$chapo = $row_chapo['chapo'];
				$quantite = $row_chapo['quantite'];
				$somme_chapo=$somme_chapo+(intval($chapo) *  intval($quantite));
				$somme_quantite=$somme_quantite+(intval($quantite));
				}
			spip_free_result($result_chapo);
			$t = "Statut :".$statut."\n<br />Date de passage :".$maj."\n<br />Nombre d'article :".$num_rows_chapo."/".$somme_quantite." Montant total du panier :".$somme_chapo ;
			$link = generer_url_ecrire('panier_edit',"id_boutique=".$id_boutique."&retour=".urlencode(self()));
			$s .= icone_horizontale(_T("boutique_edit:".$t),
				$link, "../"._DIR_PLUGIN_BOUTIQUE."/img_pack/panier.png", "", false);
			$s .= fin_block();
			$s .= fin_cadre_relief(true);
			$vals[] = $s;
			$table[] = $vals;
			}
		spip_free_result($result);
		$largeurs = array('','','','','');
		$styles = array('arial11', 'arial11', 'arial1', 'arial1','arial1');
		echo afficher_liste($largeurs, $table, $styles);
		echo "</table>";
		echo "</div>\n";
		}
	return $tous_id;
	}

?>