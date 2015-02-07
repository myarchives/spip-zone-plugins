<?php
/**
 * Utilisations de pipelines par Réservation Événement Cloture
 *
 * @plugin     Réservation Événement Cloture
 * @copyright  2014
 * @author     Rainer Müller
 * @licence    GNU/GPL
 * @package    SPIP\Reservation_evenement_cloture\Genie
 */

if (!defined('_ECRIRE_INC_VERSION')) return;
	
//Cloturer un évènement
function genie_reservation_evenement_cloture_dist ($t) {
	$date=date('Y-m-d G:i:s');
	
	include_spip('action/editer_objet');
 
 	//Sélection des détails de réservation concernant d'´événements passé et qui ont action_cloture activé
	$sql=sql_select(
		'id_reservations_detail,spip_reservations_details.id_evenement,date_fin',
		'spip_reservations_details,spip_evenements',
		'spip_reservations_details.statut="accepte" AND 
			spip_reservations_details.id_evenement=spip_evenements.id_evenement AND
			spip_evenements.date_fin <="'.$date.'" AND
			spip_evenements.action_cloture =1' 
		);
	
	$id_evenement=array();	
	while($data=sql_fetch($sql)){
		if(!$date_fin=sql_getfetsel('date_fin','spip_evenements','id_evenement_source='.$data['id_evenement'],'','"date fin" DESC','1'))
		$date_fin=$data['date_fin'];
		//Déclencher le changement de statut et les actions qui en dépendent
		if($date_fin<=$date){
			set_request('envoi_separe_actif','oui'); //Nécessaire pour permettre l'envoi du mail
			objet_instituer('reservations_detail',$data['id_reservations_detail'],array('statut'=>'cloture'));
			$id_evenement[]	= $data['id_evenement'];	
	
		}
	};
	
	if (count($id_evenement)>0) sql_updateq('spip_evenements',array('action_cloture'=>3),'id_evenement IN ('.implode(',',$id_evenement).')');
	
	return 1;
}