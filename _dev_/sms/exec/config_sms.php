<?php
/*
 * Envoi de sms
 *
 * Auteur : bertrand@toggg.com
 * � 2006 - Distribue sous licence LGPL
 *
 */

function exec_config_sms_dist()
{
	$champs = array('prestataire', 'user', 'password', 'api_id',
					'text', 'from', 'to', 'id');
	foreach ($champs as $champ) {
	    $contexte[$champ] = _request($champ);
    }
	$result = $message = null;
	if (_request('envoi')) {
		$securiser_action = charger_fonction('securiser_action', 'inc');
		$securiser_action();
		$resultat = transmet_prestataire($contexte);
		$message = $resultat ? _L('erreur') . ':<br />'. $resultat
							: _L('envoi_correct_pour') . ' ' . $contexte['to'];
	}
	include_spip("inc/texte");
	config_sms_debut_page($message);

	echo config_sms_fond($contexte);
	
	config_sms_fin_page();
			
}

/*
 V�rifier les parametre et faire la requete d'envoi du sms
	$contexte est un tableau (nom=>valeur) qui sera enrichi
	Retourne '' si tou s'est bien pass� , message d'erreur sinon
*/
function transmet_prestataire(&$contexte)
{
	include_spip('inc/sms');
	$contexte['resultat'] = '';
//	$contexte['resultat'] = print_r($contexte, true);

    $sender =& Net_SMS::factory($contexte['prestataire'],
                         array(	'user' => $contexte['user'],
								'password' => $contexte['password'],
								'api_id' => $contexte['api_id'] ));
    if (c_pear::isError($sender))   {
		$contexte['resultat'] = _L('factory SMS failed') . '<br />' .
			print_r($sender, true);
		return $contexte['resultat'];
    }
	//send message and return result
	$msg = array('to'=>$contexte['to'],
	             'from'=>$contexte['from'],
				 'id'=>$contexte['id'],
				 'text'=>$contexte['text']);
	$e = $sender->send($msg);
    if (c_pear::isError($e))   {
		$contexte['resultat'] = _L('transmission_loupee') .
		   '<br />' . print_r($msg, true) .
		   '<br />' . print_r($e, true);
    }
	return $contexte['resultat'];
}

/*
 Fabriquer les balises des champs d'apres un modele fonds/config_sms.html
	$contexte est un tableau (nom=>valeur) qui sera enrichi puis passe � recuperer_fond
*/
function config_sms_fond($contexte = array())
{
    $contexte['lang'] = $GLOBALS['spip_lang'];
    $contexte['arg'] = 'config_sms-0.1.0';
    $contexte['hash'] =  calculer_action_auteur('-' . $contexte['arg']);

    include_spip('public/assembler');
    return recuperer_fond('config_clickatell', $contexte);
}

function config_sms_debut_page($message = '')
{
	include_spip('inc/presentation');

	$commencer_page = charger_fonction('commencer_page', 'inc');
	echo $commencer_page(_L('Envoi de SMS'), 'sms', 'config_sms');
	
	debut_gauche();
	
	debut_boite_info();
	echo propre(_L('Vous pouvez envoyer des SMS depuis cette page'));
	fin_boite_info();
	
	if ($message) {
		debut_boite_info();
		echo propre($message);
		fin_boite_info();
	}
	
	debut_droite();
	
	gros_titre(_L("Envoi de SMS"));
	
	
	debut_cadre_trait_couleur('','','',_L("Parametres d'envoi"));

}

function config_sms_fin_page()
{
	fin_cadre_trait_couleur();
	
	echo fin_page();
}
?>
