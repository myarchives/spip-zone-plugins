<?php

function protection_formulaires_proteger($data) {
	$ret = '<script src="'._DIR_PLUGIN_PROTECTION_FORMULAIRES.'/javascript/proteger_formulaires.js" type="text/javascript"></script>';


	return $data.$ret;

}

?>