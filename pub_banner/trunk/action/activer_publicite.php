<?php
/**
 * Change le statut des publicités
 *
 * Il s'agit d'une 'action SPIP' (<i>url_action()</i>) qui doit recevoir en argument une
 * chaine construite sur le modèle : 'action-ID' avec 'action' :
 * <ul>
 * <li>'desactiver' : désactivation : passe en '1inactif' si était '2actif'</li>
 * <li>'activer' : activation : passe en '2actif' si était '1inactif'</li>
 * <li>'rompu' : introuvable : passe en '4rompu' si était '1inactif' ou '2actif'</li>
 * <li>'out_trash' : sortie de poubelle : passe en '1inactif' si était '5poubelle'</li>
 * <li>'trash' : poubelle : passe en '5poubelle' si était '1inactif' ou '2actif'</li>
 * </ul>
 *
 * @name 		Activer pub
 * @author 		Piero Wbmstr <@link piero.wbmstr@gmail.com>
 * @license		http://creativecommons.org/licenses/by-nc-sa/3.0/ Creative Commons BY-NC-SA
 * @version 	1.0 (06/2009)
 * @package		Pub Banner
 * @subpackage	Actions
 */
if (!defined("_ECRIRE_INC_VERSION")) return;

function action_activer_publicite(){
	include_spip('inc/autoriser');
	include_spip('inc/pubban_process');
	include_spip('inc/publicite');
	$securiser_action = charger_fonction('securiser_action', 'inc');
	$arg = $securiser_action();
	list($activer, $id_publicite) = explode('-', $arg);

	if (intval($id_publicite)){
		$statut = pubban_recuperer_publicite($id_publicite, "statut");
		$editer_pub = charger_fonction('editer_publicite', 'inc');
		switch ($activer) {
			case 'activer' :
				if($statut == '1inactif') 
					$ok = $editer_pub($id_publicite, array("statut" => "2actif"));
				break;
			case 'desactiver' :
				if($statut == '2actif') 
					$ok = $editer_pub($id_publicite, array("statut" => "1inactif"));
				break;
			case 'rompu' :
				if(in_array($statut, array('1inactif', '2actif')))
					$ok = $editer_pub($id_publicite, array("statut" => "4rompu"));
				break;
			case 'trash' :
				if(in_array($statut, array('1inactif', '2actif')))
					$ok = $editer_pub($id_publicite, array("statut" => "5poubelle"));
				break;
			case 'out_trash' :
				if($statut == '5poubelle') 
					$ok = $editer_pub($id_publicite, array("statut" => "1inactif"));
				break;
		}
		if ($redirect = _request('redirect') ) {
			$redirect = str_replace('&amp;', '&', $redirect);
			include_spip('inc/headers');
			redirige_par_entete( $redirect );
		}
	}

	return;
}
?>