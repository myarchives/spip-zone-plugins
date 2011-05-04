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



function association_onglets(){
	
	/* onglet de retour a la page d'accueil */
	$res = association_onglet1(_T('asso:menu2_titre_association'), 'association', 'Association', 'annonce.gif');

	/* onglet de gestion des membres */
	$res .= association_onglet1(_T('asso:menu2_titre_gestion_membres'), 'adherents', 'Membres', 'annonce.gif');  

	if ($GLOBALS['association_metas']['dons']) {
		$res .= association_onglet1(_T('asso:menu2_titre_gestion_dons'), 'dons', 'Dons', 'dons.gif'); 
	}
	if ($GLOBALS['association_metas']['ventes']) {
		$res .= association_onglet1(_T('asso:menu2_titre_ventes_asso'), 'ventes', 'Ventes', 'ventes.gif'); 
	}
	if ($GLOBALS['association_metas']['activites']) {
		$res .= association_onglet1(_T('asso:menu2_titre_gestion_activites'), 'activites', 'Activites', 'activites.gif'); 
	}
	if ($GLOBALS['association_metas']['prets']) {
		$res .= association_onglet1(_T('asso:menu2_titre_gestion_prets'), 'ressources', 'Prets', 'pret1.gif'); 
	}
	if ($GLOBALS['association_metas']['comptes']) {
		$res .= association_onglet1(_T('asso:menu2_titre_livres_comptes'), 'comptes', 'Comptes', 'comptes.gif'); 
	}
	
	echo gros_titre(
		_T('asso:gestion_de_lassoc') .
		' ' .
		$GLOBALS['association_metas']['nom'], '', false);

	if ($res) echo "<div class='bandeau_actions'>", debut_onglet(), $res, fin_onglet(), '</div>';
}

function association_onglet1($texte, $objet, $libelle, $image)
{
	if (autoriser('associer', $objet))
		return onglet($texte, generer_url_ecrire($objet), '', $libelle, _DIR_PLUGIN_ASSOCIATION_ICONES . $image, 'rien.gif');
	else return '';
}

function fin_page_association()
{
	$copyright = fin_page();
	// Pour eliminer le copyright a l'impression
	$copyright = str_replace("<div class='table_page'>", "<div class='table_page contenu_nom_site'>", $copyright);
	return fin_gauche() . $copyright;
}
?>
