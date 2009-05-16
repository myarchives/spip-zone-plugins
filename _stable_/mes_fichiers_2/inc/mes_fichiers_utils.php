<?php
if (!defined("_ECRIRE_INC_VERSION")) return;

// Renvoie la liste des fichiers et repertoires a sauver
function mes_fichiers_a_sauver() {

	$mes_options = defined('_FILE_OPTIONS') ? _FILE_OPTIONS : _DIR_RACINE.'config/mes_options.php';
	$htaccess = defined('_ACCESS_FILE_NAME') ? _DIR_RACINE._ACCESS_FILE_NAME : _DIR_RACINE.'.htaccess';
	$IMG = defined('_DIR_IMG') ? _DIR_IMG: _DIR_RACINE.'IMG/';
	$tmp_dump = defined('_DIR_DUMP') ? _DIR_DUMP: _DIR_RACINE.'tmp/dump/';
		
	$liste = array();

	// le fichier d'options si il existe
	if (@is_readable($mes_options))
		$liste[] = $mes_options;
	// le fichier .htaccess a la racine qui peut contenir des persos
	if (@is_readable($htaccess))
		$liste[] = $htaccess;
	// le fameux repertoire des documents et images
	if (@is_dir($IMG))
		$liste[] = $IMG;
	// le(s) dossier(s) des squelettes nommes
	if (strlen($GLOBALS['dossier_squelettes']))
		foreach (explode(':', $GLOBALS['dossier_squelettes']) as $_dir) {
			$dir = ($_dir[0] == '/' ? '' : _DIR_RACINE) . $_dir . '/';
			if (@is_dir($dir))
				$liste[] = $dir;
		}
	else
		if (@is_dir(_DIR_RACINE.'squelettes/'))
			$liste[] = _DIR_RACINE.'squelettes/';
	// le dernier fichier de dump de la base
	$dump = preg_files($tmp_dump);
	$fichier_dump = '';
	$mtime = 0;
	foreach ($dump as $_fichier_dump) {
		if (($_mtime = filemtime($_fichier_dump)) > $mtime) {
			$fichier_dump = $_fichier_dump;
			$mtime = $_mtime;
		}
	}
	if ($fichier_dump)
		$liste[] = $fichier_dump;
	// On ajoute via un pipeline des fichiers specifiques a d'autres plugins
	$liste_en_plus = array();
	$liste_en_plus = pipeline('mes_fichiers_a_sauver', $liste_en_plus);
	$liste = array_merge(array_unique(array_merge($liste, $liste_en_plus)));

	return $liste;
}

// Renvoie la liste des fichiers et repertoires a sauver classee par date inverse (max 20)
function mes_fichiers_a_telecharger() {
	$liste = preg_files(_DIR_MES_FICHIERS . 'mf2_', 20);
	return array_reverse($liste);
}

// Convertit un mtime en date
function filemtime_2_date($mtime) {
	return date('Y-m-d H:i:s',$mtime);
}

// Renvoie la liste des repertoires et fichiers de base archives (la liste de choix)
function mes_fichiers_resumer_zip($zip) {
	include_spip('inc/pclzip');
	$fichier_zip = new PclZip($zip);
	$proprietes = $fichier_zip->properties();
	
	$resume = NULL;
	if ($proprietes == 0) {
		$resume .= _T('mes_fichiers:message_zip_propriete_nok');
		spip_log('*** MES_FICHIERS (mes_fichiers_resumer_zip) ERREUR '.$fichier_zip->errorInfo(true));
	}
	else {
		$resume .= _T('mes_fichiers:resume_zip_statut').' : '.$proprietes['status'].'<br />';
		$resume .= _T('mes_fichiers:resume_zip_compteur').' : '.$proprietes['nb'].'<br />';
		$resume .= _T('mes_fichiers:resume_zip_contenu').' : '.'<br />';
		$resume .= '<ul>';
		$liste = unserialize($proprietes['comment']);
		if ($liste)
			foreach ($liste as $_fichier) {
				$resume .= '<li>' . joli_repertoire($_fichier) . '</li>';
			}
		else
			$resume .= '<li>' . _T('mes_fichiers:message_zip_sans_contenu') . '</li>';
		$resume .= '</ul>';
	}
	return $resume;	
}

// Renvoie la liste des fichiers et repertoires a sauver
function mes_fichiers_voir_zip($zip) {
	include_spip('inc/pclzip');
	$fichier_zip = new PclZip($zip);
  
	if (($list = $fichier_zip->listContent()) == 0) {
		spip_log('*** MES_FICHIERS (mes_fichiers_voir_zip) ERREUR '.$fichier_zip->errorInfo(true));
	}

	for ($i=0; $i<sizeof($list); $i++) {
		for(reset($list[$i]); $key = key($list[$i]); next($list[$i])) {
			echo "File $i / [$key] = ".$list[$i][$key]."<br>";
		}
		echo "<br>";
	}
}
?>
