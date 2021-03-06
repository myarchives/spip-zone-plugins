<?php
/**
 * Critères pour la gestion de dates empruntÃ©es du plugin agenda
 * Tirés de agenda/public/agenda.php.
 *
 * @plugin     Dates outils
 * @copyright  2018 - 2020
 * @author     Rainer Müller
 * @licence    GNU/GPL v3
 * @package    SPIP\Dates_outils\Criteres
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * fonction sous jacente pour les 3 criteres
 * fusion_par_jour, fusion_par_mois, fusion_par_annee
 *
 * @param string $format
 * @param strinf $as
 * @param string $idb
 * @param object $boucles
 * @param object $crit
 */
if (!function_exists('dates_critere_fusion_par_xx')) {
	function dates_critere_fusion_par_xx($format, $as, $idb, &$boucles, $crit) {
		$boucle = &$boucles[$idb];
		$type = $boucle->type_requete;
		$_date = isset($crit->param[0]) ? calculer_liste($crit->param[0], array(), $boucles, $boucles[$idb]->id_parent)
		: "'".(isset($GLOBALS['table_date'][$type]) ? $GLOBALS['table_date'][$type] : 'date')."'";

		$date = $boucle->id_table. '.' .substr($_date, 1, -1);

		// annuler une eventuelle fusion sur cle primaire !
		foreach ($boucles[$idb]->group as $k => $g) {
			if ($g == $boucle->id_table.'.'.$boucle->primary) {
				unset($boucles[$idb]->group[$k]);
			}
		}
		$boucles[$idb]->group[]  = 'DATE_FORMAT('.$boucle->id_table.'.".'.$_date.'.", ' . "'$format')";
		$boucles[$idb]->select[] = 'DATE_FORMAT('.$boucle->id_table.'.".'.$_date.'.", ' . "'$format') AS $as";
	}
}

/**
 * {fusion_par_jour date_debut}
 * {fusion_par_jour date_fin}
 *
 * @param string $idb
 * @param object $boucles
 * @param object $crit
 */
if (!function_exists('critere_fusion_par_jour_dist')) {
	function critere_fusion_par_jour_dist($idb, &$boucles, $crit) {
		dates_critere_fusion_par_xx('%Y-%m-%d', 'jour', $idb, $boucles, $crit);
	}
}


/**
 * {fusion_par_mois date_debut}
 * {fusion_par_mois date_fin}
 *
 * @param string $idb
 * @param object $boucles
 * @param object $crit
 */
if (!function_exists('critere_fusion_par_jour_dist')) {
	function critere_fusion_par_mois_dist($idb, &$boucles, $crit) {
		dates_critere_fusion_par_xx('%Y-%m', 'mois', $idb, $boucles, $crit);
	}
}

/**
 * {fusion_par_annee date_debut}
 * {fusion_par_annee date_fin}
 *
 * @param string $idb
 * @param object $boucles
 * @param object $crit
 */
if (!function_exists('critere_fusion_par_annee_dist')) {
	function critere_fusion_par_annee_dist($idb, &$boucles, $crit) {
		agenda_critere_fusion_par_xx('%Y', 'annee', $idb, $boucles, $crit);
	}
}

/**
 * {dates_a_venir}
 * {dates_a_venir #ENV{date}}
 *
 * @param string $idb
 * @param object $boucles
 * @param object $crit
 */
function critere_dates_a_venir_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$id_table = $boucle->id_table;

	$_dateref = dates_calculer_date_reference($idb, $boucles, $crit);
	$_date = "$id_table.date_debut";
	$op = $crit->not ? '<=' : '>';

	// si on ne sait pas si les heures comptent, on utilise toute la journee.
	// sinon, on s'appuie sur le champ 'horaire=oui'
	// pour savoir si les dates utilisent les heures ou pas.
	$where_futur_sans_heure =
	array("'$op'", "'$_date'", "sql_quote(date('Y-m-d 23:59:59', strtotime($_dateref)))");

	if (array_key_exists('horaire', $boucle->show['field'])) {
		$where =
		array("'OR'",
			array("'AND'",
				array("'='", "'horaire'", "sql_quote('oui')"),
				array("'$op'","'$_date'","sql_quote($_dateref)")
			),
			array("'AND'",
				array("'!='", "'horaire'", "sql_quote('oui')"),
				$where_futur_sans_heure
			)
		);
	} else {
		$where = $where_futur_sans_heure;
	}

	$boucle->where[] = $where;
}

/**
 * {dates_passe}
 * {dates_passe #ENV{date}}
 *
 * @param string $idb
 * @param object $boucles
 * @param object $crit
 */
function critere_dates_passe_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$id_table = $boucle->id_table;

	$_dateref = dates_calculer_date_reference($idb, $boucles, $crit);
	$_date = "$id_table.date_fin";
	$op = $crit->not ? '>=' : '<';

	// si on ne sait pas si les heures comptent, on utilise toute la journee.
	// sinon, on s'appuie sur le champ 'horaire=oui'
	// pour savoir si les dates utilisent les heures ou pas.
	$where_passe_sans_heure =
	array("'$op'", "'$_date'", "sql_quote(date('Y-m-d 00:00:00', strtotime($_dateref)))");

	if (array_key_exists('horaire', $boucle->show['field'])) {
		$where =
		array("'OR'",
			array("'AND'",
				array("'='", "'horaire'", "sql_quote('oui')"),
				array("'$op'","'$_date'","sql_quote($_dateref)")
			),
			array("'AND'",
				array("'!='", "'horaire'", "sql_quote('oui')"),
				$where_passe_sans_heure
			)
		);
	} else {
		$where = $where_passe_sans_heure;
	}


	$boucle->where[] = $where;
}

/**
 * {dates_en_cours}
 * {dates_en_cours #ENV{date}}
 *
 * @param string $idb
 * @param object $boucles
 * @param object $crit
 */
function critere_dates_en_cours_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$id_table = $boucle->id_table;

	$_dateref = dates_calculer_date_reference($idb, $boucles, $crit);
	$_date_debut = "$id_table.date_debut";
	$_date_fin = "$id_table.date_fin";

	// si on ne sait pas si les heures comptent, on utilise toute la journee.
	// sinon, on s'appuie sur le champ 'horaire=oui'
	// pour savoir si les dates utilisent les heures ou pas.
	$where_jour_sans_heure =
	array("'AND'",
		array("'<='", "'$_date_debut'", "sql_quote(date('Y-m-d 23:59:59', strtotime($_dateref)))"),
		array("'>='", "'$_date_fin'", "sql_quote(date('Y-m-d 00:00:00', strtotime($_dateref)))")
	);

	if (array_key_exists('horaire', $boucle->show['field'])) {
		$where =
		array("'OR'",
			array("'AND'",
				array("'='", "'horaire'", "sql_quote('oui')"),
				array("'AND'",
					array("'<='", "'$_date_debut'", "sql_quote($_dateref)"),
					array("'>='", "'$_date_fin'", "sql_quote($_dateref)")
				)
			),
			array("'AND'",
				array("'!='", "'horaire'", "sql_quote('oui')"),
				$where_jour_sans_heure
			)
		);
	} else {
		$where = $where_jour_sans_heure;
	}

	if ($crit->not) {
		$where = array("'NOT'",$where);
	}
	$boucle->where[] = $where;
}

/**
 * {daterelatif #ENV{choix}}
 * {daterelatif #ENV{choix}, #ENV{date}}
 * #ENV{choix} peut prendre 6 valeurs : tout, a_venir, en_cours, passe, en_cours_a_venir ou passe_en_cours
 *
 * @param string $idb
 * @param object $boucles
 * @param object $crit
 */
function critere_daterelatif_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$id_table = $boucle->id_table;
	if (isset($crit->param[1])) {
		$_dateref = calculer_liste($crit->param[1], array(), $boucles, $boucles[$idb]->id_parent);
	} else {
		$_dateref = "date('Y-m-d H:i:00')";
	}
	$not = $crit->not ? 'oui' : '';
	$choix = isset($crit->param[0]) ? calculer_liste($crit->param[0], array(), $boucles, $boucles[$idb]->id_parent) : "''";
	$horaire = array_key_exists('horaire', $boucle->show['field']) ? 'oui' : '';

	$boucle->where[] = "agenda_calculer_critere_datelatif('$id_table',$_dateref,'$not',$choix,'$horaire')";
}

/**
 * Fonction interne utilisee par le critere {evenementrelatif}
 * @param string $id_table
 * @param string $_dateref
 * @param string $not
 * @param string $choix
 * @param string $horaire
 * @return array
 */
function agenda_calculer_critere_daterelatif($id_table, $_dateref, $not, $choix, $horaire) {
	$_date_debut = "$id_table.date_debut";
	$_date_fin = "$id_table.date_fin";
	if ($choix == 'en_cours_a_venir') {
		$choix = 'passe';
		$not = ($not) ? '' : 'oui';
	}
	if ($choix == 'passe_en_cours') {
		$choix = 'a_venir';
		$not = ($not) ? '' : 'oui';
	}

	switch ($choix) {
		case 'a_venir':
			$op_a_venir = $not ? '<=' : '>';
			$where_a_venir_sans_heure =
			array($op_a_venir, $_date_debut, sql_quote(date('Y-m-d 23:59:59', strtotime($_dateref))));
			if ($horaire) {
				$where =
				array('OR',
					array('AND',
						array('=', 'horaire', sql_quote('oui')),
						array($op_a_venir,$_date_debut,sql_quote($_dateref))
					),
					array('AND',
						array('!=', 'horaire', sql_quote('oui')),
						$where_a_venir_sans_heure
					)
				);
			} else {
				$where = $where_a_venir_sans_heure;
			}
			return $where;
			break;

		case 'passe':
			$op_passe = $not ? '>=' : '<';
			$where_passe_sans_heure =
			array($op_passe, $_date_fin, sql_quote(date('Y-m-d 00:00:00', strtotime($_dateref))));
			if ($horaire) {
				$where =
				array('OR',
					array('AND',
						array('=', 'horaire', sql_quote('oui')),
						array($op_passe,$_date_fin,sql_quote($_dateref))
					),
					array('AND',
						array('!=', 'horaire', sql_quote('oui')),
						$where_passe_sans_heure
					)
				);
			} else {
				$where = $where_passe_sans_heure;
			}
			return $where;
			break;

		case 'en_cours':
			$where_en_cours_sans_heure =
			array('AND',
			array('<=', $_date_debut, sql_quote(date('Y-m-d 23:59:59', strtotime($_dateref)))),
			array('>=', $_date_fin, sql_quote(date('Y-m-d 00:00:00', strtotime($_dateref))))
			);
			if ($horaire) {
				$where =
				array('OR',
					array('AND',
						array('=', 'horaire', sql_quote('oui')),
						array('AND',
							array('<=', $_date_debut, sql_quote($_dateref)),
							array('>=', $_date_fin, sql_quote($_dateref))
						)
					),
					array('AND',
						array('!=', 'horaire', sql_quote('oui')),
						$where_en_cours_sans_heure
					)
				);
			} else {
				$where = $where_en_cours_sans_heure;
			}
			return ($not) ? array('NOT' , $where) : $where;
			break;

		default:
			return array();
			break;
	}
}

/**
 * Fonction privee pour mutualiser de code des criteres_evenement_*
 * Retourne le code php pour obtenir la date de reference de comparaison
 * des evenements a trouver
 *
 * @param string $idb
 * @param object $boucles
 * @param object $crit
 *
 * @return string code PHP concernant la date.
 **/
function dates_calculer_date_reference($idb, &$boucles, $crit) {
	if (isset($crit->param[0])) {
		return calculer_liste($crit->param[0], array(), $boucles, $boucles[$idb]->id_parent);
	} else {
		return "date('Y-m-d H:i:00')";
	}
}

