<?php
/*
 * Plugin Comments
 * (c) 2010 xxx
 * Distribue sous licence GPL
 *
 */

/**
 * Generer les boutons d'admin des forum selon les droits du visiteur
 * en SPIP 2.1 uniquement
 * 
 * @param <type> $p
 * @return <type>
 */
function balise_BOUTONS_ADMIN_FORUM_dist($p) {
	if (($_id = interprete_argument_balise(1,$p))===NULL)
		$_id = champ_sql('id_forum', $p);

	include_spip('inc/plugin');
	if (function_exists('spip_version_compare')
		AND spip_version_compare($GLOBALS['spip_version_code'],"2.1.0-rc",">="))
		$p->code = "
'<'.'?php
	if (\$GLOBALS[\'visiteur_session\'][\'statut\']==\'0minirezo\'
		AND (\$id = '.intval($_id).')
		AND	include_spip(\'inc/autoriser\')
		AND autoriser(\'moderer\',\'forum\',\$id)) {
			include_spip(\'inc/actions\');
			echo \"<div class=\'actions modererforum\'>\"
			. bouton_action(_T(\'icone_supprimer_message\'),generer_action_auteur(\'instituer_forum\',\$id.\'-off\',ancre_url(self(),\'forum\')))
			. bouton_action(_T(\'SPAM\'),generer_action_auteur(\'instituer_forum\',\$id.\'-spam\',ancre_url(self(),\'forum\')))
			. \"</div>\";
		}
?'.'>'";
		$p->interdire_scripts = false;

	return $p;

}


// surcharger les boucles FORUMS
// pour afficher uniquement les forums public meme en preview
function comments_pre_boucle($boucle){
	if ($boucle->type_requete == 'forums') {
		$id_table = $boucle->id_table;
		$mstatut = $id_table .'.statut';
		// Par defaut, selectionner uniquement les forums sans mere
		// Les criteres {tout} et {plat} inversent ce choix
		if (!isset($boucle->modificateur['tout']) AND !isset($boucle->modificateur['plat'])) {
			array_unshift($boucle->where,array("'='", "'$id_table." ."id_parent'", 0));
		}
		// Restreindre aux elements publies
		if (!$boucle->modificateur['criteres']['statut']) {
				array_unshift($boucle->where,array("'='", "'$mstatut'", "'\\'publie\\''"));
		}
	}
	return $boucle;
}

?>