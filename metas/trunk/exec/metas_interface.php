<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function exec_metas_interface() {
	include_spip('metas');
	include_spip('metas_fonctions');
	$ret = metas_formulaire_affiche($_GET['objet'], $_GET['id_objet']);
	echo $ret;
}
