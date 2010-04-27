<?php
	/**
	* Plugin Association
	*
	* Copyright (c) 2007
	* Bernard Blazin & Fran�ois de Montlivault
	* http://www.plugandspip.com 
	* Ce programme est un logiciel libre distribue sous licence GNU/GPL.
	* Pour plus de details voir le fichier COPYING.txt.
	*  
	**/
if (!defined("_ECRIRE_INC_VERSION")) return;

function action_ajouter_dons() {
		
	$securiser_action = charger_fonction('securiser_action', 'inc');
	$securiser_action();

	$journal= _request('journal');
	$date_don = _request('date_don');
	$bienfaiteur = _request('bienfaiteur');
	$id_adherent = _request('id_adherent');
	$argent = _request('argent');
	$colis = _request('colis');
	$valeur = _request('valeur');
	$contrepartie = _request('contrepartie');
	$commentaire = _request('commentaire');

	include_spip('base/association');		
	$id_don = sql_insertq('spip_asso_dons', array(
					    'date_don' => $date_don,
					    'bienfaiteur' => $bienfaiteur,
					    'id_adherent' => $id_adherent,
					    'argent' => $argent,
					    'colis' => $colis,
					    'valeur' => $valeur,
					    'contrepartie' => $contrepartie,
					    'commentaire' => $commentaire));

	sql_insertq('spip_asso_comptes', array(
		    'date' => $date_don,
		    'imputation' => lire_config('association/pc_dons'),
		    'recette' => $argent,
		    'journal' => $journal,
		    'justification' => 'don n&deg; '.$id_don.' - '.$bienfaiteur));
}
?>
