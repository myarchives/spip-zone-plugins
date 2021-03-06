<?php

include_spip('inc/vieilles_defs');
include_spip('inc/svn_update');
include_spip('inc/cfg_config');

# securite
if (!defined("_ECRIRE_INC_VERSION")) return;

function exec_svn_update() {
	global $connect_statut, $connect_id_auteur, $connect_toutes_rubriques;
	global $exec;
	include_spip('inc/presentation');
	include_spip('inc/config');

	pipeline('exec_init',
		array('args'=>array('exec'=>'configuration'),'data'=>''));

	debut_page(_L('Update SVN'), "configuration", "configuration");
	echo "<br><br><br>";
	gros_titre(_L('Update SVN'));


	if ($connect_statut != '0minirezo'
	OR !in_array($connect_id_auteur, explode(';', _SVN_UPDATE_AUTEURS))) {
		echo _T('avis_non_acces_page');
		fin_page();
		exit;
	}

	debut_gauche();
	debut_droite();

	# si on a un fichier de config (comme dans la doc), le respecter
	# sinon passer par cfg (mais attention c'est que du vieux cfg qui necessite
	# des plugins cfg_compat etc… à revoir !
	if ($f = find_in_path('svn_update_list.txt'))
		lire_fichier($f, $config);
	else
		$config = lire_config('svn_update/file');

	$config = explode("\n", $config);

	$dirs_ok = array();
	foreach ($config as $l) {
		$l = trim($l);
		if ($l AND substr($l,0,1) != "#") {
			list($src,$dest) = explode(' ', $l);
			$dirs_ok[$dest] = $l;
			$sources[$dest] = $src;
		}
	}

	if ($dirs_ok) {
		include_spip('inc/charsets');
		chdir(_DIR_RACINE);
		// Appliquer la demande
		if (_request('dir_svn') == -1) {
			traiter_config_svn($config);
		} else
		if ($dir_svn = _request('dir_svn')
		AND isset($dirs_ok[$dir_svn])) {
			traiter_config_svn(array($dirs_ok[$dir_svn]));
		}
		chdir(_DIR_RESTREINT_ABS);


		// Menu

		echo _L("Choisir le r&eacute;pertoire &agrave; mettre &agrave; jour&nbsp;: ");
		echo "<form action='./?exec=$exec' method='post'>
		<input type='hidden' name='exec' value='$exec' />
		<select name='dir_svn'>
		<option value=''></option>";
		foreach ($dirs_ok as $dir => $source) {
			echo "<option value='$dir'>".$dir
				." depuis ".$sources[$dir]."</option>\n";
		}
		echo "<option value='-1'>** "._L('Tous')."</option>\n";
		echo "</select>
		<input type='submit' value='Update' />
		</form>
		";

	} else
		echo _L("D&eacute;sol&eacute;, aucun r&eacute;pertoire n'est accessible en SVN.");


	fin_page();

}

?>
