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

function exec_clevermail_queue_process() {

	if (isset($_GET['verbose'])) {
		$verbose = $_GET['verbose'];
	} else {
		$verbose = 'yes';
	}

	$cm_send_number = spip_fetch_array(spip_query("SELECT set_value FROM cm_settings WHERE set_name='CM_SEND_NUMBER'"));
	$queued = spip_query("SELECT * FROM cm_posts_queued ORDER BY psq_date LIMIT 0,".$cm_send_number['set_value']);
	while ($message = spip_fetch_array($queued)) {
		$result = spip_fetch_array(spip_query("SELECT COUNT(*) AS nb FROM cm_posts_done WHERE pst_id = ".$message['pst_id']." AND sub_id = ".$message['sub_id']));
		if ($result['nb'] == 0) {

			$post = spip_fetch_array(spip_query("SELECT * FROM cm_posts WHERE pst_id = ".$message['pst_id']));
			$list = spip_fetch_array(spip_query("SELECT * FROM cm_lists WHERE lst_id = ".$post['lst_id']));
			$subscriber = spip_fetch_array(spip_query("SELECT * FROM cm_subscribers WHERE sub_id = ".$message['sub_id']));
			$subscription = spip_fetch_array(spip_query("SELECT lsr_mode, lsr_id FROM cm_lists_subscribers WHERE lst_id = ".$post['lst_id']." AND sub_id = ".$message['sub_id']));

			$mode = ($subscription['lsr_mode'] == 1 ? 'html' : 'text');

			// recipient
			$to = $subscriber['sub_email'];

			// subject
			$subject = trim(($list['lst_subject_tag'] == 1 ? '['.$list['lst_name'].'] ' : '').$post['pst_subject']);

			$cm_mail_from = spip_fetch_array(spip_query("SELECT set_value FROM cm_settings WHERE set_name='CM_MAIL_FROM'"));

			$mail = new PHPMailer();
			$mail->Subject = $subject;
			$mail->From = $cm_mail_from['set_value'];
			$mail->FromName = $GLOBALS['meta']['nom_site'];
			$mail->AddAddress($to);
			$mail->AddReplyTo($cm_mail_from['set_value']);

			// message content
			$text = $post['pst_text'];
			$text = str_replace("(\r\n|\n|\n)", CM_NEWLINE, $text);
			$text = wordwrap($text, 70, CM_NEWLINE);

			$html = $post['pst_html'];
			$html = str_replace("(\r\n|\n|\n)", CM_NEWLINE, $html);

			$template = array();
			$template['@@NOM_LETTRE@@'] = $list['lst_name'];
			$template['@@DESCRIPTION@@'] = $list['lst_comment'];
			$template['@@FORMAT_INSCRIPTION@@'] = $mode;
			$template['@@EMAIL@@'] = $to;
			$template['@@URL_DESINSCRIPTION@@'] = $GLOBALS['meta']['adresse_site'].'/rm.php?id='.$subscription['lsr_id'];
			reset($template);
			while (list($templateFrom, $templateTo) = each($template)) {
				$text = str_replace($templateFrom, $templateTo, $text);
				$html = str_replace($templateFrom, $templateTo, $html);
			}

			if ($mode == 'text') {
				$mail->IsHTML(false);
				$mail->Body    = $text;
			} else {
				$mail->IsHTML(true);
				$mail->Body    = $html;
				$mail->AltBody = $text;
			}

			if (spip_query("DELETE FROM cm_posts_queued WHERE pst_id = ".$message['pst_id']." AND sub_id = ".$message['sub_id'])) {
				// message removed from queue, we can try to send it
				if ($mail->Send()) {
					// message sent
					spip_query("INSERT INTO cm_posts_done (pst_id, sub_id) VALUES (".$message['pst_id'].", ".$message['sub_id'].")");
					if ($verbose == 'yes') {
						echo "\n".'Message from list "'.$list['lst_name'].'" sent to '.$to.' in '.$mode.' format<br />';
					}
				} else {
					echo "Message could not be sent.<br />";
  					echo "Mailer Error: " . $mail->ErrorInfo;
				}
			}

		} else {
			if ($verbose == 'yes') {
				echo "\n".'Message from list "'.$list['lst_name'].'" already sent to '.$to;
			}
		}
	}
}
?>