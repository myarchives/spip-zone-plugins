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


if (!defined('_ECRIRE_INC_VERSION'))
	return;

include_spip ('inc/navigation_modules');

function exec_groupes()
{
	if (!autoriser('associer', 'comptes')) {
		include_spip('inc/minipres');
		echo minipres();
	} else {
		onglets_association('gestion_groupes');
		// notice
		echo _T('asso:aide_groupes');
		// datation et raccourcis
		icones_association(array('adherents'), array(
			'ajouter_un_groupe' => array('annonce.gif', 'edit_groupe'),
		));
		debut_cadre_association('annonce.gif', 'tous_les_groupes');
		echo recuperer_fond('prive/contenu/voir_groupes', array ());
		fin_page_association();
	}
}

?>