<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2008                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;	#securite


// http://code.spip.net/@balise_LOGIN_PUBLIC
function balise_LOGINMINI_PUBLIC ($p, $nom='LOGINMINI_PUBLIC') {
	return calculer_balise_dynamique($p, $nom, array('url'));
}

# retourner:
# 1. l'url collectee ci-dessus (args0) ou donnee en premier parametre (args1) 
#    #LOGIN_PUBLIC{#SELF}
# 2. un eventuel parametre (args2) indiquant le login et permettant une ecriture
#    <boucle(AUTEURS)>[(#LOGIN_PUBLIC{#SELF, #LOGIN})]

// http://code.spip.net/@balise_LOGIN_PUBLIC_stat
function balise_LOGINMINI_PUBLIC_stat ($args, $filtres) {
	return array(isset($args[1]) ? $args[1] : $args[0], (isset($args[2]) ? $args[2] : ''));
}

// http://code.spip.net/@balise_LOGIN_PUBLIC_dyn
function balise_LOGINMINI_PUBLIC_dyn($url, $login) {
	include_spip('balise/formulaire_');
	if (!$url 		# pas d'url passee en filtre ou dans le contexte
	AND !$url = _request('url') # ni d'url passee par l'utilisateur
	)
		$url = parametre_url(self(), '', '', '&');
	return balise_FORMULAIRE__dyn('loginmini',$url,$login,false);
}

?>
