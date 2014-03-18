<?php
/**
 * Plugin Tickets
 * Licence GPL (c) 2008-2013
 *
 * @package SPIP\Tickets\Fonctions
 */
 
if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Crée la liste des options du select des champs :
 * -* jalon
 * -* version
 * -* projet
 * -* composant
 * 
 * @param string $nom
 * 		Le nom du champ
 * @return array|false
 * 		Le tableau des valeurs possibles ou false si aucune
 */
function tickets_champ_optionnel_actif($nom){
	$constante = '_TICKETS_LISTE_' . strtoupper($nom);
	if (!defined($constante) && !lire_config('tickets/general/'.$nom))
		return false;
	if(defined($constante))
		$liste = constant($constante);
	else
		$liste = lire_config('tickets/general/'.$nom,'');

	if ($liste == '') return false;

	return array_map('trim',explode(':', $liste));
}

/**
 * 
 * Crée la liste des options du champ select d'assignation de ticket
 * Prend deux arguments optionnels :
 * -* $en_cours qui est l'id_auteur que l'on souhaite préselectionner
 * -* $format qui permet de choisir le format que la fonction renvoit :
 * -** rien ou autre chose que 'array' renverra les options d'un select
 * -** 'array' renverra un array des auteurs possibles
 * 
 * @param int $en_cours
 * @param string $format
 * @return multitype:array|string
 */
function tickets_select_assignation($en_cours='0',$format='select'){
	$options = NULL;
	$liste_assignables=array();
	
	include_spip('inc/tickets_autoriser');
	$select = array('nom','id_auteur');
	$from = array('spip_auteurs AS t1');
	
	$autorises = false;
	$type = lire_config('tickets/autorisations/assigneretre_type');
	if($type){
		switch($type) {
			case 'webmestre':
				// Webmestres uniquement
				$autorises['statut'] = array('0minirezo');
				$autorises['webmestre'] = 'oui';
				break;
			case 'par_statut':
				$autorises['statut'] = lire_config('tickets/autorisations/assigneretre_statuts',array('0minirezo'));
				break;
			case 'par_auteur':
				// Autorisation par id d'auteurs
				$autorises['auteur'] = lire_config('tickets/autorisations/assigneretre_auteurs',array());
				break;
		}
	}
	if(!$autorises)
		$autorises = definir_autorisations_tickets('assigneretre');
	
	if ($autorises['statut']){
		$where = array(sql_in('t1.statut', $autorises['statut']), 't1.email LIKE '.sql_quote('%@%'));
		if($autorises['webmestre'] == 'oui')
			$where[] = 't1.webmestre = '.sql_quote('oui');
	}
	else
		$where = array(sql_in('t1.id_auteur', $autorises['auteur']), 't1.email LIKE '.sql_quote('%@%'));

	$query_auteurs = sql_select($select, $from, $where);
	while ($row_auteur = sql_fetch($query_auteurs)) {
		$liste_assignables[$row_auteur["id_auteur"]] = $row_auteur["nom"];
		$selected = ($row_auteur["id_auteur"] == $en_cours) ? ' selected="selected"' : '';
		$options .= '<option value="' . $row_auteur["id_auteur"] . '"' . $selected . '>' . $row_auteur["nom"] . '</option>';
	}
	if($format=='array')
		return $liste_assignables;

	return $options;
}

// Affichage de la page des tickets classes par version
function tickets_classer_par_version($bidon) {
	$page = NULL;
	if (defined('_TICKETS_LISTE_VERSIONS') OR lire_config('tickets/general/versions')){
		if (defined('_TICKETS_LISTE_VERSIONS'))
			$liste = explode(":", _TICKETS_LISTE_VERSIONS);
		else
			$liste = explode(":", lire_config('tickets/general/versions'));
		
		$liste = array_map('trim',$liste);
		
		include_spip('inc/texte');
		$i = 0;
		foreach($liste as $_version) {
			$i += 1;
			$page .= recuperer_fond('prive/squelettes/inclure/inc_liste_detaillee',
				array_merge($_GET, array('titre' => _T('tickets:champ_version').' '.((strlen($_version) > 0) ? extraire_multi($_version) : _T('tickets:info_sans_version')), 'statut' => 'ouvert', 'version' => $_version, 'bloc' => "_bloc$i")),
				array('ajax'=>true));
		}
	}
	return $page;
}

// Affichage de la page des tickets classes par jalon
function tickets_classer_par_jalon($bidon) {
	$page = NULL;
	if (defined('_TICKETS_LISTE_JALONS') OR lire_config('tickets/general/jalons')) {
		if (defined('_TICKETS_LISTE_JALONS'))
			$liste = explode(":", _TICKETS_LISTE_JALONS);
		else
			$liste = explode(":", lire_config('tickets/general/jalons'));
			
		$liste = array_map('trim',$liste);
		
		$i = 0;
		foreach($liste as $_jalon) {
			$i += 1;
			$page .= recuperer_fond('prive/squelettes/inclure/inc_liste_detaillee',
				array_merge($_GET, array('titre' => _T('tickets:champ_jalon').' '.$_jalon, 'statut' => 'ouvert', 'jalon' => $_jalon, 'bloc' => "_bloc$i")),
				array('ajax'=>true));
		}
	}
	return $page;
}

// Affichage de la page des tickets classes par composant
function tickets_classer_par_composant($bidon) {
	$page = NULL;
	if (defined('_TICKETS_LISTE_COMPOSANTS') OR lire_config('tickets/general/composants')) {
		if (defined('_TICKETS_LISTE_COMPOSANTS'))
			$liste = explode(":", _TICKETS_LISTE_COMPOSANTS);
		else
			$liste = explode(":", lire_config('tickets/general/composants'));
			
		$liste = array_map('trim',$liste);
		
		$i = 0;
		foreach($liste as $_composant) {
			$i += 1;
			$page .= recuperer_fond('prive/squelettes/inclure/inc_liste_detaillee',
				array_merge($_GET, array('titre' => _T('tickets:champ_composant').' '.((strlen($_composant) > 0) ? $_composant : _T('tickets:info_sans')), 'statut' => 'ouvert', 'composant' => $_composant, 'bloc' => "_bloc$i")),
				array('ajax'=>true));
		}
	}
	return $page;
}

// Affichage de la page des tickets classes par projet
function tickets_classer_par_projet($bidon) {
	$page = NULL;
	if (defined('_TICKETS_LISTE_PROJETS') OR lire_config('tickets/general/projets')) {
		if (defined('_TICKETS_LISTE_PROJETS'))
			$liste = explode(":", _TICKETS_LISTE_PROJETS);
		else
			$liste = explode(":", lire_config('tickets/general/projets'));
		
		$liste = array_map('trim',$liste);
		
		$i = 0;
		foreach($liste as $_projet) {
			$i += 1;
			$page .= recuperer_fond('prive/squelettes/inclure/inc_liste_detaillee',
				array_merge($_GET, array('titre' => _T('tickets:champ_projet').' '.$_projet, 'statut' => 'ouvert', 'projet' => $_projet, 'bloc' => "_bloc$i")),
				array('ajax'=>true));
		}
	}
	return $page;
}

// creation des fonction de selection de texte
// encore en truc a reprendre !
foreach (array('severite', 'tracker', 'statut', 'navigateur') as $nom){
	eval("function tickets_texte_$nom(\$valeur) {
		\$type = tickets_liste_$nom();
		if (isset(\$type[\$valeur])) {
			return \$type[\$valeur];
		}
	}");
}

function tickets_icone_statut ($niveau,$full=false) {
	$img = array(
		"ouvert" => "puce-orange.gif",
		"resolu" => "puce-verte.gif",
		"ferme" => "puce-poubelle.gif",
		"poubelle" => "puce-poubelle.gif"
		);
	if($full)
		return '<img src="'.find_in_path('prive/images/'.$img[$niveau]).'" alt="'.tickets_texte_statut($niveau).'" />';
	else
		return $img[$niveau];
}

function tickets_icone_severite ($niveau,$full=false,$alt=false) {
	$img = array(
		1 => "puce-rouge-breve.gif",
		2 => "puce-orange-breve.gif",
		3 => "puce-verte-breve.gif",
		4 => "puce-poubelle-breve.gif"
		);
	if($full){
		$balise_img = charger_filtre('balise_img');
		$img = $balise_img(find_in_path('prive/images/'.$img[$niveau]));
		if($alt)
			$img = inserer_attribut($img,'alt',tickets_texte_severite($niveau));
		return $img;
	}
	else
		return $img[$niveau];
}

/**
 * Lister les statuts affichés dans les sélecteurs
 * 
 * On teste les autorisations à instituer à ce niveau de statut
 * 
 * @param int $id_ticket
 * 		L'identifiant numérique du ticket
 * @return array $statuts
 * 		La liste des statuts autorisés
 */
function tickets_liste_statut($id_ticket = null){
	$statuts = array(
		"ouvert" => _T("tickets:statut_ouvert"),
		"resolu" => _T("tickets:statut_resolu"),
		"ferme" => _T("tickets:statut_ferme"),
		"poubelle" => _T("tickets:statut_poubelle")
	);
	include_spip('inc/autoriser');
	foreach($statuts as $statut => $titre){
		if(!autoriser('instituer','ticket',$id_ticket,$GLOBALS['visiteur_session'],array('statut'=>$statut)))
			unset($statuts[$statut]);
	}
	return $statuts;
}


function tickets_liste_tracker($id_ticket = null){
	$trackers = array(
		1 => _T("tickets:type_probleme"),
		2 => _T("tickets:type_amelioration"),
		3 => _T("tickets:type_tache"),
	);
	$trackers = pipeline('tickets_liste_tracker',array('args'=>'nom_court','data'=>$trackers));
	return $trackers;
}

function tickets_liste_tracker_nom_long($id_ticket = null){
	$trackers = array(
		1 => _T("tickets:type_probleme_long"),
		3 => _T("tickets:type_tache_long"),
		2 => _T("tickets:type_amelioration_long"),
	);
	$trackers = pipeline('tickets_liste_tracker',array('args'=>'nom_long','data'=>$trackers));
	return $trackers;
}

function tickets_liste_severite($id_ticket = null){
	$severites = array(
		1 => _T("tickets:severite_bloquant"),
		2 => _T("tickets:severite_important"),
		3 => _T("tickets:severite_normal"),
		4 => _T("tickets:severite_peu_important"),
	);
	return $severites;
}

/**
 * Liste des navigateurs possibles
 */
function tickets_liste_navigateur($nav=false){
	$navs = array(
		'tous' => _T('tickets:option_navigateur_tous'),
		'android2' => 'Android 2.x',
		'android4' => 'Android 4.x',
		'firefox4' => 'Firefox <= 4',
		'firefox10' => 'Firefox <= 10',
		'firefox15' => 'Firefox <= 15',
		'firefox20' => 'Firefox <= 20',
		'chrome10' => 'Google <= 10',
		'chrome15' => 'Google Chrome <= 15',
		'chrome20' => 'Google Chrome <= 20',
		'chrome25' => 'Google Chrome <= 25',
		'chrome30' => 'Google Chrome > 25',
		'ie8' => 'Internet Explorer 8',
		'ie9' => 'Internet Explorer 9',
		'ie10' => 'Internet Explorer 10',
		'opera11' => 'Opera 11.x',
		'opera12' => 'Opera 12.x',
		'safari4' => 'Safari 4.x',
		'safari5' => 'Safari 5.x',
		'safariipad' => 'Safari Ipad',
		'autre' => _T('tickets:option_navigateur_autre')
	);
	return $navs;
}

/* Critere {mots_pargroupe} : "l'article est lie a au moins un mot de chacun des groupes demandes"
 * Ne s'applique que si au moins un mot est demande (si le tableau est vide, on ignore le critère)
 * On ignore la présence de '?' dans le critère
 */
function critere_mots_pargroupe_dist($idb, &$boucles, $crit,$id_ou_titre=false) {

	$boucle = &$boucles[$idb];

	// On ne prend pas en compte '?' mais on s'assure de récupérer le paramètre suivant s'il existe
	// le cas problématique : {mots_pargroupe ? #GET{tableau}}
	$num_param=0;
	if ($crit->cond && isset($crit->param[0][0]) && $crit->param[0][0]->type==='texte' && trim($crit->param[0][0]->texte)==='') {
		$num_param=1;
	}
	if (isset($crit->param[0][$num_param])) {
		$mots = calculer_liste(array($crit->param[0][$num_param]), array(), $boucles, $boucles[$idb]->id_parent);
	} else{
		$mots = '@$Pile[0]["mots"]';
	}

	$boucle->hash .= '
	// {MOTS}
	$prepare_mots_pargroupe = charger_fonction(\'prepare_mots_pargroupe\', \'inc\');
	$mots_where = $prepare_mots_pargroupe('.$mots.', "'.$boucle->id_table.'");
	';

	$t = $boucle->id_table . '.' . $boucle->primary;
	if (!in_array($t, $boucles[$idb]->select))
	  $boucle->select[]= $t; # pour postgres, neuneu ici

	$boucle->where[] = "\n\t\t".'$mots_where';
}
function inc_prepare_mots_pargroupe_dist($mots, $table='articles') {

	// Si le tableau $mots est vide, on ignore le critère
	if (!is_array($mots)
	OR !$mots = array_filter($mots)) {
		return '';
	}

	// Quel est l'objet ?
	$_table = table_objet($table);
	$objet_delatable=objet_type($_table);
	$_id_table = id_table_objet($table);
	// Tables spip_mots et spip_mots_liens
	$table_spip_mots = table_objet_sql('mots');
	$table_spip_mots_liens = table_objet_sql('mots_liens');

	/* On calcule la liste des groupes
	 * 
	 * SELECT id_groupe
	 * FROM spip_mots
	 * WHERE id_mot IN (1,2,3)
	 * GROUP BY id_groupe
	 */
	$groupes = '('.sql_get_select('id_groupe',$table_spip_mots,sql_in('id_mot',$mots),'id_groupe').') AS g';

	/* Maintenant le nombre de groupes
	 * 
	 * SELECT COUNT(id_groupe)
	 * FROM ($groupes) AS nb
	 */
	$nb_groupes = '('.sql_get_select('COUNT(id_groupe)',$groupes).')';

	/* Maintenant les doublets (id_objet,id_groupe)
	 * 
	 * attention : on écrit directement JOIN dans le code, peut être
	 * qu'il faudrait faire plus gaffe à la compatibilité SQL ?
	 * 
	 * SELECT ml.id_objet,m.id_groupe
	 * FROM spip_mots_liens AS ml
	 * JOIN spip_mots AS m USING (id_mot)
	 * WHERE ml.objet='ticket'
	 *   AND ml.id_mot IN (1,2,3)
	 * GROUP BY ml.id_objet,ml.objet,m.id_groupe
	 */
	$doublets = '('.sql_get_select('id_objet,id_groupe',$table_spip_mots_liens.' JOIN '.$table_spip_mots.' USING (id_mot)','objet='.sql_quote($objet_delatable).' AND '.sql_in('id_mot',$mots),'id_objet,objet,id_groupe').') AS d';

	/* Enfin, la boucle complete
	 * SELECT id_objet
	 * FROM (
	 *   SELECT id_objet,id_groupe
	 *   FROM spip_mots_liens AS ml
	 *   JOIN spip_mots AS m USING (id_mot)
	 *   WHERE objet='ticket'
	 *     AND id_mot IN (1,2,3)
	 *   GROUP BY id_objet,objet,id_groupe
	 * ) AS d
	 * GROUP BY id_objet
	 * HAVING SUM(1) >= (
	 *   SELECT COUNT(*)
	 *   FROM (
	 *     SELECT id_groupe
	 *     FROM spip_mots
	 *     WHERE id_mot IN (1,2,3)
	 *     GROUP BY id_groupe
	 *   ) AS g
	 * )
	 */
	$where = sql_get_select('id_objet',$doublets,'','id_objet','','','SUM(1) >= '.$nb_groupes);

	/* On ajoute ce critère à la boucle (TICKETS)
	 * 
	 */
	return sql_in($_table.'.'.$_id_table, $where);

}
?>
