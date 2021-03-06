<?php 

	// lilo_mes_fonctions.php

	// $LastChangedRevision$
	// $LastChangedBy$
	// $LastChangedDate$

	/*****************************************************
	Copyright (C) 2007 Christian PAULUS
	cpaulus@quesaco.org - http://www.quesaco.org/
	/*****************************************************
	
	This file is part of LiLo.
	
	LiLo is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.
	
	LiLo is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with LiLo; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	
	/*****************************************************
	
	Ce fichier est un des composants de LiLo. 
	
	LiLo est un programme libre, vous pouvez le redistribuer et/ou le modifier 
	selon les termes de la Licence Publique Generale GNU publie'e par 
	la Free Software Foundation (version 2 ou bien toute autre version ulterieure 
	choisie par vous).
	
	LiLo est distribue' car potentiellement utile, mais SANS AUCUNE GARANTIE,
	ni explicite ni implicite, y compris les garanties de commercialisation ou
	d'adaptation dans un but specifique. Reportez-vous a' la Licence Publique Generale GNU 
	pour plus de details. 
	
	Vous devez avoir recu une copie de la Licence Publique Generale GNU 
	en meme temps que ce programme ; si ce n'est pas le cas, ecrivez a la  
	Free Software Foundation, Inc., 
	59 Temple Place, Suite 330, Boston, MA 02111-1307, Etats-Unis.
	
	*****************************************************/


/*
	Pour appel Ajax dans le formulaire de login
*/
function calculer_URL_ACTION_LILO_INFOS () {
	$action = generer_action_auteur('lilo_auteur_infos', '');
   return  $action;
}

function balise_URL_ACTION_LILO_INFOS ($p) {
   $p->code = 'calculer_URL_ACTION_LILO_INFOS()';
   $p->statut = 'php';
   return ($p);
}

/*
	La balise URL_ACTION_SPIP_COOKIE renvoie url 'spip_cookie' (formulaire login)
*/
function calculer_URL_ACTION_SPIP_COOKIE () {
	return generer_url_public('spip_cookie');
}

function balise_URL_ACTION_SPIP_COOKIE ($p) {
	$p->code = 'calculer_URL_ACTION_SPIP_COOKIE()';
   $p->statut = 'php';
   return ($p);
}


/*
	La balise LOGO_LILO_SPIP renvoie le logo pour le grand login panel LiLo
	Dans le formulaire login, ce logo est plac� si pas de logo de site	
*/
define("_LILO_LOGO_SITE", "images/spip-logo-2-128.png");

function calculer_LOGO_LILO_SPIP () {
	return ("<img src='" . find_in_path(_LILO_LOGO_SITE)."' width='128' height='128' class='lilo-logo' alt='' />");
}

function balise_LOGO_LILO_SPIP ($p) {
	$p->code = 'calculer_LOGO_LILO_SPIP()';
   $p->statut = 'php';
   return ($p);
}

/*
	La balise LILO_LOGIN_VOIR_ERREUR affiche (ou non) erreur dans le formulaire login
*/
function calculer_LILO_LOGIN_VOIR_ERREUR () {
	return (lilo_get_config_pref_oui_non('lilo_login_voir_erreur'));
}

function balise_LILO_LOGIN_VOIR_ERREUR ($p) {
	$p->code = 'calculer_LILO_LOGIN_VOIR_ERREUR()';
	$p->statut = 'php';
	return ($p);
}


/*
 * l'attribut 'autocomplete' demande au butineur de (ou ne pas) completer le
 * champ input des que plus de trois caracteres
 * compatible IE 5.0+, Safari 1.0+
 * ca ne passe pas en XHTML strict. Sera attribue' en JS
 * see: http://msdn.microsoft.com/en-us/library/ms533486(VS.85).aspx
 * @return string 'oui' ou 'non'
 */
function calculer_LILO_LOGIN_NOCOMPLETE () {
	return (lilo_get_config_pref_oui_non('lilo_login_nocomplete'));
}
function balise_LILO_LOGIN_NOCOMPLETE ($p) {
	$p->code = 'calculer_LILO_LOGIN_NOCOMPLETE()';
	$p->statut = 'php';
	return ($p);
}

/*
	La balise LILO_LOGIN_VOIR_ERREUR affiche (ou non) erreur dans le formulaire login
*/
function calculer_LILO_LOGIN_SESSION_REMEMBER () {
	return (lilo_get_config_pref_oui_non('lilo_login_session_remember'));
}

function balise_LILO_LOGIN_SESSION_REMEMBER ($p) {
	$p->code = 'calculer_LILO_LOGIN_SESSION_REMEMBER()';
   $p->statut = 'php';
   return ($p);
}

function lilo_get_config_pref_oui_non ($key) {
	static $config;
	if(!$config) {
		include_spip('inc/plugin_globales_lib');
		$config = __plugin_lire_key_in_serialized_meta('config', _LILO_META_PREFERENCES);
	}
	return ( (isset($config[$key]) && ($config[$key]=='oui')) ? "oui" : "non" );
}

?>