<?php
/*
 * Plugin xxx
 * (c) 2009 xxx
 * Distribue sous licence GPL
 *
 */


/**
 * Analyse un fichier source php
 * et ressort la liste des fonctions nommes et pour chacune la liste de ses arguments
 *
 * @param string $filename
 * @return array
 */
function tb_liste_fonctions($filename, $clear = false){
	static $funcs=array();
	$filename = find_in_path($filename);
	if (!$filename) return array();

	if ($clear){
		unset($funcs[$filename]);
		return array();
	}

	if (isset($funcs[$filename]))
		return $funcs[$filename];

	// cache file ?
	$cache_func = sous_repertoire(_DIR_CACHE,"functions")."f".md5($filename).".txt";
	if (file_exists($cache_func)
		AND @filemtime($cache_func)>@filemtime($filename)
		AND lire_fichier($cache_func, $cache)
		AND $cache = unserialize($cache))
		return $funcs[$filename] = $cache;


	lire_fichier($filename,$content);
	if (!trim($content)) return $funcs[$filename] = array();

	$tokens = token_get_all($content);
	$funcs = array();
	$previous_token_line = 0;
	$func_name = "";
	while (count($tokens)){
		$t = array_shift($tokens);
		if (is_string($t) AND $t=='}')
			$previous_token_line=0;
		if (!is_string($t) AND $previous_token_line==0)
			$previous_token_line = $t[2];
		if (!is_string($t) AND in_array($t[0],array(T_INCLUDE,T_INCLUDE_ONCE,T_STRING,T_ECHO)))
			$previous_token_line=0;

		#if (!is_string($t)) echo token_name($t[0]).":".$t[1].":".$t[2]."<br />";
		if ($t[0]==T_FUNCTION){
			#die();
			// si on avait trouve une fonction auparavant, lui affecter la ligne de fin
			if ($func_name AND $funcs[$filename][$func_name])
				$funcs[$filename][$func_name][3] = $previous_token_line-1;

			while (count($tokens) AND $t[0]!==T_STRING) $t = array_shift($tokens);
			$func_line = $t[2];
			$func_name = $t[1];
			$func_args = array();
			$open_token = 0;
			while (count($tokens) AND $t!=='(') $t = array_shift($tokens);
			$open_token++;
			while (count($tokens) AND $open_token){
				$t = array_shift($tokens);
				if ($t==')') $open_token--;
				elseif ($t=='(') $open_token++;
				else if ($t[0]==T_VARIABLE){
					$arg = $arg_aff = $t[1];
					$func_args[] = $arg;
				}
			}
			$funcs[$filename][$func_name] = array($func_args,$func_line,min($previous_token_line+1,$func_line),$func_line+10);
		}
	}
	if ($func_name AND $funcs[$filename][$func_name])
		$funcs[$filename][$func_name][3] = $previous_token_line;

	ecrire_fichier($cache_func, serialize($funcs[$filename]));
	return $funcs[$filename];
}

/**
 * Lister les repertoires de test dispo
 * 
 * @return array()
 */
function tb_liste_dirs_tests(){
	$bases = array(_DIR_RACINE . 'tests/');
	foreach (creer_chemin() as $d) {
		if ($d && @is_dir("${d}tests"))
			$bases[] = "${d}tests/";
	}
	return $bases;
}

/**
 * Lister les tests dispos
 *
 * @return array()
 */
function tb_liste_tests(){
	$liste_tests = array();
	$bases = tb_liste_dirs_tests();
	foreach ($bases as $base) {
		// regarder tous les tests
		$tests = preg_files($base, '/\w+/.*\.(php|html)$');

		foreach ($tests as $test) {
			//ignorer le contenu du jeu de squelettes dédié aux tests
			if (stristr($test,'squelettes'))
				continue;

			//ignorer les fichiers lanceurs pour simpleTests aux tests
			if (stristr($test,'lanceur_spip.php'))
				continue;
			if (stristr($test,'all_tests.php'))
				continue;

			if (substr(basename($test),0,7) != 'inclus_' &&
				substr(basename($test),-14) != '_fonctions.php'){

				$joli = basename($test);
				$liste_tests[$joli] = $test;
			}
		}
	}
	return $liste_tests;
}

/**
 * Trouver si une fonction a un test
 * et retourne le chemin du test
 *
 * @staticvar array $tests
 * @param string $funcname
 * @return tring
 */
function tb_hastest($funcname){
	static $tests = null;
	if (is_null($tests))
		$tests = tb_liste_tests();
	if (isset($tests["$funcname.php"]))
		return $tests["$funcname.php"];
	if (isset($tests["$funcname.html"]))
		return $tests["$funcname.html"];

	return '';
}

/**
 * Url du test
 * 
 * @param <type> $testfun
 * @param <type> $lien
 * @return <type>
 */
function tb_url_test($testfun, $lien=false){
	if (!$testfun) return "";
	if (preg_match(',\.php$,', $testfun))
		$url = $testfun .'?mode=test_general';
	else
		$url = "tests/squel.php?test=$test&amp;var_mode=recalcul";
	if (!$lien)
		return $url;
	return "<a href='$url'>".basename($testfun)."</a>";
}

/**
 * Extraire une fonction php d'un script
 *
 * @param string $filename
 * @param strinf $funcname
 * @return string
 */
function tb_function_extract($filename,$funcname){
	$liste = tb_liste_fonctions($filename);
	$func = $liste[$funcname];
	$start = $func[2];
	$length = $func[3]-$start+1;

	lire_fichier(find_in_path($filename),$content);
	$content = explode("\n",$content);
	$content = array_slice($content, $start,$length);
	return trim(implode("\n",$content));
}


/**
 * Generer un nouveau test vierge
 * pour la fonction $funcname, du fichier $filename
 * 
 * @param <type> $filename
 * @param <type> $funcname
 * @param <type> $essais 
 */
function tb_generate_new_blank_test($filename,$funcname){
	lire_fichier(find_in_path("templates/function.php"),$template);

	$template = str_replace(
					array('@funcname@','@essais_funcname@','@filename@','@date@'),
					array($funcname,"essais_$funcname",$filename,strtotime('Y-m-d H:i')),
					$template
					);
	$d = sous_repertoire(_DIR_RACINE."tests/",basename($filename,'.php'));
	ecrire_fichier($f="$d/$funcname.php",$template);
	return $f;
}

/**
 * Lit un fichier de test existant et recupere le jeu d'essai qu'il contient
 * si un nouveau jeu d'essai est fourni, il remplace l'ancien
 * et le fichier est mis a jour
 *
 * @param string $filetest
 * @param array $essais_new
 */
function tb_test_essais($funcname,$filetest,$essais_new=null){
	$function = tb_function_extract($filetest,"essais_$funcname");
	#var_dump($function);
	if (is_array($essais_new)){
		lire_fichier($filetest, $contenu);
		$new_func = "\tfunction essais_$funcname(){
		\$essais = ".var_export($essais_new,true).";
		return \$essais;
	}
";
		$contenu = str_replace($function, $new_func, $contenu);
		ecrire_fichier($filetest, $contenu);
		// purger la liste de fonctions de ce fichier
		tb_liste_fonctions($filetest, true);
		return $essais_new;
		$function = $new_func;
	}
	$tst = "essais"; $i=0;

	while (function_exists("$tst$i")) $i++;

	$function = str_replace("function essais_$funcname"."(","function $tst$i"."(",$function);
	$function .= " return $tst$i();";
	return eval($function);
}

function tb_error_handler($output)
{
    $error = error_get_last();
    $output = "";
    foreach ($error as $info => $string)
        $output .= "{$info}: {$string}<br />";
    return $output;
}

function tb_try_essai($filename,$funcname,$essai,&$output_test){
	ob_start('tb_error_handler');
	try {
		find_in_path($filename,'',true);
		$appel = "$funcname(".implode(", ",$essai).")";
		#var_dump($appel);
		$res = eval("return $appel;");
	}
	catch (Exception $e) {
		$res = "Erreur : ".$e->getMessage();
	}
	$output_test = ob_get_contents();
	ob_end_clean();
	$output_test .= ($output_test?"<br />":"")."<tt>$appel = ".var_export($res,true)."</tt>";
	return $res;
}


/**
 * Definir des jeu de valeurs test par type d'argument
 * @param string $type
 * @return array
 */
function tb_jeu_test_argument($type){
	$jeu = array();
	switch ($type){
		case 'bool':
			$jeu = array(true,false);
			break;
		case 'string':
			$jeu = array(
				'',
				'0',
				'Un texte avec des <a href="http://spip.net">liens</a> [Article 1->art1] [spip->http://www.spip.net] http://www.spip.net',
				'Un texte avec des entit&eacute;s &amp;&lt;&gt;&quot;',
				'Un texte sans entites &<>"\'',
				'{{{Des raccourcis}}} {italique} {{gras}} <code>du code</code>',
				'Un modele <modeleinexistant|lien=[->http://www.spip.net]>',
			);
			break;
		case 'int':
			$jeu = array(
				0,
				-1,
				1,
				2,
				3,
				4,
				5,
				6,
				7,
				10,
				20,
				30,
				50,
				100,
				1000,
				10000
			);
			break;
		case 'array':
			$jeu = array(
				array(),
				tb_jeu_test_argument('string'),
				tb_jeu_test_argument('int'),
				tb_jeu_test_argument('bool'),
			);
			$jeu[] = $jeu; // et un array d'array
			break;
	}
	return $jeu;
}

/**
 * Construire un jeu d'essai complet combinatoire
 * Pour chaque entree, on teste chaque valeur unitaire candidate
 * combinatoirement avec les autres entrees
 *
 * @param array $types
 */
function tb_essai_combinatoire($types){
	$essais = array();
	if (!count($types))
		return $essais;

	$type = array_shift($types);
	$es = tb_essai_combinatoire($types);
	$samples = tb_jeu_test_argument($type);
	foreach($samples as $s){
		if (count($es)){
			foreach($es as $e) {
				array_unshift($e,$s);
				$essais[] = $e;
			}
		}
		else
			$essais[] = array($s);
	}
	return $essais;
}
?>