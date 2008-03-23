<?php

function formulaires_cfg_valider_dist($cfg="", $cfg_id=""){
	$erreurs = array();
	
	// si c'est une suppression, pas besoin de validation
	if (_request('_cfg_delete')) return;
	
	$cfg_formulaire = cfg_charger_classe('cfg_formulaire','inc');
	$config = &new $cfg_formulaire($cfg, $cfg_id);
	
	// si c'est vide, modifier sera appele, sinon le formulaire sera resoumis
	return $config->verifier();

}
?>
