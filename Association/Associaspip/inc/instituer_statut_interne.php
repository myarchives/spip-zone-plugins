<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2011                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined('_ECRIRE_INC_VERSION'))
	return;

include_spip('inc/actions');
include_spip('inc/texte');
include_spip('inc/layer');
include_spip('inc/presentation');
include_spip('inc/autoriser');

function inc_instituer_statut_interne_dist($statut)
{
	$hstatut = htmlentities($statut);
	$tab_statut = array(''=>_T('asso:tous'));
	$tab_statut = array_merge($tab_statut, $GLOBALS['association_liste_des_statuts']);
	foreach ($tab_statut as $var) {
		$menu .= association_mySel(htmlentities($var), $hstatut, _T('asso:adherent_entete_statut_'.$var), '');
	}

	$statut_rubrique = str_replace(',', '|', _STATUT_AUTEUR_RUBRIQUE);
	return '<select name="statut_interne" id="statut_interne" size="1">'.$menu."</select>\n";

}

?>