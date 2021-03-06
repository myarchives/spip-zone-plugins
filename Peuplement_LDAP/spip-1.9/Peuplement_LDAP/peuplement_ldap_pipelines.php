<?php

if (!defined('_DIR_PLUGIN_PEUPLEMENTLDAP')){ // definie automatiquement en 1.9.2
        $p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__))));
        define('_DIR_PLUGIN_PEUPLEMENTLDAP',(_DIR_PLUGINS.end($p)));
}
/**
 * Affiche le bouton d'accès aux formulaires de peuplement
 * 
 * Le bouton de configuration n'est affiché que 
 * si l'on est administrateur, en interface complète et avec
 * l'accès LDAP correctement configuré.
 *
 * @param Array $boutons_admin Tableau contenant les boutons Spip
 * @return Array Tableau contenant les bouton Spip dont celui du peuplement
 */
function PeuplementLdap_ajouterBoutons($boutons_admin) {
	if (autoriser('') AND $GLOBALS["ldap_present"]) { // Controle sur les droits de l'auteur
		$boutons_admin['auteurs']->sousmenu['peuplement_ldap']= new Bouton(
        	"../"._DIR_PLUGIN_PEUPLEMENTLDAP."/img_pack/".$GLOBALS['peuplement_ldap_icon'],
			_T('peuplementldap:icone_menu_config')
		);
	}
	return $boutons_admin;
}
?>