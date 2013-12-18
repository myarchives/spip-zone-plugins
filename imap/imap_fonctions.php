<?php

/*
 * Ouvrir un flux IMAP vers la boîte aux lettres définie dans la configuration
 * 
 * @return flux_IMAP Flux imap vers la boîte aux lettres ouverte
 */
function imap_open_from_configuration() {
	include_spip('inc/config');

	$email = lire_config('imap/email');
	$email_pwd = lire_config('imap/email_pwd');
	$hote_imap = lire_config('imap/hote_imap');
	$hote_port = lire_config('imap/hote_port');
	$hote_options = lire_config('imap/hote_options');
	$hote_inbox = lire_config('imap/inbox'); 

	$connexion = '{'.$hote_imap.':'.$hote_port.$hote_options.'}'.$hote_inbox;
	return @imap_open($connexion, $email, $email_pwd);
}

/*
 * Sauvegarder les pièces jointes sur le disque
 * 
 * @param flux_IMAP $mbox Un flux IMAP ouvert par imap_open()
 * @param int $mid L'indice du mail à traiter
 * @param string $path Le répertoire où sauver les pièces jointes
 * @param array $allowed_types Types de pièces jointes autorisés. Par défaut tous les types sont autorisés (liste vide). Voir http://www.php.net/manual/fr/function.imap-fetchstructure.php pour la liste des types
 * 
 * @return array Liste des noms de fichiers sauvegardés dans $path
 */
function imap_save_attachments($mbox, $mid, $path, $allowed_types=array()) {
	if(!$mbox)
		return false;

	$pieces_jointes = array();
	$structure = imap_fetchstructure($mbox, $mid);
	if(isset($structure->parts)) {
		foreach($structure->parts as $key => $value) {
			$enc = $structure->parts[$key]->encoding;
			if((isset($structure->parts[$key]->ifdparameters)
					AND $structure->parts[$key]->ifdparameters)
					AND ((isset($structure->parts[$key]->subtype) AND in_array($structure->parts[$key]->subtype, $allowed_types)) OR count($allowed_types) == 0)) {
				$name = $structure->parts[$key]->dparameters[0]->value;
				imap_save_attachment($mbox, $mid, $key+1, $enc, $path, $name);
				$pieces_jointes[] = $name;
			}
			// Support for embedded attachments starts here
			if(isset($structure->parts[$key]->parts)
					AND ((isset($structure->parts[$key]->subtype) AND in_array($structure->parts[$key]->subtype, $allowed_types)) OR count($allowed_types) == 0)) {
				foreach($structure->parts[$key]->parts as $keyb => $valueb) {
					$enc=$structure->parts[$key]->parts[$keyb]->encoding;
					if($structure->parts[$key]->parts[$keyb]->ifdparameters) {
						$name=$structure->parts[$key]->parts[$keyb]->dparameters[0]->value;
						$partnro = ($key+1).".".($keyb+1);
						imap_save_attachment($mbox, $mid, $partnro, $enc, $path, $name);
						$pieces_jointes[] = $name;
					}
				}
			}
		}
	}
	return $pieces_jointes;
}

/*
 * Fonction interne - écrit une pièce jointe sur le disque
 * 
 * @param flux_IMAP $mbox Un flux IMAP ouvert par imap_open()
 * @param int $mid L'indice du mail à traiter
 * @param int $attid L'indice de la pièce jointe dans le mail
 * @param int $enc L'encodage de la pièce jointe (voir http://www.php.net/manual/fr/function.imap-fetchstructure.php pour la liste des encodages)
 * @param string $path Le répertoire où sauvegarder la pièce jointe
 * @param string $name Le nom du fichier sous lequel sera sauvegardée la pièce jointe
 *
 * @return void
 */
function imap_save_attachment($mbox, $mid, $attid, $enc, $path, $name) {
	$message = imap_fetchbody($mbox,$mid,$attid);
	if ($enc == 0)
		$message = imap_8bit($message);
	if ($enc == 1)
		$message = imap_8bit ($message);
	if ($enc == 2)
		$message = imap_binary ($message);
	if ($enc == 3)
		$message = imap_base64 ($message); 
	if ($enc == 4)
		$message = quoted_printable_decode($message);
	if ($enc == 5)
		$message = $message;
	$fp=fopen($path.$name,"w");
	fwrite($fp,$message);
	fclose($fp);
}
