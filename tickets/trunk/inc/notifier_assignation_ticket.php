<?php
/**
 * Plugin Tickets
 * Licence GPL (c) 2008-2013
 * 
 * Notification des assignations
 * 
 * @package SPIP\Tickets\Notifications
 */
 
if (!defined("_ECRIRE_INC_VERSION")) return;

function inc_notifier_assignation_ticket_dist($id_ticket,$options){

	$datas = sql_fetsel("*","spip_tickets","id_ticket=".intval($id_ticket));

	if($datas['id_ticket'] == $id_ticket){
		$nom_auteur = sql_getfetsel("nom","spip_auteurs","id_auteur=".intval($datas['id_assigne']));
	
		include_spip('tickets_fonctions');
		$envoyer_mail = charger_fonction('envoyer_mail','inc');
	
		$nom_site = $GLOBALS["meta"]["nom_site"];
		$url_site = $GLOBALS["meta"]["adresse_site"];
		
		if(lire_config('tickets/general/notification_publique') == 'on')
			$url_ticket = url_absolue(generer_url_entite($id_ticket,'ticket'));
		else
			$url_ticket = url_absolue(generer_url_ecrire('ticket',"id_ticket=$id_ticket"));
		
	
		$titre = trim($datas['titre']);
		$titre_message = "[Ticket - $nom_site] $titre - "._T('tickets:assignation_mail_titre');
		$titre_message = nettoyer_titre_email($titre_message);
	
		$message = "$titre_message\n
		------------------------------------------\n"
		._T('tickets:mail_texte_message_auto')."\n\n";
	
		if($nom_auteur)
			$message .= _T('tickets:assignation_attribuee_a',array('nom'=>$nom_auteur))."\n\n";
		else
			$message .= _T('tickets:assignation_supprimee')."\n\n";
		
	
		$message .= $url_ticket;
	
		// Determiner la liste des auteurs a notifier
		include_spip('tickets_autorisations');
	
		$from = array('spip_auteurs AS t1');
		$autorises = definir_autorisations_tickets('notifier');
		if ($autorises['statut'])
			$where = array(sql_in('t1.statut', $autorises['statut']), 't1.email LIKE '.sql_quote('%@%'));
		else
			$where = array(sql_in('t1.id_auteur', $autorises['auteur']), 't1.email LIKE '.sql_quote('%@%'));
		$query_auteurs = sql_select('email', $from, $where);
		
		//Envoyer systématiquement un email à l'auteur du ticket et à la personne assignée, ainsi qu'aux personnes mentionnés dans via [->autxxx] ou [->auteurXXX] dans le corps du ticket
		$match_auteurs_mentionnes=array();
        preg_match_all("#\[(.*)->(aut|auteur)(\d*)\]#U",$datas['texte'],$match_auteurs_mentionnes);
        $auteurs_mentionnes = $match_auteurs_mentionnes[3];
		
		$destinataires_forces = sql_allfetsel(
								'email',
								'spip_auteurs',
								sql_in('id_auteur',
										array_merge((array)$auteurs_mentionnes,(array)$datas["id_auteur"],(array)$datas["id_assigne"])));
		$emails_deja_faits = array();
		foreach ($destinataires_forces as $dest){
			$emails_deja_faits[] = $dest["email"];
			$envoyer_mail($dest["email"], $titre_message, $message);
			}
		
		// Envoi des mails aux autres destinataires
		while ($row_auteur = sql_fetch($query_auteurs)) {
			if (!in_array($recipient = $row_auteur["email"],$emails_deja_faits)){
				$envoyer_mail($recipient, $titre_message, $message);
			}
		}
	}
}
?>
