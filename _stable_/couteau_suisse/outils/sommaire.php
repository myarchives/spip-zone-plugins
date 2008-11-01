<?php
/*
 
+-------------------------------+
 Nom de l'outil : sommaire
+-------------------------------+
 Date : mardi 03 avril 2007
 Auteur :  Patrice Vanneufville
+-------------------------------+
 Presente un petit sommaire 
 en haut de l'article base sur 
 les balises {{{}}}
+-------------------------------+

*/

// cette fonction est appelee automatiquement a chaque affichage de la page privee du Couteau Suisse
function sommaire_raccourcis() {
	return defined('_sommaire_AUTOMATIQUE')
		?_T('couteauprive:sommaire_sans', array('racc' => _sommaire_SANS_SOMMAIRE))
		:_T('couteauprive:sommaire_avec', array('racc' => _sommaire_AVEC_SOMMAIRE));
}

function sommaire_nettoyer_raccourcis($texte) {
	return str_replace(array(_sommaire_SANS_FOND, _sommaire_SANS_SOMMAIRE, _sommaire_AVEC_SOMMAIRE), '', $texte);
}

?>