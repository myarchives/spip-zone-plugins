<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function genie_linkcheck_tests_malade_dist(){
	include_spip('inc/linkcheck_fcts');
	return linkcheck_tests(true,'malade');
}
?>
