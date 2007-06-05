<?php

include_spip('base/abstract_sql');

/* API plugin open-publishing
	set_config_rubrique($i) : ajoute une rubrique dans la liste des rubriques op
	get_rubrique_op() : renvoi un tableau des rubriques op
	op_get_version() : renvoi la version actuelle du plugin
	op_get_agenda() : renvoi le flag agenda
	op_get_rubrique_agenda() : renvoi le num rubrique de l'agenda
	op_get_document() : renvoi le flag document
	op_get_titre_minus() : renvoi le flag titre_minus
	op_get_antispam() : renvoi le flag anti_spam
	op_get_renvoi_normal() : recupere le texte
	op_get_renvoi_abandon() : recupere le texte
	op_get_url_retour() : etc
	op_get_url_abandon() :
	op_get_id_auteur();
	op_get_tagmachine(); renvoi le flag tagmachine
	op_get_motclefs(): renvoi le flag motclefs
	op_get_statut(); renvoi le flag statut
	op_set_id_auteur();
	op_set_url_retour() :
	op_set_url_abandon() :
	op_set_renvoi_normal($texte) : maj du texte
	op_set_renvoi_abandon($texte) : maj du texte
	op_set_agenda($i) : maj du flag agenda
	op_set_rubrique_agenda($i) : maj de la rubrique agenda
	op_set_document($i) : maj du flag document
	op_set_titre_minus($i) : maj du flag titre minus
	op_set_antispam($i) : maj du flag anti_spam
	op_set_tagmachine($i) : maj du flag tagmachine
	op_set_motclefs($i) : maj du flag motclefs
	op_set_statut($i) : maj du flag statut
*/

	function set_config_rubrique($ajout_rubrique) {
		// faire vérification pour voir si la rubrique n'existe pas déjà ...
		// faire vérification pour voir si la rubrique existe dans spip_article ... sinon pas glop
		spip_abstract_insert('spip_op_rubriques', "(id_rubrique,op_rubrique)", "(
		" . intval($id_rubrique) .",
		" . $ajout_rubrique . "
		)");
		
		$retour = "ok";
		return $retour;
	}

	function op_sup_rubrique($id) {

		$req = "
		DELETE FROM `spip_op_rubriques` WHERE `op_rubrique` = ".$id." LIMIT 1;
		";
		spip_query($req);
	}

	function op_get_id_auteur() {
     		$row = spip_fetch_array(spip_abstract_select('id_auteur_op', 'spip_op_config', "id_config=1 LIMIT 1"));
 		return $row['id_auteur_op'];
	}

	function op_get_version() {
		$row = spip_fetch_array(spip_abstract_select('version', 'spip_op_config', "id_config=1 LIMIT 1"));
 		return $row['version'];
	}

	function op_get_agenda() {
		$row = spip_fetch_array(spip_abstract_select('agenda', 'spip_op_config', "id_config=1 LIMIT 1"));
 		return $row['agenda'];
	}

	function op_get_document() {
		$row = spip_fetch_array(spip_abstract_select('documents', 'spip_op_config', "id_config=1 LIMIT 1"));
 		return $row['documents'];
	}

	function op_get_titre_minus() {
		$row = spip_fetch_array(spip_abstract_select('titre_minus', 'spip_op_config', "id_config=1 LIMIT 1"));
 		return $row['titre_minus'];
	}

	function op_get_antispam() {
		$row = spip_fetch_array(spip_abstract_select('anti_spam', 'spip_op_config', "id_config=1 LIMIT 1"));
 		return $row['anti_spam'];
	}

	function op_get_tagmachine() {
		$row = spip_fetch_array(spip_abstract_select('tagmachine', 'spip_op_config', "id_config=1 LIMIT 1"));
 		return $row['tagmachine'];
	}

	function op_get_motclefs() {
		$row = spip_fetch_array(spip_abstract_select('motclefs', 'spip_op_config', "id_config=1 LIMIT 1"));
 		return $row['motclefs'];
	}

	function op_get_statut() {
		$row = spip_fetch_array(spip_abstract_select('statut', 'spip_op_config', "id_config=1 LIMIT 1"));
 		return $row['statut'];
	}

	function op_get_renvoi_normal() {
		$row = spip_fetch_array(spip_abstract_select('message_retour', 'spip_op_config', "id_config=1 LIMIT 1"));
 		return $row['message_retour'];
	}

	function op_get_renvoi_abandon() {
     		$row = spip_fetch_array(spip_abstract_select('message_retour_abandon', 'spip_op_config', "id_config=1 LIMIT 1"));
 		return $row['message_retour_abandon'];
	}

	function op_get_url_retour() {
     		$row = spip_fetch_array(spip_abstract_select('lien_retour', 'spip_op_config', "id_config=1 LIMIT 1"));
 		return $row['lien_retour'];
	}

	function op_get_url_abandon() {
     		$row = spip_fetch_array(spip_abstract_select('lien_retour_abandon', 'spip_op_config', "id_config=1 LIMIT 1"));
 		return $row['lien_retour_abandon'];
	}

	function op_get_rubrique_agenda() {
     		$row = spip_fetch_array(spip_abstract_select('rubrique_agenda', 'spip_op_config', "id_config=1 LIMIT 1"));
 		return $row['rubrique_agenda'];
	}

	function get_rubriques_op() {
     		$row = spip_abstract_select('op_rubrique', 'spip_op_rubriques', "");
 		return $row;
	}

	function op_set_agenda($flag_agenda) {
		$retour = spip_query('UPDATE spip_op_config SET agenda = '.spip_abstract_quote($flag_agenda).' WHERE id_config = 1');
		return $retour;
	}

	function op_set_tagmachine($flag_tagmachine) {
		$retour = spip_query('UPDATE spip_op_config SET tagmachine = '.spip_abstract_quote($flag_tagmachine).' WHERE id_config = 1');
		return $retour;
	}

	function op_set_motclefs($flag_motclefs) {
		$retour = spip_query('UPDATE spip_op_config SET motclefs = '.spip_abstract_quote($flag_motclefs).' WHERE id_config = 1');
		return $retour;
	}

	function op_set_statut($flag_statut) {
		$retour = spip_query('UPDATE spip_op_config SET statut = '.spip_abstract_quote($flag_statut).' WHERE id_config = 1');
		return $retour;
	}

	function op_set_id_auteur($id) {
		$retour = spip_query('UPDATE spip_op_config SET id_auteur_op = '.spip_abstract_quote($id).' WHERE id_config = 1');
		if (op_verifier_anonymous($id)) op_deluser_anonymous($id);
		op_user_anonymous($id);
		return $retour;
	}

	function op_set_document($flag_doc) {
		$retour = spip_query('UPDATE spip_op_config SET documents = '.spip_abstract_quote($flag_doc).' WHERE id_config = 1');
		return $retour;
	}

	function op_set_titre_minus($flag) {
		$retour = spip_query('UPDATE spip_op_config SET titre_minus = '.spip_abstract_quote($flag).' WHERE id_config = 1');
		return $retour;
	}

	function op_set_antispam($flag) {
		$retour = spip_query('UPDATE spip_op_config SET anti_spam = '.spip_abstract_quote($flag).' WHERE id_config = 1');
		return $retour;
	}

	function op_set_rubrique_agenda($rub_agenda) {
		$retour = spip_query('UPDATE spip_op_config SET rubrique_agenda = '.spip_abstract_quote($rub_agenda).' WHERE id_config = 1');
		return $retour;
	}

	function op_set_renvoi_normal($texte) {
		$retour = spip_query('UPDATE `spip_op_config` SET `message_retour` = "'.$texte.'" WHERE `id_config` = 1 LIMIT 1');
		return $retour;
	}

	function op_set_renvoi_abandon($texte) {
		$retour = spip_query('UPDATE `spip_op_config` SET `message_retour_abandon` = "'.$texte.'" WHERE `id_config` = 1 LIMIT 1');
		return $retour;
	}

	function op_set_url_retour($texte) {
		$retour = spip_query('UPDATE `spip_op_config` SET `lien_retour` = "'.$texte.'" WHERE `id_config` = 1 LIMIT 1');
		return $retour;
	}

	function op_set_url_abandon($texte) {
		$retour = spip_query('UPDATE `spip_op_config` SET `lien_retour_abandon` = "'.$texte.'" WHERE `id_config` = 1 LIMIT 1');
		return $retour;
	}

	// verification de l'existance de la base de donnee
	function op_verifier_base() {
		if (!op_verifier_auteurs()) return false;
		if (!op_verifier_config()) return false;
		//if (!op_verifier_anonymous()) return false;
		if (!op_verifier_rubriques()) return false;
		return true;
	}

	function op_verifier_anonymous($id) {
		$result = spip_query("SELECT * FROM `spip_auteurs` WHERE `id_auteur` = ".$id." ");

		if (spip_num_rows($result) == 0) return false;
		return true;
	}

	function op_verifier_auteurs() {

		$sql = "SHOW TABLES";
		$result = mysql_query($sql);

		if (!$result) {
   		echo "Erreur DB, impossible de lister les tables\n";
   		echo 'Erreur MySQL : ' . mysql_error();
   		exit;
		}

		while ($row = mysql_fetch_row($result)) {

			if ($row[0]=="spip_op_auteurs") return true;
		}
		
		mysql_free_result($result);
		return false;
	}

	function op_verifier_config() {

		$sql = "SHOW TABLES";
		$result = mysql_query($sql);

		if (!$result) {
   		echo "Erreur DB, impossible de lister les tables\n";
   		echo 'Erreur MySQL : ' . mysql_error();
   		exit;
		}

		while ($row = mysql_fetch_row($result)) {

			if ($row[0]=="spip_op_config") return true;
		}
		
		mysql_free_result($result);
		return false;
	}

	function op_verifier_rubriques() {

		$sql = "SHOW TABLES";
		$result = mysql_query($sql);

		if (!$result) {
   		echo "Erreur DB, impossible de lister les tables\n";
   		echo 'Erreur MySQL : ' . mysql_error();
   		exit;
		}

		while ($row = mysql_fetch_row($result)) {

			if ($row[0]=="spip_op_rubriques") return true;
		}
		
		mysql_free_result($result);
		return false;
	}

	function op_verifier_upgrade() {
		if (op_get_version() != '0.3') return true;
		return false;
	}

	function op_upgrade_base() {
		// on recupere la version courante
		$version_old = op_get_version();
		// cas du passage 0.2.x => 0.3
		if ( ($version_old == '0.2.2') || ($version_old == '0.2')) {
			// on ajoute ce qui faut dans les bases existantes
			$req = "
			ALTER TABLE `spip_op_config` ADD (
			`tagmachine` ENUM('oui','non') DEFAULT 'non' NOT NULL,
			`motclefs` ENUM('oui','non') DEFAULT 'non' NOT NULL,
			`statut` ENUM('publie','prop', 'prepa') DEFAULT 'prop' NOT NULL
			);
			";
			
			spip_query($req);
			spip_query('UPDATE `spip_op_config` SET `version` = "0.3" WHERE `id_config` = 1 LIMIT 1');
		}
		return true;
	}

	function op_installer_base() {
	
	
		include_spip('base/create');
		include_spip('base/abstract_sql');
		creer_base();

		include_spip('inc/meta');
		ecrire_meta('indy_version', '0.3');
		ecrire_metas();

		op_insert_first_config();
	}

	function op_insert_first_config() {
		include_spip('base/abstract_sql');

		spip_abstract_insert('spip_op_config', "(id_config, version)", "(
		" . intval($id_config) .",
		'0.3'
		)");
	}
	// Création de l'utilisateur anonymous (id = 999)
	function op_user_anonymous($id) {
	
		if (!op_verifier_anonymous($id)) {
			$req = "
			INSERT INTO `spip_auteurs` ( `id_auteur` , `nom` , `bio` , `email` , `nom_site` , `url_site` , `login` , `pass` , `low_sec` , `statut` , `maj` , `pgp` , `htpass` , `en_ligne` , `imessage` , `messagerie` , `alea_actuel` , `alea_futur` , `prefs` , `cookie_oubli` , `source` , `lang` , `idx` , `url_propre` , `extra` )
			VALUES (".$id." , 'anonymous', '', '', '', '', '', '', '', '', NOW( ) , '', '', '0000-00-00 00:00:00', '', '', '', '', '', '', 'spip', '', '', '', '');
			";
			spip_query($req);
		}
	}

	// Supression de l'utilisateur anonymous
	function op_deluser_anonymous($id) {

		$req = "
		DELETE FROM `spip_auteurs` WHERE `id_auteur` = ".$id." LIMIT 1;
		";
		spip_query($req);
	}

	// Script  de suppression de la table spip_op_auteurs et spip_op_config. Utilis�sur exec=indy_effacer
	function op_desinstaller_base() {
		$req = "DROP table `spip_op_auteurs`";
		spip_query($req);
		$req = "DROP table `spip_op_config`";
		spip_query($req);
		$req = "DROP table `spip_op_rubriques`";
		spip_query($req);
	}
 
?>
