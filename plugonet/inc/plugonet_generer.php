<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2011                                                *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('inc/langonet_generer_fichier');
include_spip('inc/plugin');

function inc_plugonet_generer($files, $write) {

	// Chargement des fonctions de validation XML et d'extraction ders informations contenues dans la balise plugin
	$valider_xml = charger_fonction('valider', 'xml');
	$informer_xml = charger_fonction('infos_plugin', 'plugins', true);
	$informer_xml = ($informer_xml)	? $informer_xml : charger_fonction('get_infos', 'plugins');
	spip_log("Plugonet: fonction de lecture: $informer_xml");

	$erreurs = array();
	foreach($files as $nom)  {
		if (lire_fichier($nom, $contenu)) {
			$erreurs[$nom]['lecture_pluginxml'] = false;
			// Validation formelle du fichier plugin.xml (uniquement des avertissements)
			$resultats = $valider_xml($contenu, false, false, 'plugin.dtd');
			$erreurs[$nom]['validation_pluginxml'] = is_array($resultats) ? $resultats[1] : $resultats->err; //2.1 ou 2.2

			// Recherche de toutes les balises plugin contenues dans le fichier plugin.xml et extraction de leurs infos
			$regexp = '#<plugin[^>]*>(.*)</plugin>#Uims';
			if ($nb_balises = preg_match_all($regexp, $contenu, $matches)) {
				$plugins = array();
				// Pour chacune des occurences de la balise on extrait les infos
				$erreurs[$nom]['information_pluginxml'] = false;
				foreach ($matches[0] as $_balise_plugin) {
					// Extraction des informations du plugin suivant le standard SPIP
					// -- si une balise est illisible on sort de la boucle et on retourne l'erreur sans plus de traitement
					if (!$infos = $informer_xml($_balise_plugin)) {
						$erreurs[$nom]['information_pluginxml'] = true;
						break;
					}
					$plugins[] = $infos;
				}
			}
			else
				$erreurs[$nom]['information_pluginxml'] = true;

			if (!$erreurs[$nom]['information_pluginxml']) {
				// Puisqu'on sait extraire les infos du plugin.xml, .on construit le contenu du fichier paquet.xml
				// a partir de ces infos
				list($paquet_xml, $prefixe, $description) = plugin2paquet($plugins);
				// On valide le contenu obtenu avec la nouvelle DTD paquet
				$resultats = $valider_xml($paquet_xml, false, false, 'paquet.dtd');
				$erreurs[$nom]['validation_paquetxml'] = is_array($resultats) ? $resultats[1] : $resultats->err;
				
				// Si aucune erreur de validation de paquet.xml, on peut ecrire les fichiers de sortie :
				// -- paquet.xml dans le repertoire du plugin
				// -- les ${prefixe}-paquet_${langue}.php pour chaque langue trouvee dans le repertoire lang/ du plugin
				// -- le fichier des commandes svn
				if (!$erreurs[$nom]['validation_paquetxml'] AND $write ) {
					$dir = dirname($nom);
					if ($modules = plugin2paquet_description($description, $prefixe, $dir))
						$xml = "\n<!-- svn add " . join(' ', $modules) . " -->" . $xml;
					if (ecrire_fichier($dir . '/paquet.xml', $xml))
						$xml = "\n<!-- svn add paquet.xml -->" . $xml;
				}
			}
		}
		else
			$erreurs[$nom]['lecture_pluginxml'] = true;
	}

	return array($erreurs);
}


// --------------------- CONSTRUCTION DES BALISES PAQUET ET SPIP -----------------
//

// Boucle sur chaque contenu des balises plugin et creation du contenu de paquet.xml
function plugin2paquet($plugins) {

	// On determine le bloc dont la borne min de compatibilite SPIP est la plus elevee
	// et celui dont la borne min est la moins elevee
	$cle_min_max = $cle_min_min = -1;
	$borne_min_max = '1.9.0';
	$borne_min_min = '3.0.0';
	foreach ($plugins as $_cle => $_plugin) {
		if (!$_plugin['compatible'])
			$borne_min = '1.9.0';
		$bornes_spip = extraire_bornes($_plugin['compatible']);
		$borne_min = ($bornes_spip['min']['valeur']) ? $bornes_spip['min']['valeur'] : '1.9.0';
		if (spip_version_compare($borne_min_max, $borne_min, '<=')) {
			$cle_min_max = $_cle;
			$borne_min_max = $borne_min;
		}
		if (spip_version_compare($borne_min_min, $borne_min, '>=')) {
			$cle_min_min = $_cle;
			$borne_min_min = $borne_min;
		}
	}

	// On initialise les informations non techniques du bloc de compatibilite la moins elevee avec celles
	// du bloc dont la borne min de compatibilite SPIP est la plus elevee.
	$plugins[$cle_min_min]['prefix'] = $plugins[$cle_min_max]['prefix'];
	$plugins[$cle_min_min]['categorie'] = $plugins[$cle_min_max]['categorie'];
	$plugins[$cle_min_min]['icon'] = $plugins[$cle_min_max]['icon'];
	$plugins[$cle_min_min]['version'] = $plugins[$cle_min_max]['version'];
	$plugins[$cle_min_min]['etat'] = $plugins[$cle_min_max]['etat'];
	$plugins[$cle_min_min]['version_base'] = $plugins[$cle_min_max]['version_base'];
	$plugins[$cle_min_min]['meta'] = $plugins[$cle_min_max]['meta'];
	$plugins[$cle_min_min]['lien'] = $plugins[$cle_min_max]['lien'];
	$plugins[$cle_min_min]['nom'] = $plugins[$cle_min_max]['nom'];
	$plugins[$cle_min_min]['auteur'] = $plugins[$cle_min_max]['auteur'];
	$plugins[$cle_min_min]['licence'] = $plugins[$cle_min_max]['licence'];

	// On initialise la description pour la creation des fichiers de langue
	$description = $plugins[$cle_min_max]['description'];

	// Le bloc de compatibilite la moins elevee correspond aux attributs et sous-balises primaires
	// de la balise paquet. Les autres blocs generent les balises spip contenant uniquement les 
	// donnees dits techniques
	// -- On commence avec les balises spip
	$balises_spip = '';
	$commandes_spip = '';
	foreach ($plugins as $_cle => $_plugin) {
		if ($_cle <> $cle_min_min) {
			list($spip, $commandes) = plugin2balise($_plugin, 'spip');
			$balises_spip .= "\n\t$spip";
			$commandes_spip .= "$spip\n";
		}
	}
	// -- On continue avec la balise paquet
	list($paquet_xml, $commande_paquet) = plugin2balise($plugins[$cle_min_min], 'paquet', $balises_spip);
	$paquet_xml = $commande_paquet . $commandes_spip . $paquet_xml;

	return array($paquet_xml, $plugins[0]['prefix'], $description);
}

// Construction d'une balise paquet ou spip
function plugin2balise($D, $balise, $balises_spip='') {
	// Extraction des attributs de la balise paquet
	$categorie = $D['categorie'];
	$etat = $D['etat'];
	$lien = $D['lien'];
	$logo = $D['icon'];
	$meta = $D['meta'];
	$prefix = $D['prefix'];
	$version = $D['version'];
	$version_base = $D['version_base'];

	$compatible = '';
	// Si le tableau provient de infos_plugin la compatibilite SPIP est directement accessible
	if (isset($D['compatible']))
		$compatible =  $D['compatible'];
	// Si le tableau provient de get_infos la compatibilite SPIP est incluse dans les necessite
	else {
		foreach($D['necessite'] as $k => $i) {
			$id = isset($i['id']) ? $i['id'] : $i['nom'];
			if ($id AND strtoupper($id) == 'SPIP') {
				$compatible = $i['version'];
				unset($D['necessite'][$k]);
				break;
			}
		}
	}
	
	// Constrution de la balise paquet et de ses attributs
	if ($balise == 'paquet') {
		$attributs =
			($prefix ? "\n\tprefix='$prefix'" : '') .
			($categorie ? "\n\tcategorie='$categorie'" : '') .
			($logo ? "\n\tlogo='$logo'" : '') .
			($version ? "\n\tversion='$version'" : '') .
			($etat ? "\n\tetat='$etat'" : '') .
			($version_base ? "\n\tversion_base='$version_base'" : '') .
			($meta ? "\n\tmeta='$meta'" : '') .
			plugin2paquet_lien($lien, 'documentation') .
			($compatible ? "\n\tcompatible='$compatible'" : '');
	
		// Constrution de toutes les autres balise incluses dans paquet
		$nom = plugin2paquet_nom($D['nom']);
	
		$auteur = plugin2paquet_copy($D['auteur'], 'auteur');
		$licence = plugin2paquet_copy($D['licence'], 'licence');
	}
	else {
		// Balise spip
		$attributs =
			($compatible ? "\n\tcompatible='$compatible'" : '');
		// raz des balises non utilisees
		$nom = $auteur = $licence = '';
	}

	// Toutes les balises techniques sont possibles dans paquet et spip
	$pipeline = is_array($D['pipeline']) ? plugin2paquet_pipeline($D['pipeline']) :'';
	$chemin = is_array($D['path']) ? plugin2paquet_chemin($D) :'';
	$necessite = (is_array($D['necessite']) OR is_array($D['lib'])) ? plugin2paquet_necessite($D) :'';
	$utilise = is_array($D['utilise']) ? plugin2paquet_utilise($D['utilise']) :'';
	$bouton = is_array($D['bouton']) ? plugin2paquet_exec($D, 'bouton') :'';
	$onglet = is_array($D['onglet']) ? plugin2paquet_exec($D, 'onglet') :'';
	$traduire = is_array($D['traduire']) ? plugin2paquet_traduire($D) :'';

	// Pour l'instant on concatene les commandes de toutes les balises paquet et spip
	$renommer = plugin2paquet_implicite($D, 'options', 'options')
	. plugin2paquet_implicite($D, 'fonctions', 'fonctions')
	. plugin2paquet_implicite($D, 'install', 'actions');
	
	return array("<$balise$attributs\n>\t$nom$auteur$licence$pipeline$necessite$utilise$bouton$onglet$chemin$traduire$balises_spip\n</$balise>\n", $renommer);
}


// --------------------- ATTRIBUTS DE PAQUET ET BALISE NOM -----------------------
//
// - attribut documentation
// - balise nom

// Eliminer les textes superflus dans les liens (raccourcis [XXX->http...])
// et normaliser l'esperluete pour eviter l'erreur d'entite indefinie
function plugin2paquet_lien($url, $nom='lien', $sep="\n\t") {
	if (!preg_match(',https?://[^]\s]+,', $url, $r))
		return '';
	$url = str_replace('&', '&amp;', str_replace('&amp;', '&', $r[0]));
	return "$sep$nom='$url'";
}

// Extrait la tradution francaise uniquement
// Pour l'instant on ne normalise pas le nom comme le fait SVP
// --> A voir plus tard
function plugin2paquet_nom($texte) {
	$t = plugin2paquet_traite_mult($texte);
	$res = ($t['fr']) ? "\n\t<nom>" . $t['fr'] . "</nom>" : '';

	return $res ? "\n$res" : '';
}


// --------------------- BALISES COPYRIGHT (CONTENT_COPY) ------------------------
//
// - auteur
// - licence
// - copyright

// - elimination des multi (exclue dans la nouvelle version)
// - transformation en attribut des balises A
// - interpretation des balises BR et LI et de la virgule et du espace+tiret comme separateurs
function plugin2paquet_copy($texte, $balise) {

	// On extrait le multi si besoin et on selectionne la traduction francaise
	$t = plugin2paquet_traite_mult($texte);

	$res = $resa = $resl = $resc = '';
	foreach(preg_split('@(<br */?>)|<li>|,|\s-|\n|&amp;@', $t['fr']) as $v) {
		// On detecte d'abord si le bloc texte en cours contient un eventuel copyright
		// -- cela generera une balise copyright et non auteur
		$copy = '';
		if (preg_match('/(?:\&#169;|©|copyright|\(c\)|&copy;)[\s:]*([\d-]+)/i', $v, $r)) {
			$copy = trim($r[1]);
			$v = str_replace($r[0], '', $v);
			$resc .= "\n\t<copyright>$copy</copyright>";
		}
		
		// On detecte ensuite un lien eventuel d'un auteur
		// -- soit sous la forme d'une href d'une ancre
		// -- soit sous la forme d'un raccourci SPIP
		// Dans les deux cas on garde preferentiellement le contenu de de l'ancre ou du raccourci
		// si il existe
		if (preg_match('@<a[^>]*href=(\W)(.*?)\1[^>]*>(.*?)</a>@', $v, $r)) {
			$href = " lien='" . $r[2] ."'";
			$v = str_replace($r[0], $r[3], $v);
		} elseif (preg_match(_RACCOURCI_LIEN,$v, $r)) {
			$href = " lien='" . $r[4] ."'";
			$v = ($r[1]) ? $r[1] : str_replace($r[0], '', $v);
		} else 
			$href = '';
		
		// On detecte ensuite un mail eventuel
		if (preg_match('/([^\w\d._-]*)(([\w\d._-]+)@([\w\d.-]+))/', $v, $r)) {
			$mail = " mail='$r[2]'";
			$v = str_replace($r[2], '', $v);
			if (!$v) {
				// On considere alors que la premiere partie du mail peut faire office de nom d'auteur
				if (preg_match('/(([\w\d_-]+)[.]([\w\d_-]+))@/', $r[2], $s))
					$v = ucfirst($s[2]) . ' ' . ucfirst($s[3]);
				else
					$v = ucfirst($r[3]);
			}
		} else 
			$mail = '';
		
		// On detecte aussi si le bloc texte en cours contient une eventuel licence
		// -- cela generera une balise licence et non auteur
		//    cette heuristique b'est pas deterministe car la phrase de licence n'est pas connue
		$licnom = $licurl ='';
		if (preg_match('/(gpl|lgpl|gnu\/gpl|gpl\s*v3)/i', $v, $r)) {
			$licnom = strtoupper(trim($r[1]));
			$licurl = ($licnom=='LGPL') ? 'http://www.gnu.org/licenses/lgpl-3.0.html' : 'http://www.gnu.org/licenses/gpl-3.0.html';
			$licurl = " lien='$licurl'";
			$resl .= "\n\t<licence$licurl>$licnom</licence>";
		}
		
		// On finalise la balise auteur ou licence si on a pas trouve de licence prioritaire
		$v = trim(textebrut($v));
		if ((strlen($v) > 2) AND !$licnom)
			$resa .= "\n\t<$balise$href$mail>$v</$balise>";
	}
	$res = ($resa ? "\n$resa" : '') . ($resc ? "\n$resc" : '') . ($resl ? "\n$resl" : '');

	return $res ? $res : '';
}


// --------------------- BALISES TECHNIQUES (CONTENT_TECH) -----------------------
//
// - pipeline
// - chemin
// - necessite (plugins)
// - lib (librairies)
// - utilise
// - bouton
// - onglet
// - traduire

function plugin2paquet_pipeline($D) {
	$res = '';
	foreach($D as $i) {
		$att = " nom='" . $i['nom'] . "'" .
				(!empty($i['action']) ? (" action='" . $i['action'] . "'") : '') .
				(!empty($i['inclure']) ? (" inclure='" . $i['inclure'] . "'") : '');
		$res .= "\n\t<pipeline$att />";
	}
	
	return $res ? "\n$res" : '';
}

function plugin2paquet_chemin($D) {
	$res = '';
	foreach($D['path'] as $i) {
		$t = empty($i['type']) ? '' : (" type='" . $i['type'] . "'");
		$p = $i['dir'];
		if (!$t AND (!$p OR $p==='.' OR $p==='./')) 
			continue;
		$res .="\n\t<chemin path='$p'$t />";
	}

	return $res ? "\n$res" : '';
}

//Extraction des necessite des plugins et des librairies
function plugin2paquet_necessite($D) {
	$nec = $lib = '';

	// Si on lit avec get_infos les librairies sont incluses dans l'arbre des necessite
	if ($D['necessite']) {
		foreach($D['necessite'] as $i) {
			$nom = isset($i['id']) ? $i['id'] : $i['nom'];
			$src = plugin2paquet_lien($i['src'], 'lien', ' ');
			$version = empty($i['version']) ? '' : (" version='" . $i['version'] . "'");
			if (preg_match('/^lib:(.*)$/', $nom, $r))
				$lib .= "\n\t<lib nom='" . $r[1] . "'$src />";
			else 
				$nec .="\n\t<necessite nom='$nom'$version />";
		}
	}

	// Si on lit avec infos_plugin les librairies sont dans une branche 'lib'
	if ($D['lib']) {
		foreach($D['lib'] as $i) {
			$nom = isset($i['id']) ? $i['id'] : $i['nom'];
			$src = " lien='" . $i['lien'] . "'";
			$lib .= "\n\t<lib nom='$nom'$src />";
		}
	}

	$res = $nec . $lib;
	return $res ? "\n$res" : '';
}

function plugin2paquet_utilise($D) {
	$res = '';
	foreach($D as $i) {
		$nom = isset($i['id']) ? $i['id'] : $i['nom'];
		$att = " nom='$nom'" .
				(!empty($i['version']) ? (" version='" . $i['version'] . "'") : '') .
				plugin2paquet_lien($i['src']);
		$res .="\n\t<utilise$att />";
	}

	return $res ? "\n$res" : '';
}

// Extraction des boutons et onglets
function plugin2paquet_exec($D, $balise) {
	$res = '';
	foreach($D[$balise] as $nom => $i) {
		$att = " nom='" . $nom . "'" .
				" titre='" . $i['titre'] . "'" .
				(empty($i['parent']) ? '' : (" parent='" . $i['parent'] . "'")) .
				(empty($i['icone']) ? '' : (" icone='" . $i['icone'] . "'")) .
				(empty($i['url']) ? '' : (" action='" . $i['url'] . "'")) .
				(empty($i['args']) ? '' :
				(" args='" . str_replace('&', '&amp;', str_replace('&amp;', '&', $i['args'])) . "'"));
		$res .= "\n\t<$balise$att />";
	}

	return $res ? "\n$res" : '';
}

function plugin2paquet_traduire($D) {
	$res = '';
	foreach($D['traduire'] as $nom => $i) {
		$att = " module='" . $i['module'] . "'" .
				" reference='" . $i['reference'] . "'" .
				(empty($i['gestionnaire']) ? '' : (" gestionnaire='" . $i['gestionnaire'] . "'"));
		$res .= "\n\t<traduire$att />";
	}

	return $res ? "\n$res" : '';
}


// --------------------- BALISES DISPARUES ---------------------------------------
//
// - fonctions, options et install : creation des commandes svn de substitution
// - slogan, description : creation des fichiers de langue ${prefixe}-paquet_${codelangue}.php

// verifie que la balise $nom declare une unique fichier $prefix_$nom:
// fonctions -> $prefix_fonctions
// options -> $prefix_options, 
// install -> $prefix_actions
function plugin2paquet_implicite($D, $balise, $nom)
{
	$files = is_array($D[$balise]) ? $D[$balise] : array($D[$balise]);
	$contenu = join(' ', array_map('trim', $files));
	$std = $D['prefix'] . "_$nom" . '.php';
	if (!$contenu OR $contenu == $std) 
		return '';
	if (!strpos($contenu, ' ')) 
		return "<!-- svn mv $contenu $std -->\n";
	$k = array_search($std, $files);
	if (!$k)
		return "<!-- cat $contenu &gt; $std -->\n<!-- svn add $std -->\n";
	unset($files[$k]);
	$contenu = join(' ', array_map('trim', $files));
	return "<!-- cat $contenu &gt;&gt; $std -->\n<!-- svn rm $contenu -->\n";
}

// Passer les lettres accentuees en entites XML
function plugin2paquet_description($description, $prefixe, $dir) {
	$files = $langs = array();
	foreach (plugin2paquet_traite_mult($description) as $lang => $_descr) {
		if (!$lang)
			$lang = 'fr';
		$langs[$lang][strtolower($prefixe) . '_description'] = trim(htmlentities($_descr));
		if (preg_match(',^\s*(.+)[.!?\r\n\f],Um', $_descr, $matches))
			$langs[$lang][strtolower($prefixe) . '_slogan'] = $matches[1];
		else
			$langs[$lang][strtolower($prefixe) . '_slogan'] = couper($_descr, 150, '');
	}

	$dirl = $dir . '/lang';
	if (!is_dir($dirl)) 
		mkdir( $dirl);
	$dirl .= '/';
	foreach($langs as $lang => $couples) {
		$module = strtolower($prefixe) . "-paquet";
		$t = "\n// Fichier produit par PlugOnet";
		$t = ecrire_fichier_langue_php($dirl, $lang, $module, $couples, $t);
		if ($t) 
			$files[]= substr($t, strlen($dir)+1);
	}

	return $files;
}


// --------------------- FONCTIONS UTILITAIRES -----------------------------------
//
// - extraction des multi d'une balise
// - choix de la fonction d'extraction des infos d'un plugin

// Expanse les multi en un tableau de textes complets, un par langue
function plugin2paquet_traite_mult($texte)
{
	if (!preg_match_all(_EXTRAIRE_MULTI, $texte, $regs, PREG_SET_ORDER))
		return array('fr' => $texte);
	$trads = array();
	foreach ($regs as $reg) {
		foreach (extraire_trads($reg[1]) as $k => $v) {
			// Si le code de langue n'est pas precise dans le multi c'est donc fr
			$lang = ($k) ? $k : 'fr';
			$trads[$lang]= str_replace($reg[0], $v, isset($trads[$k]) ? $trads[$k] : $texte);
		}
	}
	return $trads;
}

function plugin2paquet_infos($plug, $bof, $dir)
{
	$f = charger_fonction('infos_plugin', 'plugins');
	return $f(file_get_contents("$dir$plug/plugin.xml"), $plug, $dir);
}

function extraire_bornes($intervalle) {
	static $borne_vide = array('valeur' => '', 'incluse' => false);
	$bornes = array('min' => $borne_vide, 'max' => $borne_vide);

	if ($intervalle
	AND preg_match(',^[\[\(]([0-9.a-zRC\s\-]*)[;]([0-9.a-zRC\s\-]*)[\]\)]$,Uis', $intervalle, $matches)) {
		if ($matches[1]) {
			$bornes['min']['valeur'] = trim($matches[1]);
			$bornes['min']['incluse'] = ($intervalle{0} == "[");
		}
		if ($matches[2]) {
			$bornes['max']['valeur'] = trim($matches[2]);
			$bornes['max']['incluse'] = (substr($intervalle,-1) == "]");
		}
	}
	
	return $bornes;
}

?>
