<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function cp_autoriser(){
	return true;
}
// declarations d'autorisations
function autoriser_cp_bouton_dist($faire, $type, $id, $qui, $opt) {
return autoriser('voir', 'cp', $id, $qui, $opt);
}

function autoriser_cp_voir_dist($faire, $type, $id, $qui, $opt) {
return in_array($qui['statut'], array('0minirezo', '1comite'));
}

function autoriser_cp_modifier_dist($faire, $type, $id, $qui, $opt) {
return in_array($qui['statut'], array('0minirezo'));
}

?>
