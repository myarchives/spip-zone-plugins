<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('inc/rechercher');

function spip_asort($array) {
	if (is_array($array)) {
		asort($array);
		foreach ($array as $k => $v) {
			$array_order[$k] = $v;
		}
		return $array_order;
	}
	return $array;
}

function verifier_conversion() {
	$charset = strtolower(str_replace('-', '', $GLOBALS['meta']['charset']));
	$necessite_conversion = false;

	// signaler les incoherences de charset site/tables qui plantent les requetes avec accents...
	// ?exec=convert_sql_utf8 => conversion base | ?exec=convert_utf8 => conversion site
	$data = sql_fetch(sql_query("SHOW CREATE TABLE " . table_objet_sql($table)));
	preg_match(',DEFAULT CHARSET=([^\s]+),', $data["Create Table"], $match);
	$charset_table = strtolower(str_replace('-', '', $match[1]));
	$charset_table = preg_replace(',^latin1$,', 'iso88591', $charset_table);
	if ($charset_table != '' AND $charset != $charset_table) {
		$modif = (substr($charset, 0, 3) == 'iso' ? 'convert_utf8' : 'convert_sql_utf8');
		$url = generer_url_ecrire($modif);
		echo "<p>" . _T('fulltext:incoherence_charset') . "<strong><a href='$url'>" . _T('fulltext:convertir_utf8') . "</a></strong></p>\n";
	}
}

function compter_elements($table) {
	$nb = sql_countsel(table_objet_sql($table));
	return $nb;
}

/**
 * Récupération de l'engine utilisé par une table sql
 * 
 * Retourne MyISAM ou InnoDB
 * 
 * @param string $table
 * 		La table à analyser
 * @return string 
 * 		Le moteur utilisé
 */
function Fulltext_trouver_engine_table($table) {
	if ($s = sql_query("SHOW CREATE TABLE " . table_objet_sql($table), $serveur) AND $t = sql_fetch($s) AND $create = array_pop($t) AND preg_match('/\bENGINE=([^\s]+)/', $create, $engine))
		return $engine[1];
}

function Fulltext_index($table, $champs, $nom = null) {
	if (!$nom)
		list(, $nom) = each($champs);

	if ($nom !== 'tout')
		$champs = array($nom);

	$trouver_table = charger_fonction('trouver_table', 'base');
	$desc = $trouver_table(table_objet($table));

	foreach ($champs as $i => $f) {
		if (preg_match(',^(tiny|long|medium)?text\s,i', $desc['field'][$f]))
			$champs[$i] = "`$f`";
		else if (preg_match(',^varchar.*\s,i', $desc['field'][$f]) && !preg_match(',COLLATE utf8_bin.*\s,i', $desc['field'][$f]))
			$champs[$i] = "`$f`";
		else
			unset($champs[$i]);
	}
	return "`$nom` (" . join(',', $champs) . ")";
}

function Fulltext_creer_index($table, $nom, $vals) {

	$keys = fulltext_keys($table);
	if ($nom == 'tout')
		$index = Fulltext_index($table, $vals, 'tout');
	else
		$index = Fulltext_index($table, array($nom), $nom);

	if ($table == 'document' && $nom == 'tout') {
		// On initialise l'indexation du contenu des documents
		sql_updateq("spip_documents", array('contenu' => ''), "extrait='non'");
	}
	if (!$s = sql_alter("TABLE " . table_objet_sql($table) . " ADD FULLTEXT " . $index))
		return "<strong>" . _T('spip:erreur') . " " . mysql_errno() . " " . mysql_error() . "</strong><pre>$query</pre><p />\n";
	sql_optimize(table_objet_sql($table));

	$keys = fulltext_keys($table);
	if (isset($keys[$nom]))
		return "<p><strong>" . _T('fulltext:fulltext_cree') . " : $keys[$nom]</strong></p>";
	else
		return "<p><strong>" . _T('spip:erreur') . ".</strong></p>\n";

}

function Fulltext_lien_creer_index($table, $champs, $nom = null) {
	$url = generer_url_ecrire(_request('exec'), 'table=' . $table . '&nom=' . $nom);
	return "<p><a href='$url'>" . _T('fulltext:fulltext_creer', array('index' => Fulltext_index($table, $champs, $nom))) . "</a></p>\n";
}

function Fulltext_supprimer_index($table, $nom = 'tout') {
	if (!$s = sql_alter("TABLE " . table_objet_sql($table) . " DROP INDEX " . $nom)) {
		return "<p><strong>" . _T('spip:erreur') . " " . mysql_errno() . " " . mysql_error() . "</strong><pre>$query</pre></p>\n";
	} else {
		if ($table == 'document' && $nom == 'tout') {
			// Plus besoin des donnees extraites des fichiers
			sql_updateq("spip_documents", array('contenu' => ''), "extrait='n/a'");
		}
		return " <strong>=> " . _T('fulltext:index_supprime') . "</strong>\n";
	}
}

function Fulltext_regenerer_index($table) {
	if (count($keys = fulltext_keys($table)) > 0) {
		foreach ($keys as $key => $vals) {
			if (!$s = sql_alter("TABLE " . table_objet_sql($table) . " DROP INDEX " . $key))
				return "<p><strong>" . _T('spip:erreur') . " " . mysql_errno() . " " . mysql_error() . "</strong><pre>$query</pre></p>\n";
			if (!$s = sql_alter("TABLE " . table_objet_sql($table) . " ADD FULLTEXT " . $key . " (" . $vals . ")"))
				return "<strong>" . _T('spip:erreur') . " " . mysql_errno() . " " . mysql_error() . "</strong><pre>$query</pre><p />\n";
			sql_optimize(table_objet_sql($table));
		}
		return "<p><strong>" . _T('fulltext:index_regenere') . "</strong></p>";
	}
}

function Fulltext_reinitialiser_document() {
	sql_updateq("spip_documents", array('contenu' => '', 'extrait' => 'non'), "extrait='err'");
	return "<p><strong>" . _T('fulltext:index_reinitialise') . "</strong></p>";
}

function Fulltext_reinitialiser_totalement_document() {
	sql_updateq("spip_documents", array('contenu' => '', 'extrait' => 'non'));
	return "<p><strong>" . _T('fulltext:index_reinitialise_totalement') . "</strong></p>";
}

function Fulltext_reinitialiser_document_ptg() {
	sql_updateq("spip_documents", array('contenu' => '', 'extrait' => 'non'), "extrait='ptg'");
	return "<p><strong>" . _T('fulltext:index_reinitialise_ptg') . "</strong></p>";
}

function Fulltext_creer_tous($tables = false) {
	if (!$tables) {// Si les tables ne sont pas donnee, on va les chercher
		include_spip('inc/rechercher');
		include_spip('base/abstract_sql');
		$tables = liste_des_champs();
	}

	foreach ($tables as $table => $vals) {
		// Modification automatique de la table sur le moteur MyISAM
		if (!$engine = Fulltext_trouver_engine_table($table) OR strtolower($engine) != 'myisam')
			Fulltext_conversion_myisam($table);

		$keys = fulltext_keys($table);
		// Liste des index existant

		$champs = array_keys($vals);
		asort($vals);
		// le champ de titre est celui qui a le poids le plus eleve
		$champs2 = array_keys($vals);
		$champ_titre = array_pop($champs2);
		if (!isset($keys[$champ_titre])) {
			Fulltext_creer_index($table, $champ_titre, $champs);
		}
		if (!isset($keys['tout'])) {
			Fulltext_creer_index($table, 'tout', $champs);
		}
	}
}

function Fulltext_conversion_myisam($table) {
	if (!sql_alter("TABLE " . table_objet_sql($table) . " ENGINE=MyISAM"))
		return "<p><strong>" . _T('spip:erreur') . " " . mysql_errno() . ' ' . mysql_error() . "</strong></p>\n";
	else
		return "<p><strong>" . _T('fulltext:table_convertie') . "</strong></p>\n";
}
