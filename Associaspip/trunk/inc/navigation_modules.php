<?php
/***************************************************************************\
 *  Associaspip, extension de SPIP pour gestion d'associations
 *
 * @copyright Copyright (c) 2007 Bernard Blazin & Francois de Montlivault
 * @copyright Copyright (c) 2010 Emmanuel Saint-James
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
\***************************************************************************/

if (!defined('_ECRIRE_INC_VERSION'))
	return;

include_spip('inc/presentation'); // utilise par "onglet1_association" (pour "onglet") puis aussi dans les pages appelantes
include_spip('inc/autoriser'); // utilise par "onglet1_association" (pour le test "autoriser") puis aussi dans les pages appelantes

/**
 * Afficher le titre de la/le page/module courante puis (en dessous) les onglets
 * des differents modules actives dans la configuration
 *
 * @param string $titre
 *   Chaine de langue du titre de la page
 * @param string $top_exec
 *   Nom du fichier "exec" de la page principale du module
 * @param bool $INSERT_HEAD
 *   Indique s'il s'agit d'une page exec classique en PHP (vrai, par defaut) ou
 *   en HTML (faux, alors) a compiler par SPIP (cas des balises) ou par le dev
 * @return $res
 *   Debut de la page HTML de l'espace prive
 */
function association_navigation_onglets($titre='', $top_exec='', $INSERT_HEAD=TRUE) {
	$res = '';
// Recuperation de la liste des ongles
	// modules natifs toujours actifs
	$modules_actifs = array(
		array('menu2_titre_association', 'assoc_qui.png', array('association'), array('association','voir_profil'), ),
		array('menu2_titre_gestion_membres', 'annonce.gif', array('adherents'), array('association','voir_membres'), ),
	);
	// modules natifs actives en configuration
	foreach ( array('dons'=>'don-24.gif', 'ventes'=>'ventes.gif', 'activites'=>'activites.gif', 'ressources'=>'prets-24.gif', 'comptes'=>'finances-24.png') as $module=>$icone ) {
		if ( $GLOBALS['association_metas'][$module=='ressources'?'prets':$module] )
			$modules_actifs[] = array("menu2_titre_gestion_$module", $icone, array($module), array('association', $module='comptes'?'voir_compta':"voir_$module") );
	}
	$modules_externes = pipeline('associaspip', array()); // Tableau des modules ajoutes par d'autres plugins : 'prefixe_plugin'=> array( 0=>array(bouton,onglet,actif), 1=>array(bouton,config,actif) )
	foreach ( $modules_externes as $plugin=>$boutons ) {
		if ( test_plugin_actif($plugin) )
			$modules_actifs[] = $boutons[0];
	}
// Dessin de la liste des ongles
	$onglets_actifs = '';
	foreach ($modules_actifs as $module) {
		if ( association_acces($module[3]) ) { // generation de l'onglet
			$chemin = _DIR_PLUGIN_ASSOCIATION_ICONES.$module[1]; // icone Associaspip
			if ( !file_exists($chemin) )
				$chemin = find_in_path($module[1]); // icone alternative
			$onglets_actifs .= onglet(association_langue($module[0]), generer_url_ecrire($module[2][0],$module[2][1]), $top_exec, $module[2][0], $chemin); // http://doc.spip.org/onglet
		}
	}
// Affichage
	if ($INSERT_HEAD) { // mettre ''|0|FALSE|NULL dans la balise (appel dans une page HTML-SPIPee donc et non PHP) pour eviter l'erreur de "Double occurrence de INSERT_HEAD"
		$commencer_page = charger_fonction('commencer_page', 'inc');
		$res = $commencer_page();
	}
	$res .= '<div class="table_page">';
	$res .= '<h1 class="asso_titre">'. ( $titre?association_langue($titre):_T('asso:gestion_de_lassoc', array('nom'=>$GLOBALS['association_metas']['nom']) ) ) .'</h1>'; // Nom du module. cf:  <http://programmer.spip.org/Contenu-d-un-fichier-exec>
	if ($onglets_actifs)
		$res .= '<div class="bandeau_actions barre_onglet clearfix">'. debut_onglet() .$onglets_actifs. fin_onglet() .'</div>'; // Onglets actifs
	$res .= '</div>';
	if ($INSERT_HEAD) { // Tant qu'a faire, on s'embete pas a le retaper dans toutes les pages...
		$res .= debut_gauche('',TRUE);
		$res .= debut_boite_info(TRUE);
	}
	return $res;
}

/**
 * @see association_navigation_onglets
 */
function onglets_association($titre='', $top_exec='', $INSERT_HEAD=TRUE) {
	echo association_navigation_onglets($titre, $top_exec, $INSERT_HEAD);
}

/**
 * Bloc de raccourci(s)
 *
 * @param string $retour
 *     URL de retour
 * @param array $raccourcis
 *   Tableau des raccourcis definis chacun sous la forme :
 *   'titre' => array('icone', array('url_ecrire', 'parametres_url'), array('permission' ...), ),
 *   toutefois si le 2e element est une chaine, on la prend comme URL
 * @return void
 */
function association_navigation_raccourcis($retour='',  $raccourcis=array()) {
	$res = ''; // initialisation
	foreach($raccourcis as $titre => $params) {
		list($image, $url, $aut) = $params;
		if ( association_acces($aut) ) { // generation du raccourci
			if (is_array($url))
				$url = generer_url_ecrire($url[0],$url[1]);
			$res .= icone1_association($titre, $url, $image);
		}
	}

	if ($retour)
		$res .= icone1_association('asso:bouton_retour', $retour, 'retour-24.png');

	return association_date_du_jour()
	. fin_boite_info(TRUE)
	. bloc_des_raccourcis($res);
}

/**
 * Dessin d'un raccourci du bloc des raccourcis
 *
 * @param string $texte
 *   Libelle du bouton
 * @param string $lien
 *   URL vers lequel revoie le bouton
 * @param string $image
 *   Icone du bouton (place devant le libelle)
 * @return string
 *   HTML du raccourci (icone+texte+lien)
 */
function icone1_association($texte, $lien, $image) {
	$chemin = _DIR_PLUGIN_ASSOCIATION_ICONES.$image; // icone Associaspip
	if ( !file_exists($chemin) )
		$chemin = find_in_path($image); // icone alternative
	return icone_horizontale(association_langue($texte), $lien, $chemin, 'rien.gif', FALSE); // http://doc.spip.org/@icone_horizontale
}

/**
 * Finition propre des pages privee du plugin
 *
 * @param bool $FIN_CADRE_RELIEF
 *   Indique s'il faut (vrai, par defaut) rajouter ou pas (faux) "fin_cadre_relief"
 * @return void
 * @note
 *   Cette fonction remplace le couplet final :
 *   echo fin_gauche(), fin_page();
 *   http://programmer.spip.org/Contenu-d-un-fichier-exec
 */
function fin_page_association($FIN_CADRE_RELIEF=TRUE) {
	if ($FIN_CADRE_RELIEF)
		echo fin_cadre_relief(true);
	echo $fin, fin_gauche(), fin_page();
}

/**
 * Cadre en relief debutant la colonne centrale/principale essentiellement
 *
 * @param string $icone
 *   Icone associe a la page, souvent celui du module.
 * @param string $titre
 *   Chaine de langue du titre
 * @param bool $DEBUT_DROITE
 *   Indique s'il faut ajouter (vrai, par defaut) ou pas "debut_droite()" avant
 * @return void
 */
function debut_cadre_association($icone, $titre, $DEBUT_DROITE=TRUE) {
	if ($DEBUT_DROITE)
		echo debut_droite('',TRUE);
	$chemin = _DIR_PLUGIN_ASSOCIATION_ICONES.$icone; // icone Associaspip
	if ( !file_exists($chemin) )
		$chemin = find_in_path($icone); // icone alternative
	debut_cadre_relief($chemin, FALSE, '', association_langue($titre) );
}

?>