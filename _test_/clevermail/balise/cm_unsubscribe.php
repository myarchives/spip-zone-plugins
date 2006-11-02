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

function balise_CM_UNSUBSCRIBE($p) {
	return calculer_balise_dynamique($p, 'CM_UNSUBSCRIBE', array());
}

function balise_CM_UNSUBSCRIBE_dyn() {
	if (isset($_GET['id']) && $_GET['id'] != '') {
		$result = spip_query("SELECT * FROM cm_lists_subscribers WHERE lsr_id = '".$_GET['id']."'");
	    if (spip_num_rows($result)==1) {
	    	$data = spip_fetch_array($result);

	        // Desinscription a cette liste demandee
	        $actionId = md5('unsubscribe#'.$data['lst_id'].'#'.$data['sub_id'].'#'.time());
	        $result = spip_fetch_array(spip_query("SELECT COUNT(*) AS nb FROM cm_pending WHERE lst_id = ".$data['lst_id']." AND sub_id = ".$data['sub_id']));
	        if ($result['nb'] == 0) {
	            spip_query("INSERT INTO cm_pending (lst_id, sub_id, pnd_action, pnd_action_date, pnd_action_id) VALUES (".$data['lst_id'].", ".$data['sub_id'].", 'unsubscribe', ".time().", '".$actionId."')");
	        }

	        // Composition du message de demande de confirmation
	        $recipient = spip_fetch_array(spip_query("SELECT * FROM cm_subscribers WHERE sub_id=".$data['sub_id']));
		    $list = spip_fetch_array(spip_query("SELECT * FROM cm_lists WHERE lst_id=".$data['lst_id']));
		    $subject = ((int)$list['lst_subject_tag'] == 1 ? '['.$list['lst_name'].'] ' : '').$list['lst_unsubscribe_subject'];
		    $template = array();
		    $template['@@ADDRESS@@'] = $recipient['sub_email'];
		    $template['@@FORMAT@@']  = ($data['lsr_mode'] == 1 ? 'HTML' : 'texte');
		    $template['@@URL@@']     = $GLOBALS['meta']['adresse_site'].'/spip.php?page=cm_do&id='.$actionId;
		    $template['@@UNSUBSCRIBE@@'] = $GLOBALS['meta']['adresse_site'].'/spip.php?page=cm_rm&id='.$_GET['id'];
		    $message = $list['lst_unsubscribe_text'];
	        while (list($from, $to) = each($template)) {
	            $message = str_replace($from, $to, $message);
	        }

	        // Envoi du message
	        $mail = new PHPMailer();
			$mail->Subject = $subject;
			$cm_mail_from = spip_fetch_array(spip_query("SELECT set_value FROM cm_settings WHERE set_name='CM_MAIL_FROM'"));
			$mail->From = $cm_mail_from['set_value'];
			$mail->FromName = $GLOBALS['meta']['nom_site'];
			$mail->AddAddress($recipient['sub_email']);
			$mail->IsHTML(false);
			$mail->Body = $message;
			$mail->Send();
			$return = '<p>'._T('cm:desinscription_confirmation_debut').' '.$list['lst_name'].' '._T('cm:desinscription_confirmation_fin').'</p>';
		} else {
		    $return = '<p>'._T('cm:aucune_inscription').'</p>';
	    }
	}
	return $return;
}
?>