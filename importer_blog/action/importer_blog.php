<?php

function action_importer_blog() {

	header('Content-Type: text/html; charset=utf-8');
	include_spip('inc/minipres');

	if (!autoriser('webmestre')) {
		echo minipres();
		exit;
	}

	if ($_FILES
	AND $f = array_pop($_FILES)
	AND !$f['error']) {
		$content = file_get_contents($f['tmp_name']);
	}
	else {
		echo minipres('Erreur de fichier');
		exit;

	}

	// Mode de stockage des liens mots<->articles
	$trouver_table = charger_fonction('trouver_table', 'base');
	define('_MODE_MOTS',  ($trouver_table('spip_mots_liens') ? 1 : 0));
	define('_MODE_AUTEURS',  ($trouver_table('spip_auteurs_liens') ? 1 : 0));
	define('_MODE_FORUM', _MODE_MOTS); // je suis flemmard, là...


	echo install_debut_html('Import de '.$f['name']);

	include_spip('iterateur/data');

	$r = importer_blogspot($content);

	if (!$r) 
		echo "<h1>Import terminé avec succès</h1>";
	else
		echo "<h1>Erreur : $r</h1>\n";


	echo install_fin_html();
}


function nettoyer_html($texte) {
	/*
	$texte = preg_replace(',<br ?/?><br ?/?>,i', "\n\n", $texte);
	$texte = preg_replace(',<br ?/?>,i', "\n_ ", $texte);
	$texte = preg_replace(',</div>,i', "\0\n\n", $texte);
	*/

	return $texte;
}


function importer_post($a, $rub =1) {
	$ref = "*".$a['id'];
	$s = sql_query($q = "SELECT id_article FROM spip_articles WHERE nom_site=".sql_quote((string)$ref));
	if ($t = sql_fetch($s))
		$id = $t['id_article'];
	else {
		$id = sql_insertq('spip_articles', array(
			'nom_site' => $ref,
			'statut' => 'publie'
		));
	}

	if (!$id) {
		echo "erreur sur $ref";
		return;
	}


	$p = sql_updateq('spip_articles',
		array(
			'titre' => $a['title'],
			'texte' => $a['content'],
			'date' => $a['date'],
			'id_rubrique' => $rub,
			'id_secteur' => $rub,
			'lang' => 'fr',
		),
		'id_article='.$id
	);

if (_MODE_AUTEURS) { /* SPIP 3 */
	sql_delete('spip_auteurs_liens', 'id_objet='.$id.' AND objet="article"');
	if ($id_auteur = get_id_auteur($a['author'], $a['email'])) {
		sql_insertq('spip_auteurs_liens', array('id_objet'=>$id, 'id_auteur' => $id_auteur, 'objet' => 'article'));
	}
} else { /* spip 2.1 */
	sql_delete('spip_auteurs_articles', 'id_article='.$id);
	if ($id_auteur = get_id_auteur($a['author'], $a['email'])) {
		sql_insertq('spip_auteurs_articles', array('id_article'=>$id, 'id_auteur' => $id_auteur));
	}
}

if (_MODE_MOTS) { /* SPIP 3 */
	sql_delete('spip_mots_liens', 'id_objet='.$id.' AND objet="article"');
	if (is_array($a['terms']))
	foreach($a['terms'] as $term)
	if ($id_mot = get_id_mot($term)) {
		sql_insertq('spip_mots_liens', array('id_objet'=>$id, 'id_mot' => $id_mot, 'objet' => 'article'));
	}
} else { /* spip 2.1 */
	sql_delete('spip_mots_articles', 'id_article='.$id);
	if (is_array($a['terms']))
	foreach($a['terms'] as $term)
	if ($id_mot = get_id_mot($term)) {
		sql_insertq('spip_mots_articles', array('id_article'=>$id, 'id_mot' => $id_mot));
	}
}

	echo "<dd><a href='"._DIR_RESTREINT."?exec=articles&amp;id_article=$id'>article $id</a></dd>\n";

#	var_dump($a, $p, $id, $id_auteur);
#	exit;
}


function importer_comment($a) {
	static $vu = array();

	$ref_article = "*".$a['parent'];

	$s = sql_query('SELECT id_article AS id FROM spip_articles WHERE nom_site='._q($ref_article));
	if (!$t = sql_fetch($s)) {
		echo "l'article $ref_article n'existe pas (encore?), on passe.\n";
		return false;
	}
	$id_objet = $t['id'];

	$ref = '*'.$a['id'];

	$s = sql_query($q = "SELECT id_forum FROM spip_forum WHERE nom_site=".sql_quote((string)$ref));
	if ($t = sql_fetch($s))
		$id = $t['id_forum'];
	else {
		$id = sql_insertq('spip_forum', array(
			'nom_site' => $ref,
			'statut' => 'publie'
		));
	}

	if (!$id) {
		echo "erreur sur $ref";
		return;
	}

	$f = array(
			'titre' => '', ## $a['title'], sur blogspot le titre n'est que le debut du content
			'texte' => $a['content'],
			'date_heure' => $a['date'],
			'date_thread' => $a['date'],
			'auteur' => $a['author'],
			'email_auteur' => $a['email'],
		);

	if (_MODE_FORUM) {
		$f['objet'] = 'article';
		$f['id_objet'] = $id_objet;
	} else {
		$f['id_article'] = $id_objet;
	}

	$p = sql_updateq('spip_forum',
		$f,
		'id_forum='.$id
	);

	echo "<dd><a href='"._DIR_RESTREINT."?exec=articles&amp;id_article=$id_objet'>forum $id</a></dd>\n";


}



function get_id_auteur($name, $email='') {
	static $mem = array();

	if (!isset($mem[$name])) {
		$s = sql_query("SELECT id_auteur FROM spip_auteurs WHERE nom="._q($name));
		if ($t = sql_fetch($s))
			$id = $t['id_auteur'];
		else
			$id = sql_insertq('spip_auteurs', array(
			'nom' => $name,
			'statut' => '1comite',
			'email' => $email
			));

		$mem[$name] = $id;
	}

	return $mem[$name];
}

function get_id_rubrique($name, $desc='') {
	static $mem = array();

	if (!isset($mem[$name])) {
		$s = sql_query("SELECT id_rubrique FROM spip_rubriques WHERE titre="._q($name)." AND id_parent=0");
		if ($t = sql_fetch($s))
			$id = $t['id_rubrique'];
		else
			$id = sql_insertq('spip_rubriques', array(
			'titre' => $name,
			'texte' => $desc,
			'statut' => 'publie',
			'id_parent' => 0
			));

		$mem[$name] = $id;
	}

	return $mem[$name];
}


function get_id_mot($name) {
	static $mem = array();

	if (!isset($mem[$name])) {
		$s = sql_query("SELECT id_mot FROM spip_mots WHERE titre="._q($name));
		if ($t = sql_fetch($s))
			$id = $t['id_mot'];
		else
			$id = sql_insertq('spip_mots', array(
			'titre' => $name,
			'id_groupe' => '1',
			'type' => 'tag',
			));

		$mem[$name] = $id;
	}

	return $mem[$name];
}


function importer_blogspot(&$content) {
	$it = new SimpleXmlIterator(
		str_replace('xmlns=', 'ns=',$content)
	);

	foreach ($it->xpath('entry') as $key => $val) {
		$id = ((string)$val->id);


#	echo htmlspecialchars($txt = (string) $val->content);
#	echo "$key <pre>\n".htmlspecialchars(var_export(/*ObjectToArray*/($val),true))."</pre><hr />";
#	if ($n++>100) exit;


		if (preg_match(',\.post-(.*)$,', $id, $r)) {
			$ref = $r[1];

			$a = array('id' => $ref);

			echo "<dt>$ref</dt>\n";
			echo "<dd>".htmlspecialchars($tit = (string) $val->title)."</dd>";


			## etablir le type (post / comment) de l'item
			$type =  $val->xpath('category[@scheme=\'http://schemas.google.com/g/2005#kind\']');
			$a['type'] = preg_replace(',^.*#,', '', (string) $type[0]->attributes()->term);


			## etablir l'url
			if (
			$link =  $val->xpath('link[@rel=\'alternate\']')) {
				$a['link'] = preg_replace(',[?].*,', '', (string) $link[0]->attributes()->href);
				#var_export($link);
			}

			## si c'est un commentaire, aller chercher l'article parent
			if ($a['type'] == 'comment') {
				$link =  $val->xpath('link[@rel=\'self\']');
				$link = $link[0]->attributes()->href;
				preg_match(',(\d+)/comments/,', $link, $r );
				$a['parent'] = $r[1];
			}


			$terms = array();
			foreach($val->xpath('category[@scheme="http://www.blogger.com/atom/ns#"]') as $t)
				$terms[] = (string)$t->attributes()->term;

			if ($terms) $a['terms'] = $terms;

#			var_dump($val->xpath('content')->attributes()->type);

			$a['title'] = nettoyer_html((string) $val->title);
			$a['content'] = nettoyer_html((string) $val->content);

			$a['date'] = date('Y-m-d H:i:s', strtotime((string) $val->published));
			$a['author'] = (string) $val->author->name;
			$a['email'] = (string) $val->author->email;
			if($a['email'] == 'noreply@blogger.com')
				$a['email'] = '';

			switch($a['type']) {
				case "post":
					$rub = get_id_rubrique(
						$settings['blog_name'], $settings['blog_description']);
					importer_post($a, $rub);
					break;
				
				case "comment":
					importer_comment($a);
					break;

				default:
					echo "type inconnu: ".$type."\n";
					break;
			}
		}
		else {
			echo "<s>$id</s> <br />\n";
			if (preg_match(',\.settings\.(\w+)$,', $id, $r)) {
				$settings[strtolower($r[1])] = (string) $val->content;
			}
		}
	}

}