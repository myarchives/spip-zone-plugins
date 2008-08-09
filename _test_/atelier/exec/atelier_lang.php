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

function exec_atelier_lang_dist() {
	exec_atelier_lang_args(	intval(_request('id_projet')),
				_request('fichier')
	);
}

function exec_atelier_lang_args($id_projet,$fichier='') {
	$projet_select = charger_fonction('projet_select','inc');
	$row = $projet_select($id_projet);
	if (!$row) {
		include_spip('inc/minipres');
		echo minipres(_T('atelier:aucun_projet'));
		exit;
	}
	if ((!$fichier) && ($row['type'] == 'plugin')) {

		$dir = _DIR_PLUGINS.$row['prefixe'].'/lang';
		if ($dh = opendir($dir)) {
			$i=0;
			$f = '';

			while (($file = readdir($dh)) !== false) {
				$t = explode('.',$file);
				if ($t[1] && ($t[1] != 'php~') && ($t[1] != 'svn')) {$i++; $f = $file;}
			}
			if ($i == 1 ) $fichier = $f;
		}
	}

	atelier_lang($id_projet,$row,$fichier);
}

function atelier_lang($id_projet,$row,$fichier='') {
	include_spip('inc/atelier_presentation');
	include_spip('inc/atelier_autoriser');
	include_spip('inc/atelier_lang');

	$nom_page = atelier_debut_page(_T('atelier:page_lang'),'atelier_lang');
	if (!atelier_autoriser()) exit;

	$atelier_lang = charger_fonction('atelier_lang','inc');

	atelier_debut_gauche();

		atelier_cadre_raccourcis(array(
			'<a href="'.generer_url_ecrire('projets','id_projet='.$row['id_projet']).'">'._T('atelier:revenir_projet').'</a>'
		));

		// on liste les fichiers lang
		
		if ($atelier_lang('verifier_repertoire',array('prefixe' => $row['prefixe'],'type' => $row['type']))) {
			global $repertoire_squelettes_alternatifs; // plugin switcher

			if ($row['type'] == 'plugin') $dir = _DIR_PLUGINS.$row['prefixe'].'/lang';
			else $dir ='../' .$repertoire_squelettes_alternatifs.'/'.$row['prefixe'].'/lang';

			if ($dh = opendir($dir)) {
				$fichiers = array();
				while (($file = readdir($dh)) !== false) {
					if (($file != '.') && ($file != '..'))
						$fichiers[] = '<a href="'.generer_url_ecrire('atelier_lang',"id_projet=$id_projet&fichier=$file").'">'.$file.'</a>';
				}
				closedir($dh);
				if (count($fichiers) > 0) cadre_atelier(_T('atelier:contenu_repertoire_lang'),$fichiers);
			}
		}

		atelier_cadre_infos();

	atelier_fin_gauche();
	atelier_debut_droite();

		echo debut_cadre_trait_couleur('',true);

		$atelier_lang = charger_fonction('atelier_lang','inc');

		if (!$atelier_lang('verifier_repertoire',array('prefixe' => $row['prefixe'],'type' => $row['type']))) {
			echo '<p>'._T('atelier:explication_rep_lang').'</p>';
			echo $atelier_lang('creer_repertoire',array('id_projet' =>$id_projet));
		}
		else {
			echo debut_cadre_couleur('',true);
			echo '<p>'._T('atelier:explication_creer_fichier_lang').'</p>';
			echo $atelier_lang('creer_fichier',array('id_projet' =>$id_projet));
			echo fin_cadre_couleur(true);
		}

		if ($fichier) {
			echo gros_titre($fichier,'',false);
			$module = $row['prefixe'];

			preg_match('#'.$prefixe.'_(.*).php#',$fichier,$m);
			$lang = $m[1];

			if ($atelier_lang('verifier_repertoire',array('prefixe' => $row['prefixe'],'type' => $row['type']))) {
				echo '<br />';
				echo debut_cadre_couleur('',true);
				echo '<p>'._T('atelier:explication_ajouter_lang').'</p>';
				echo $atelier_lang('ajout',array('id_projet' => $id_projet,'module' => $module,'lang' => $lang,'type' => $row['type']));
				echo fin_cadre_couleur(true);

				echo debut_cadre_couleur('',true);
				echo '<p>'._T('atelier:explication_editer_lang').'</p>';
				echo $atelier_lang('edit',array('id_projet' => $id_projet,'fichier' => $fichier,'module' => $module,'lang' => $lang,'type' => $row['type']));
				echo fin_cadre_couleur(true);
			}
		}

		echo fin_cadre_trait_couleur(true);
	atelier_fin_droite();
	atelier_fin_page();

	
}

?>
