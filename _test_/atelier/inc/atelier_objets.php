<?php

/*
 *  Plugin Atelier pour SPIP
 *  Copyright (C) 2008  Polez Kévin
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

function inc_atelier_objets_dist($a=array()) {
	$form = "<input type='hidden' name='creer_objet' value='oui' />\n"
	. atelier_objet_type()
	. atelier_objet_nom()
	. ("<div align='center'><input class='fondo' type='submit' value='"
	. _T('atelier:bouton_creer_objet')
	. "' /></div>");

	$arg =  $a['id_projet'];

	return generer_action_auteur("creer_objet", $arg, '', $form, " method='post' name='formulaire'");


}

function atelier_objet_nom() {
	return 'Nom de l\'objet : <input type="text" name="nom" /><br /><br />';
}

function atelier_objet_type() {
	return 'Type d\'objet : <br />'
	. '<select name="type">'
	. '<option value="feuille_prive">Feuille dans l\'espace privée (exec)</option>'
	. '<option value="formulaire_prive">Formulaire dans l\'espace privée (inc)</option>'
	. '<option value="action_prive">Action dans l\'espace privée (action)</option>'
	. '<option value="tout">le couple exec->inc->action</option>'
	. '<option value="complet">un objet complet</option>'
	.'</select><br /><br />';
}
?>
