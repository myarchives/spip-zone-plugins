<?php
function savecfg_afficher_tout($flux) {
	if($flux['args']['exec'] == 'cfg') {
		$flux['data'] = debut_boite_info(true) . recuperer_fond('prive/formulaires_savecfg') . fin_boite_info(true);
	}
	return $flux;
}
?>