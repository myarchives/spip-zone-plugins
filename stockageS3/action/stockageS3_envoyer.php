<?php
/**
 * Plugin Stockage S3
 * Licence GPL (c) 2010 Natxo, Cedric
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_stockageS3_envoyer_dist($arg=null) {

	if (is_null($arg)){
		$securiser_action = charger_fonction('securiser_action','inc');
		$arg = $securiser_action();
	}

	if ($id_document = intval($arg)
		AND autoriser('stocker','document',$id_document)
		AND $t = sql_fetsel('*','spip_documents','id_document='.intval($id_document))
		AND $t['distant'] == 'non'
		){

		include_spip('inc/s3');


		include_spip('inc/documents');
		include_spip('inc/distant');

		// Size image, for future thumbnails. Now set "original"
		$size_image= "original";

		// Ou doit-on deposer notre fichier ?
		$path_info = pathinfo(get_spip_doc($t['fichier']));

		$src_site =  $GLOBALS['meta']['adresse_site']. "/" .substr(get_spip_doc($t['fichier']),strlen(_DIR_RACINE));
		$src =  get_spip_doc($t['fichier']);
		$dest =  $PATH . $size_image. "-id" .$id_document. "-" .time(). "." .$path_info['extension'];

		if ($s3_url = stockage_sendfile(get_spip_doc($t['fichier']), $dest)) {
			spip_log("Stockage document $id_document ".$t['fichier']." => ".$s3_url, 'stockage');
			$url_distante = $s3_url;
			include_spip('action/editer_document');

			rename (get_spip_doc($t['fichier']), _DIR_RACINE.fichier_copie_locale($url_distante));
			document_set($id_document, array(
				'fichier' => $url_distante,
				'distant' => 'oui'
			));
		} else
			spip_log("Erreur upload stockage ($id_document)", 'stockage');
	}
}



?>