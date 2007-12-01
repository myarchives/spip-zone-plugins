<?php



/*
 * Balise #JQUERY_PLUGIN{x1, x2...}
 * 
 * Ecrit le code html appelant le script jQuery UI
 * indique par x
 * 
 * Exemples : 
 * - #JQUERY_PLUGIN{ui.tabs}
 * - #JQUERY_PLUGIN{ui.droppable, ui.mouse}
 */
function balise_JQUERY_PLUGIN($p){

	if (!is_array($p->param))
		$p->param=array();
	
	$i = 0;
	$liste_plugins = jqueryp_liste_plugins_dispo();
	$p->code = "''";
	while ($plug = interprete_argument_balise(++$i, $p)){
		if  ($plug == "''") 
			continue;
		$plug = str_replace("'", "", $plug);
		if (isset($liste_plugins[$plug])) {
			jqueryp_add_script($p, $liste_plugins[$plug]);
		}	
	}
	$p->interdire_scripts = false;
	
	return $p;
}

/* Balise #JQUERY_PLUGIN{x, y1, y2...}
 *  
 * x : le nom du squelette css a interpreter
 * ou le nom d'un theme connu (light, dark, flora...)
 * 
 * Optionnellement le nom des plugins qui ont un theme specifique
 * comme flora.tabs.css 
 * #JQUERY_PLUGIN{flora} // theme de ui
 * #JQUERY_PLUGIN{flora, tabs} ajoute flora.css et flora.tabs.css
 * #JQUERY_PLUGIN{monquelette.css} ajoute un lien vers un squelette compile (monsquelette.css.html)
 */
function balise_JQUERY_PLUGIN_THEME($p){
	if (!is_array($p->param))
		$p->param=array();
		
	$p->code = "''";
	
	$theme = interprete_argument_balise(1, $p);
	if ($theme = str_replace("'", "", $theme)){

		// squelette css
		if (!jqueryp_add_link($p, $theme, true)){
			// ou theme comme jquery.ui flora
			$liste_themes = jqueryp_liste_themes_dispo();
			if (isset($liste_themes[$theme])) {
				jqueryp_add_link($p, $liste_themes[$theme] . '/' . $theme . '.css');
				// extensions des themes flora.tabs
				$i = 1;
				while ($plug = interprete_argument_balise(++$i, $p)){
					if  ($plug == "''") 
						continue;
					$plug = str_replace("'", "", $plug);
					jqueryp_add_link($p, $liste_themes[$theme] . '/' . $theme . '.' . $plug . '.css');
				}				
			}
		}
	}

	$p->interdire_scripts = false;
	return $p;
}
	
/* ajoute le code html <script ... /> */
function jqueryp_add_script(&$p, $adresse){
	if ($f = find_in_path($adresse))
		return $p->code .= '. "\n<script type=\"text/javascript\" src=\"'
				. $f . '\"></script>"';	
						
	return false;
}
	
/* ajoute le code html <link ... /> */
function jqueryp_add_link(&$p, $adresse, $generer_url=false){
	$_adresse = (($generer_url) ? $adresse . '.html' : $adresse);
	if ($f = find_in_path($_adresse))
		return $p->code .= '. "\n<link rel=\"stylesheet\" href=\"' 
				. (($generer_url)?generer_url_public($adresse):$f)
				. '\" type=\"text/css\" media=\"screen\" />"';	
	
	return false;
}

/* 
 * Retourne le contenu des fichiers js des plugin jquery dont les id 
 * sont envoyes.
 * 
 * - renvoie un array() avec le nom des fichiers à inserer
 *   pour le pipeline insert_js
 * jqueryp_add_plugins('ui.tabs', $flux);
 * jqueryp_add_plugins('ui.tabs','ui.dimensions', $flux);
 * 
 * - renvoie <script language='javascript'>...</script>
 *   pour le pipeline insert_head (compatibilite 1.9.2)
 * jqueryp_add_plugins('ui.tabs');
 * jqueryp_add_plugins(array('ui.tabs','ui.dimensions'));
 * 
 */
function jqueryp_add_plugins($plugins, $flux=null){
	static $lpda; // liste plugins deja actifs (même nom OU meme adresse)
		
	if (empty($lpda)) $lpda = array('nom' => array(), 'adresse' => array());
	if (!is_array($plugins)) $plugins = array($plugins);
	
	$lpa = jqueryp_liste_plugins_dispo();	
	$res = '';
	foreach ($plugins as $nom){
		if ($lpda['nom'][$nom] OR $lpda['adresse'][$lpa[$nom]])
			continue;
			
		if ($c = find_in_path($lpa[$nom])) {
			if (isset($flux)){
				if ($flux['type']=='fichier')
					$flux['data'][$nom] = substr($lpa[$nom],0,-3); // enlever '.js'
				elseif ($flux['type']=='inline')
					$flux['data'][$nom] =  spip_file_get_contents($c);
			} else {
				// inline dans insert_head (compat 1.9.2)
				$res .=  "\n\n" . spip_file_get_contents($c) . "\n\n";	
			}
			// pas deux fois la meme chose...
			$lpda['nom'][$nom] = $lpda['adresse'][$lpa[$nom]] = true;
		} else {
			spip_log("Adresse introuvable ($lpa[$nom]) sur $nom",'jquery_plugins');
		}
	}

	if (isset($flux))
		return $flux;
	else
		return "<script language='javascript'>" . $res . "</script>";
}

/* fourni un tableau 'nom' => 'adresse' des plugins possibles */
function jqueryp_liste_plugins_dispo($groupe = ''){
	$l = jqueryp_liste_dispo($groupe);
	return $l['plugins'];
}

/* fourni un tableau 'nom' => 'adresse' des themes possibles */
function jqueryp_liste_themes_dispo($groupe = ''){
	$l = jqueryp_liste_dispo($groupe);
	return $l['themes'];
}


function jqueryp_liste_dispo($groupe = ''){
	global $jquery_plugins;
	
	$liste_plugins = array();
	$liste_themes = array();
	
	if (!$groupe){
		foreach ($jquery_plugins as $nom_ext=>$extension) {
			_jquery_liste($nom_ext, $extension, &$liste_plugins, &$liste_themes);
		}
	} elseif (isset($jquery_plugins[$groupe]) ) {
		_jquery_liste($groupe, $jquery_plugins[$groupe], &$liste_plugins, &$liste_themes);
	}

	return array('plugins' => $liste_plugins, 'themes'  => $liste_themes);
}


function _jquery_liste($nom_ext, $extension, &$liste_plugins, &$liste_themes){
	if (isset($extension['files'])){
		foreach ($extension['files'] as $nom=>$fichier){
			$liste_plugins[$nom] = _DIR_LIB . $extension['dir'] . '/' . $fichier;
		}
	}
	if (isset($extension['themes'])){
		foreach ($extension['themes'] as $nom=>$dossier){
			$liste_themes[$nom] = _DIR_LIB . $extension['dir'] . '/' . $extension['dir_themes'] . '/' . $dossier;			
		}
	}
}
	
	
function jqueryp_liste_plugins_actifs(){
	$l = jqueryp_liste_actifs();
	return $l['plugins'];
}

function jqueryp_liste_actifs(){
	// liste plugins (nom->adresse)
	$lpa = lire_config('jqueryp/plugins_actifs');
	$lpd  = jqueryp_liste_plugins_dispo();

	$lp = array();
	if (is_array($lpa)){
		foreach ($lpa as $p){
			$lp[$p] = $lpd[$p];	
		}
	}
	
	return 
		array(
			'plugins' => $lp
		);
}

function balise_JQUERY_PLUGINS_DISPO_dist($p) {
	if(function_exists('balise_ENV'))
		return balise_ENV($p, 'jqueryp_liste_plugins_groupe()');
	else
		return balise_ENV_dist($p, 'jqueryp_liste_plugins_groupe()');
	return $p;
}

function balise_JQUERY_PLUGINS_DISPO_GROUPE_dist($p) {
	if(function_exists('balise_ENV'))
		return balise_ENV($p, 'jqueryp_liste_plugins_dispo_groupe()');
	else
		return balise_ENV_dist($p, 'jqueryp_liste_plugins_dispo_groupe()');
	return $p;
} 

function jqueryp_liste_plugins_groupe(){
	global $jquery_plugins;
	
	$groupes = array();
	$actifs = array_keys(jqueryp_liste_plugins_actifs());
	
	foreach ($jquery_plugins as $nom_ext=>$valeurs) {
		$groupes[$nom_ext] = 'replie';
		// pour depliage auto de la liste
		// si un des plugins est coche
		foreach (jqueryp_liste_plugins_dispo($nom_ext) as $nom=>$url){
			if (in_array($nom, $actifs)){
				$groupes[$nom_ext] = 'deplie';
				break;
			}
		}
	}
	return $groupes;
}

/* 
 * fonction pour balise foreach qui ne peut passer directement des arguments
 * enfin, du moins, je n'ai pas trouve comment
 */
function jqueryp_liste_plugins_dispo_groupe($groupe = ''){
	static $plugins = array();
	
	// on stocke tous les plugins commencant pas '$groupe'
	if (!empty($groupe)){
		$plugins = jqueryp_liste_plugins_dispo($groupe);
		return true;
	}
	
	return $plugins;
}
?>
