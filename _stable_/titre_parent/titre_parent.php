<?php

//Le filtre [(#ID_RUBRIQUE|titre_parent)]
function titre_parent($id_rubrique) {
	if(!($id_rubrique = intval($id_rubrique))) return '';
	$q = 'SELECT titre FROM spip_rubriques WHERE id_rubrique='.$id_rubrique;
	if($r = spip_query($q))
		if($row = sql_fetch($r))
			return $row['titre'];
	return '';
}

//La balise
function balise_TITRE_PARENT_dist($p) {
	$id_rubrique = champ_sql('id_rubrique', $p);
	$p->code = "titre_parent(".$id_rubrique.")";
	return $p;
}

?>