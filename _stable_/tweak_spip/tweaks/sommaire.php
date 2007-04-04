<?php
 /*
 *   +----------------------------------+
 *    Nom du Filtre : sommaire_article
 *   +----------------------------------+
 *    Date : mardi 03 avril 2007
 *    Auteur :  Patrice Vanneufville
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *     Presenter un petit sommaire en haut
 *     de l'article base sur les balises <h3>
 *   +-------------------------------------+ 
 *
*/

// cette fonction est appelee automatiquement a chaque affichage de la page privee de Tweak SPIP
// le resultat est une chaine apportant des informations sur les nouveau raccourcis ajoutes par le tweak
// si cette fonction n'existe pas, le plugin cherche alors  _T('tweak:mon_tweak:aide');
function sommaire_raccourcis() {
	return _T('tweak:sommaire:aide', array('interdit' => '<strong>'._sommaire_SANS_SOMMAIRE.'</strong>'));
}
?>