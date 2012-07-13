<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('pdf/extends');

function exec_pdf_paniers_mois(){
	if (!autoriser('associer', 'paniers')) {
		include_spip('inc/minipres');
		echo minipres();
	} else {

	$date_distribution = $_GET["date_distribution"];

	// Calcul date de début et de fin
	$date_distri_debut = strtotime($date_distribution);
	$date_distri_fin = strtotime($date_distribution. ' next month - 1 day');

	$date_distri_debut_chaine = date('d/m/Y',$date_distri_debut);
	$date_distri_fin_chaine = date('d/m/Y',$date_distri_fin);





	$pdf=new PDF();
	$pdf->titre = _T('amap:distribution_paniers_mois', array('date_debut'=>$date_distri_debut_chaine,'date_fin'=>$date_distri_fin_chaine));
	$pdf->Open();
	$pdf->AddPage();

	//Tabelau des responsables de distribution pour la date demander
	//On definit les colonnes (champs,largeur,intitule,alignement)
	$pdf->TitreChapitre(1,_T('amap:responsables'));
	$pdf->AddCol('nom',40,_T('amap:nom'),'L');
	$pdf->AddCol('date_distribution',40,_T('amap:date'),'L');
	$pdf->AddCol('signature',40,_T('amap:signature'),'L');
	$prop=array(
		'HeaderColor'=>array(255,150,100),
		'color1'=>array(224,235,255),
		'color2'=>array(255,255,255),
		'padding'=>2);
	$pdf->Query_extended(sql_select("a.nom as nom,  DATE_FORMAT(b.date_distribution,'à %k:%i le %d/%m/%Y') as date_distribution, a.id_auteur as id_auteur", "spip_amap_responsables b LEFT JOIN spip_auteurs a ON a.id_auteur=b.id_auteur", "date_distribution BETWEEN ".sql_quote(date('Y-m-j H:i:s',$date_distri_debut)).' AND '.sql_quote(date('Y-m-j H:i:s',$date_distri_fin)),"" , "nom"), $prop, $type_panier_extension, "id_auteur");

	//Tabelau des adhérents ayant un panier pour la date demander
	//On definit les colonnes (champs,largeur,intitule,alignement)
	$pdf->TitreChapitre(2,_T('amap:adherents_jour'));
	$pdf->AddCol('nom',40,_T('amap:nom'),'L');
	$pdf->AddCol('type_panier',30,_T('amap:type_panier'),'L');
	$pdf->AddCol('date_distribution',40,_T('amap:date'),'L');
	$pdf->AddCol('signature',40,_T('amap:signature'),'L');
	$prop=array(
		'HeaderColor'=>array(255,150,100),
		'color1'=>array(224,235,255),
		'color2'=>array(255,255,255),
		'padding'=>2);
	/* recupere le type panier et l'id_auteur associe */
    if ($type_paniers_auteurs = sql_select('id_auteur, type_panier', 'spip_auteurs')) {
		while ($row = sql_fetch($type_paniers_auteurs)) {
			$type_panier_extension[$row['id_auteur']] = array("type_panier" => _T('amap:'.$row['type_panier']));
		}
    }
	$pdf->Query_extended(sql_select("a.nom as nom,  DATE_FORMAT(b.date_distribution,'à %k:%i le %d/%m/%Y') as date_distribution, a.id_auteur as id_auteur", "spip_amap_paniers b LEFT JOIN spip_auteurs a ON a.id_auteur=b.id_auteur", "date_distribution BETWEEN ".sql_quote(date('Y-m-j H:i:s',$date_distri_debut)).' AND '.sql_quote(date('Y-m-j H:i:s',$date_distri_fin)),"" , "nom"), $prop, $type_panier_extension, "id_auteur");
	$pdf->Output();
	}
}
?>
