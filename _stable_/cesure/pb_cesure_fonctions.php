<?php
			/*#################################################################################
			# Project: Web Hyphenation 1.2 (c) yellowgreen designbüro                         #
			# For more information, go to http://yellowgreen.de/hyphenation.                  #
			# License: http://creativecommons.org/licenses/by-sa/3.0/                         #
			# Hyphenation online generator: http://yellowgreen.de/soft-hyphenation-generator  #
			#################################################################################*/

// SETTINGS


		define(_PB_HYPHEN, "&#173;");
		
		$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__))));
		define('_DIR_PLUGIN_PB_CESURE',(_DIR_PLUGINS.end($p)));

		define (_PB_PATH_TO_PATTERNS, _DIR_PLUGIN_PB_CESURE."patterns/");
		define(_PB_DICTIONARY, "dictionary.txt");
		define (_PB_EXCLUDE_TAGS, "code,pre,script,style,pbperso");



// FUNCTIONS
			
			// Function: Replace by comparing
			function pb_str_replace_comp($needle, $replace, $string_a, $string_b) {
				$position = 0;
				while($position !== false && $position < mb_strlen($string_a)) {
					$position = mb_strpos($string_a, $needle, $position + 1);
					if($position != 0) $string_b = mb_substr($string_b, 0, $position) . $replace . mb_substr($string_b, $position);
				}
				return $string_b;
			}

			// Function: Word hyphenation
			function pb_word_hyphenation($word) {
				if(mb_strlen($word) < $GLOBALS["pb_charmin"]) return $word;
				
				if(($key = array_search(strtolower($word), $GLOBALS["dictionary_words"])) !== false)
					return pb_str_replace_comp("/", _PB_HYPHEN, trim($GLOBALS["pb_dictionary"][$key]), $word);
			
				$positions = ""; $hyphenated_word = ""; $word_without_PB_HYPHEN = "";
				$tex_word = " " . mb_strtolower($word) . " ";
				for($i = 0; $i < mb_strlen($tex_word); $i++) $positions .= 0;
				
				for($start = 0; $start < mb_strlen($tex_word); $start++) {
					for($length = 1; $length <= mb_strlen($tex_word) - $start; $length++) {
						$patterns_index = mb_substr(mb_substr($tex_word, $start), 0, $length);
						if(isset($GLOBALS["patterns"][$patterns_index])) {
							$values = $GLOBALS["patterns"][$patterns_index];
							$i = $start;
							
							for($p = 0; $p < mb_strlen($values); $p++) {
								$value = mb_substr($values, $p, 1);
 								if($value > $positions[$i - 1]) $positions[$i - 1] = $value;
								$i++;
							}
						}
					}
				}
				
				$positions = trim($positions);
		
				for($i = 0; $i < mb_strlen($word); $i++) {
					$word_without_PB_HYPHEN = str_replace(_PB_HYPHEN, "", $hyphenated_word);
					if($positions[$i] % 2 != 0 && $i != 0 && $i >= $GLOBALS["pb_leftmin"] && $i <= mb_strlen($word) - $GLOBALS["pb_rightmin"]) $hyphenated_word .= mb_substr($word, mb_strlen($word_without_PB_HYPHEN), $i - mb_strlen($word_without_PB_HYPHEN)) . _PB_HYPHEN;
				}
				
				$hyphenated_word .= mb_substr($word, mb_strlen($word_without_PB_HYPHEN), $i - mb_strlen($word_without_PB_HYPHEN));
				
				return $hyphenated_word;
			}



			function pb_effectuer_cesure($text, $lang="xxx") {


				$GLOBALS["pb_leftmin"] = 2;
				$GLOBALS["pb_rightmin"] = 2;
				$GLOBALS["pb_charmin"] = 4;
				mb_internal_encoding("utf-8");
			
			
				if(file_exists(_PB_PATH_TO_PATTERNS . $lang . ".php")) { include(_PB_PATH_TO_PATTERNS . $lang . ".php"); $GLOBALS["patterns"] = $patterns; } else $GLOBALS["patterns"] = array();
				file_exists(_PB_DICTIONARY) ? $GLOBALS["pb_dictionary"] = file(_PB_DICTIONARY) : $GLOBALS["pb_dictionary"] = array();
				$GLOBALS["dictionary_words"] = $GLOBALS["pb_dictionary"];
				for($i = 1; $i < count($GLOBALS["pb_dictionary"]); $i++) $GLOBALS["dictionary_words"][$i] = str_replace("/", "", strtolower(trim($GLOBALS["pb_dictionary"][$i])));

				$word = ""; $tag = ""; $tag_jump = 0; $output = array();
				$word_boundaries = "<>\t\n\r\0\x0B !\"§$%&/()=?….,;:-–_„”«»‘’'/\\‹›()[]{}*+´`^|©℗®™℠¹²³";


				$text = $text . " ";
				
				for($i = 0; $i < mb_strlen($text); $i++) {
					$char = mb_substr($text, $i, 1);
					if(mb_strpos($word_boundaries, $char) === false && $tag == "") {
						$word .= $char;
					} else {
						if($word != "") { 
							// Couper les mots, sauf ceux avec majuscule initiale (francais, anglais)
							if (($lang == "fr" || $lang =="en")) {
								if (ereg("^[A-ZÀÉÈÎ]", $word)) $output[] = $word; 
								else $output[] = pb_word_hyphenation($word);
							}
							else {
								$output[] = pb_word_hyphenation($word);
							}
							$word = ""; 
						}
						if($tag != "" || $char == "<") $tag .= $char;
						if($tag != "" && $char == ">") {
							$tag_name = (mb_strpos($tag, " ")) ? mb_substr($tag, 1, mb_strpos($tag, " ") - 1) : mb_substr($tag, 1, mb_strpos($tag, ">") - 1);
							if($tag_jump == 0) {
								if(in_array($tag_name, explode(',',_PB_EXCLUDE_TAGS))) $tag_jump = 1; else { $output[] = $tag; $tag = ""; }
							} else { $output[] = $tag; $tag = ""; }
						}
						if($tag == "" && $char != "<" && $char != ">") $output[] = $char;
					}
				}
				
				$text = join($output);

				if (strlen($regexp_finale))
					$text = preg_replace($regexp_finale, '\1\2', $text);

				return substr($text, 0, strlen($text) - 1);			
			}
			// Function: Text hyphenation
			function cesure($text, $lang="xxx") {
			
			

				if (ereg("<p[^>]*>", $text)) {
					$text = preg_replace("/<p([^>]*)>(.*)<\/p>/miseU", "'<p\\1>'.stripslashes(pb_effectuer_cesure('\\2',$lang)).'</p>'", $text);
				} else {
					$text = pb_effectuer_cesure($text, $lang);
				}
				
				// Corriger quand cesure a l'interieur d'un caractere special, genre &ccedil;
				$text = preg_replace("/&([a-zA-Z])+".str_replace("#", "\#", preg_quote(_PB_HYPHEN))."([a-z])+;/", "&\\1\\2;", $text);
				
				return $text;
			}
?>