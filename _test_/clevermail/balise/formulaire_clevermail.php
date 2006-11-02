<?php
	/**
	 *
	 * CleverMail : plugin de gestion de lettres d'information bas� sur CleverMail
	 * Author : Thomas Beaumanoir
	 * Clever Age <http://www.clever-age.com>
	 * Copyright (c) 2006
	 *
	 **/

include_spip('phpmailer/class.phpmailer');

function balise_FORMULAIRE_CLEVERMAIL ($p) {
	return calculer_balise_dynamique($p, 'FORMULAIRE_CLEVERMAIL', array('id_liste'));
}

// args[0] indique une liste, mais ne sert pas encore
// args[1] indique un eventuel squelette alternatif
// #FORMULAIRE_CLEVERMAIL{lettreX} permet d'afficher le formulaire d'abonnement a la lettre numero X
function balise_FORMULAIRE_CLEVERMAIL_stat($args, $filtres) {
	if(!$args[1]) $args[1]='formulaire_clevermail';
	if(ereg("^lettre([0-9]+)$", $args[1], $regs)) {
		$args[0] = intval($regs[1]);
		$args[1] = 'formulaire_clevermail_simple';
	}
	return array($args[0], $args[1]);
}

function balise_FORMULAIRE_CLEVERMAIL_dyn($id_liste, $formulaire) {
	$formulaire = "formulaires/".$formulaire ;

	if($_POST['cm_sub_return']) {
		$listId = (int)$_POST['cm_sub_list'];
		$address = $_POST['cm_sub_address'];
		$mode = (int)$_POST['cm_sub_mode'];
		$return = $_POST['cm_sub_return'];
		$erreur = '';
		$cm_sub = 'null';
		if (ereg("^[^@ ]+@[^@ ]+\.[^@. ]+$", $address)) {
			$result = spip_fetch_array(spip_query("SELECT sub_id FROM cm_subscribers WHERE sub_email='".$address."'"));
			$recId = $result['sub_id'];
			if (!$recId) {
				// Nouvelle adresse e-mail
				spip_query("INSERT INTO cm_subscribers (sub_id, sub_email, sub_profile) VALUES ('', '".$address."', '')");
		        $recId = spip_insert_id();
				spip_query("UPDATE cm_subscribers SET sub_profile = '".md5($recId.'#'.$address.'#'.time())."' WHERE sub_id='".$recId."'");
			}
			$result = spip_fetch_array(spip_query("SELECT COUNT(*) AS nb FROM cm_lists_subscribers WHERE lst_id = ".$listId." AND sub_id = ".$recId));
			if ($result['nb'] == 1) {
	            // Inscription � cette liste d�j� pr�sente
	            // On met � jour pour �ventuellement changer le mode
	            spip_query("UPDATE cm_lists_subscribers SET lsr_mode=".$mode." WHERE lst_id = ".$listId." AND sub_id = ".$recId);
	            $cm_sub = _T('cm:deja_inscrit');
        	} else {
				$list = spip_fetch_array(spip_query("SELECT * FROM cm_lists WHERE lst_id = ".$listId));
				switch($list['lst_moderation']) {
					case 'open':
						$actionId = md5('subscribe#'.$listId.'#'.$recId.'#'.time());
						spip_query("INSERT INTO cm_lists_subscribers (lst_id, sub_id, lsr_mode, lsr_id) VALUES (".$listId.", ".$recId.", ".$mode.", '$actionId')");
	                    $cm_sub = _T('cm:inscription_validee');
					break;

					case 'email':
			            $actionId = md5('subscribe#'.$listId.'#'.$recId.'#'.time());
			            $result = spip_fetch_array(spip_query("SELECT COUNT(*) AS nb FROM cm_pending WHERE lst_id = ".$listId." AND sub_id = ".$recId));
			            if ($result['nb'] == 0) {
			                spip_query("INSERT INTO cm_pending (lst_id, sub_id, pnd_action, pnd_mode, pnd_action_date, pnd_action_id) VALUES (".$listId.", ".$recId.", 'subscribe', ".$mode.", ".time().", '".$actionId."')");
			            }

			            // Composition du message de demande de confirmation
				        $list = spip_fetch_array(spip_query("SELECT * FROM cm_lists WHERE lst_id=".$listId));
				        $subject = ((int)$list['lst_subject_tag'] == 1 ? '['.$list['lst_name'].'] ' : '').$list['lst_subscribe_subject'];
				        $template = array();
				        $template['@@ADDRESS@@'] = $address;
				        $template['@@FORMAT@@']  = ($mode == 1 ? 'HTML' : 'texte');
				        $template['@@URL@@']     = $GLOBALS['meta']['adresse_site'].'/spip.php?page=cm_do&id='.$actionId;
				        $template['@@UNSUBSCRIBE@@'] = $GLOBALS['meta']['adresse_site'].'/spip.php?page=cm_rm&id='.$actionId;
				        $message = $list['lst_subscribe_text'];
			            while (list($from, $to) = each($template)) {
			                $message = str_replace($from, $to, $message);
			            }

			            $mail = new PHPMailer();
						$mail->Subject = $subject;
						$cm_mail_from = spip_fetch_array(spip_query("SELECT set_value FROM cm_settings WHERE set_name='CM_MAIL_FROM'"));
						$mail->From = $cm_mail_from['set_value'];
						$mail->FromName = $GLOBALS['meta']['nom_site'];
						$mail->AddAddress($address);
						$mail->IsHTML(false);
						$mail->Body = $message;

					     // Envoi du message
					    if($mail->Send()) {
					    	$cm_sub = _T('cm:ok');
					    } else {
					    	$cm_sub = _T('cm:send_error');
					    }
					break;

					case 'mod':
			            $actionId = md5('subscribe#'.$listId.'#'.$recId.'#'.time());
			            $result = spip_fetch_array(spip_query("SELECT COUNT(*) AS nb FROM cm_pending WHERE lst_id = ".$listId." AND sub_id = ".$recId));
			            if ($result['nb'] == 0) {
			                spip_query("INSERT INTO cm_pending (lst_id, sub_id, pnd_action, pnd_mode, pnd_action_date, pnd_action_id) VALUES (".$listId.", ".$recId.", 'subscribe', ".$mode.", ".time().", '".$actionId."')");
			            }

			            // Composition du message de demande de confirmation au moderateur
				        $list = spip_fetch_array(spip_query("SELECT * FROM cm_lists WHERE lst_id=".$listId));
				        $subject = ((int)$list['lst_subject_tag'] == 1 ? '['.$list['lst_name'].'] ' : '').$list['lst_subscribe_subject'];
				        $template = array();
				        $template['@@ADDRESS@@'] = $address;
				        $template['@@FORMAT@@']  = ($mode == 1 ? 'HTML' : 'texte');
				        $template['@@URL@@']     = $GLOBALS['meta']['adresse_site'].'/spip.php?page=cm_do&id='.$actionId;
				        $template['@@UNSUBSCRIBE@@'] = $GLOBALS['meta']['adresse_site'].'/spip.php?page=cm_rm&id='.$actionId;
				        $message = $list['lst_subscribe_text'];
			            while (list($from, $to) = each($template)) {
			                $message = str_replace($from, $to, $message);
			            }

			            $mail = new PHPMailer();
						$mail->Subject = $subject;
						$mail->From = $address;
						$cm_mail_from = spip_fetch_array(spip_query("SELECT set_value FROM cm_settings WHERE set_name='CM_MAIL_FROM'"));
						$mail->AddAddress($cm_mail_from);
						$mail->IsHTML(false);
						$mail->Body = $message;

					     // Envoi du message
					    if($mail->Send()) {
					    	$cm_sub = _T('cm:mok');
					    } else {
					    	$cm_sub = _T('cm:send_error');
					    }
					break;

					case 'closed':
						$cm_sub = _T('cm:nok');
					break;
				}
        	}
		} else {
			// Email non valide
			$cm_sub = _T('cm:email_non_valide');
		}
	}

	return array($formulaire, $GLOBALS['delais'], array('id_liste' => $id_liste, 'retour' => $cm_sub));
}
?>