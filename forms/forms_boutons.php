<?php
/*
 * forms
 * version plug-in de spip_form
 *
 * Auteur :
 * Antoine Pitrou
 * adaptation en 182e puis plugin par cedric.morin@yterium.com
 * � 2005,2006 - Distribue sous licence GNU/GPL
 *
 */

define('_DIR_PLUGIN_FORMS',(_DIR_PLUGINS.end(explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__)))))));

	function Forms_ajouterBoutons($boutons_admin) {
		// si on est admin
		if ($GLOBALS['connect_statut'] == "0minirezo" && $GLOBALS["connect_toutes_rubriques"]
		AND $GLOBALS["options"]=="avancees" AND lire_meta("activer_forms")!="non") {

		  // on voit le bouton dans la barre "naviguer"
			$boutons_admin['naviguer']->sousmenu["forms_tous"]= new Bouton(
			"../"._DIR_PLUGIN_FORMS."/form-24.png",  // icone
			_L("Formulaires et sondages") //titre
			);

		  // on voit le bouton dans la barre "forum_admin"
			$boutons_admin['forum']->sousmenu["forms_reponses"]= new Bouton(
			"../"._DIR_PLUGIN_FORMS."/form-24.png",  // icone
			_L("Suivi des Reponses") //titre
			);
		}
		return $boutons_admin;
	}

	/* public static */
	function Forms_ajouterOnglets($flux) {
		$rubrique = $flux['args'];
		return $flux;
	}

?>