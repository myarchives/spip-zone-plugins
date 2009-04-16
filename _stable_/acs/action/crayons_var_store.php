<?php
#              ACS
#          (Plugin Spip)
#     http://acs.geomaticien.org
#
# Copyright Daniel FAIVRE, 2007-2009
# Copyleft: licence GPL - Cf. LICENCES.txt

if (!defined("_ECRIRE_INC_VERSION")) return;
/**
 * Crayon pour une variable ACS - Sauvegarde
 * Crayon for one ACS variable - Store changes
*/
function action_crayons_var_store_dist() {
  include_spip('inc/crayons');
  // Inclusion de l'action crayons_store du plugin crayons, comme librairie
  include_spip('action/crayons_store');
  
	lang_select($GLOBALS['auteur_session']['lang']);
	header("Content-Type: text/html; charset=".$GLOBALS['meta']['charset']);
	  
  // Dernière sécurité :Accès réservé aux admins ACS
  // Last security: access restricted to ACS admins 
  if (!in_array($GLOBALS['auteur_session']['id_auteur'], explode(',', $GLOBALS['meta']['ACS_ADMINS']))) {
    echo var2js(array('$erreur' => _U('avis_operation_impossible')));
    exit;
  }

	$wid = $_POST['crayons'][0];
	if (!verif_secu($_POST['name_'.$wid], $_POST['secu_'.$wid])) {
		spip_log('ACS action/crayons_var_store : verif_secu('.$_POST['name_'.$wid].', '.$_POST['secu_'.$wid].') returned false');	
    return false;
    exit;
  }
	$var = 'acs'.$_POST['fields_'.$wid];
	$oldval = $_POST['oldval_'.$wid];
	// est-ce que la variable a ete modifiée entre-temps ?
	if (false) {
    echo var2js(array('$erreur' => _U('crayons:modifie_par_ailleurs')));
    exit;
  }	
	$newval = $_POST[$var.'_'.$wid];
	ecrire_meta($var, $newval);
	ecrire_meta("acsDerniereModif", time()); // forcera un recalcul
	spip_log('ACS action/crayons_var_store '.$var."=>".$newval);
	// Retourne la vue - Return vue 
	$return['$erreur'] = NULL;
  $return[$wid] = $newval;
	echo var2js($return);
	exit;
}

?>