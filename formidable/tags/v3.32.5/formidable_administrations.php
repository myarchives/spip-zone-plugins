<?php

/**
 * Fichier gérant l'installation et désinstallation du plugin
 *
 * @package SPIP\Formidable\Installation
**/

// Sécurité
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Installation/maj des tables de formidable...
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @param string $version_cible
 *     Version du schéma de données dans ce plugin (déclaré dans paquet.xml)
 * @return void
 */
function formidable_upgrade($nom_meta_base_version, $version_cible) {
	// Création des tables
	include_spip('base/create');
	include_spip('base/abstract_sql');

	$maj = array();
	$maj['create'] = array(
		array('maj_tables',array(
			'spip_formulaires',
			'spip_formulaires_reponses',
			'spip_formulaires_reponses_champs',
			'spip_formulaires_liens')),
		array('formidable_importer_forms'),
		array('formidable_importer_forms_donnees'),
		array('formidable_associer_forms'),
	);

	// Ajout du choix de ce qu'on affiche à la fin des traitements
	$maj['0.4.0'] = array(array('maj_tables',array('spip_formulaires')));
	// Ajout d'une URL de redirection
	$maj['0.5.0'] = array(array('maj_tables',array('spip_formulaires')));
	// Modif du type du message de retour pour pouvoir mettre plus de chose
	$maj['0.5.1'] = array(array('sql_alter','TABLE spip_formulaires CHANGE message_retour message_retour text NOT NULL default ""'));
	// Passer le champ saisies en longtext pour permettre d'y stocker des formulaires longs
	$maj['0.5.2'] = array(array('sql_alter','TABLE spip_formulaires CHANGE saisies saisies longtext NOT NULL default ""'));
	// Ajouter un champ date de création
	$maj['0.5.3'] = array(array('sql_alter','TABLE spip_formulaires ADD date_crea datetime NOT NULL DEFAULT "0000-00-00 00:00:00"'));
	// Renommer la date de création (pas d'abbréviations dans les noms)
	$maj['0.5.5'] = array(array('sql_alter','TABLE spip_formulaires CHANGE date_crea date_creation datetime NOT NULL DEFAULT "0000-00-00 00:00:00"'));
	// statut publie sur les formulaires sans statut
	$maj['0.5.6'] = array(
		array('sql_updateq', 'spip_formulaires', array('statut'=>'publie'), 'statut='.sql_quote('')),
	);
	$maj['0.6.0'] = array(
		array('sql_alter','TABLE spip_formulaires_reponses_champs RENAME TO spip_formulaires_reponses_champs_bad'),
		array('maj_tables',array('spip_formulaires_reponses_champs')),
		array('formidable_transferer_reponses_champs'),
		array('sql_drop_table','spip_formulaires_reponses_champs_bad'),
	);
	$maj['0.6.1'] = array(
		array('formidable_unifier_reponses_champs'),
	);
	$maj['0.6.3'] = array(
		array('sql_alter','TABLE spip_formulaires_reponses_champs ADD UNIQUE reponse (id_formulaires_reponse,nom)'),
	);
	$maj['0.6.4'] = array(
		// champ resume_reponse
		array('maj_tables',array('spip_formulaires')),
	);
	// Pouvoir rendre un champ unique
	$maj['0.6.5'] = array(
		// champ resume_reponse
		array('maj_tables',array('spip_formulaires')),
	);
	$maj['0.6.6'] = array(
		array('sql_updateq', 'spip_formulaires_reponses', array('statut' => 'refuse'), 'statut='.sql_quote('poubelle')),
	);
	// Ajouter un champ "css" sur les formulaires
	$maj['0.7.0'] = array(
		array('maj_tables', array('spip_formulaires')),
	);
	// Migrer afficher_si_remplissage vers la checkbox
	$maj['0.8.0'] = array(
		array('formidable_migrer_formulaires_afficher_si_remplissage')
	);
	$maj['0.9.0'] = array(
		array('formidable_migrer_resume_reponse')
	);
	$maj['0.10.0'] = array(
		array('formidable_migrer_reglage_champ_unique')
	);
	$maj['0.11.0'] = array(
		array('formidable_migrer_anonymisation')
	);
	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}


function formidable_unifier_reponses_champs() {

	$rows = sql_allfetsel(
		'DISTINCT id_formulaires_reponses_champ,id_formulaires_reponse,nom,count(id_formulaires_reponse) AS N',
		'spip_formulaires_reponses_champs',
		'nom LIKE '.sql_quote('multiple%').' OR nom LIKE '.sql_quote('mot%'),
		'concat( id_formulaires_reponse, nom )',
		'id_formulaires_reponse',
		'0,100',
		'N>1'
	);
	do {
		foreach ($rows as $row) {
			#var_dump($row);
			// pour chaque reponse on recupere tous les champs
			$reponse = sql_allfetsel(
				'*',
				'spip_formulaires_reponses_champs',
				'id_formulaires_reponse='.intval($row['id_formulaires_reponse'])
			);
			spip_log('id_formulaires_reponse '.$row['id_formulaires_reponse'], 'formidable_unifier_reponses_champs'._LOG_INFO_IMPORTANTE);
			// on les reinsere un par un dans la nouvelle table propre
			$data = array();
			foreach ($reponse as $champ) {
				$data[$champ['nom']][] = $champ;
			}

			foreach ($data as $nom => $champs) {
				if (count($champs)>1) {
					#var_dump($champs);
					$keep = $champs[0]['id_formulaires_reponses_champ'];
					$delete = array();
					$valeurs = array();
					foreach ($champs as $champ) {
						$valeurs[] = $champ['valeur'];
						if ($champ['id_formulaires_reponses_champ'] !== $keep) {
							$delete[] = $champ['id_formulaires_reponses_champ'];
						}
					}
					$valeurs = serialize($valeurs);
					#var_dump($valeurs);
					#var_dump($keep);
					#var_dump($delete);
					sql_updateq('spip_formulaires_reponses_champs', array('valeur'=>$valeurs), 'id_formulaires_reponses_champ='.intval($keep));
					sql_delete('spip_formulaires_reponses_champs', sql_in('id_formulaires_reponses_champ', $delete));
					//die();
				}
			}
			#var_dump($data);
			//die('nothing?');

			if (time()>_TIME_OUT) {
				return;
			}
		}

		if (time()>_TIME_OUT) {
			return;
		}
	} while ($rows = sql_allfetsel('DISTINCT id_formulaires_reponses_champ,id_formulaires_reponse,nom,count( id_formulaires_reponse ) AS N', 'spip_formulaires_reponses_champs', 'nom LIKE '.sql_quote('multiple%').' OR nom LIKE '.sql_quote('mot%'), 'concat( id_formulaires_reponse, nom )', 'id_formulaires_reponse', '0,100', 'N>1'));
	//die('fini?');
}


function formidable_transferer_reponses_champs() {

	$rows = sql_allfetsel('DISTINCT id_formulaires_reponse', 'spip_formulaires_reponses_champs_bad', '', 'id_formulaires_reponse', '', '0,100');
	do {
		foreach ($rows as $row) {
			// pour chaque reponse on recupere tous les champs
			$reponse = sql_allfetsel('*', 'spip_formulaires_reponses_champs_bad', 'id_formulaires_reponse='.intval($row['id_formulaires_reponse']));
			// on les reinsere un par un dans la nouvelle table propre
			foreach ($reponse as $champ) {
				sql_insertq('spip_formulaires_reponses_champs', $champ);
			}
			// et on les vire de la mauvaise
			sql_delete('spip_formulaires_reponses_champs_bad', 'id_formulaires_reponse='.intval($row['id_formulaires_reponse']));
			if (time()>_TIME_OUT) {
				return;
			}
		}

		if (time()>_TIME_OUT) {
			return;
		}
	} while ($rows = sql_allfetsel('DISTINCT id_formulaires_reponse', 'spip_formulaires_reponses_champs_bad', '', 'id_formulaires_reponse', '', '0,100'));
}

/**
 * Déplace les réglages sur les tests d'unicité depuis des colonnes vers des sous options du traitement "enregistrer"
 *
 *
 * @return void
 */
function formidable_migrer_reglage_champ_unique() {
	include_spip('inc/sql');
	$res = sql_select('id_formulaire,unicite,message_erreur_unicite,traitements','spip_formulaires');

	while ($row = sql_fetch($res)) {
		$traitements = unserialize($row['traitements']);
		if (!isset($traitements['enregistrement'])) {
			$traitements['enregistrement'] = array();
		}
		if ($row['unicite'] != '') {
			$traitements['enregistrement']['unicite'] = $row['unicite'];
		}
		if ($row['message_erreur_unicite'] != '') {
			$traitements['enregistrement']['message_erreur_unicite'] = $row['message_erreur_unicite'];
		}
		$traitements = serialize($traitements);
		sql_updateq('spip_formulaires',array('traitements'=>$traitements),'id_formulaire='.$row['id_formulaire']);

	}
	sql_alter("TABLE spip_formulaires DROP message_erreur_unicite, DROP unicite");
}

/**
 * Cherche tous les formulaires et migre les conditions afficher_si_remplissage
 * vers le champ afficher_si + afficher_si_remplissage_uniquement coché
 *
 * @return void
 */
function formidable_migrer_formulaires_afficher_si_remplissage(){
	// selection
	include_spip('inc/saisies_migrer_afficher_si_remplissage');
	if ($res = sql_select(array('id_formulaire','saisies'), 'spip_formulaires')) {
			// boucler sur les resultats
			while ($row = sql_fetch($res)) {
				$id_formulaire = $row["id_formulaire"];
				if ($saisies = unserialize($row['saisies'])) {
					$saisies = saisies_migrer_afficher_si_remplissage($saisies);
					$saisies = serialize($saisies);
					sql_updateq(
						'spip_formulaires',
						array('saisies'=>$saisies),
						"id_formulaire=".intval($id_formulaire)
					);
				}
			}
	}
}

/**
 * Convertit la config d'anonymisation des réponses des formulaires qui l'avaient activés.
 * Le but étant de séparer l'anonymisation et l'identification par valeur PHP.
 * C'est à dire, pour ces formulaires:
 * 1. Change le nom de la variable de config.
 * 2. Si jamais la identification était par id_auteur, la transforme en par valeur php.
 * 3. Conserve l'anonymat des réponses
 * Et aussi
 * 1. Avant toute chose, crée une colonne variable_php
 * 2. Migre, pour les formulaires concernées, id_auteur vers variable_php
 * @return void
 **/
function formidable_migrer_anonymisation() {
	sql_alter("TABLE spip_formulaires_reponses ADD column `variable_php` bigint(21) NOT NULL default 0 AFTER `cookie`");
	sql_alter("TABLE spip_formulaires_reponses ADD INDEX (variable_php)");
	$res = sql_select("id_formulaire, traitements", "spip_formulaires");
	while ($row = sql_fetch($res)) {
		$id_formulaire = $row["id_formulaire"];
		$traitements = unserialize($row["traitements"]);
		$enregistrement = isset($traitements["enregistrement"]) ? $traitements["enregistrement"] : array();
		// A-ton l'option d'anonymisation activée? alors on migre, sinon rien à changer
		if (isset($enregistrement['anonymiser']) and $enregistrement["anonymiser"] == "on") {
			$enregistrement["variable_php"] = isset($enregistrement["anonymiser_variable"]) ? $enregistrement["anonymiser_variable"] : '';
			unset($enregistrement["anonymiser_variable"]);
			if (isset($enregistrement["identification"]) and $enregistrement["identification"] == "id_auteur") {
				$enregistrement["identification"] = "variable_php";
			}
			// Mettre à jour le traitement
			$traitements["enregistrement"] = $enregistrement;
			$traitements = serialize($traitements);
			sql_updateq("spip_formulaires", array("traitements" => $traitements), "id_formulaire=$id_formulaire");
			// Mettre à jour les réponses
			$res_reponse = sql_select("id_auteur,id_formulaires_reponse", "spip_formulaires_reponses", "id_formulaire=$id_formulaire");
			while ($raw_reponse = sql_fetch($res_reponse)) {
				$id_formulaires_reponse = $raw_reponse["id_formulaires_reponse"];
				sql_updateq("spip_formulaires_reponses", array("variable_php"=>$raw_reponse["id_auteur"], "id_auteur" => 0), "id_formulaires_reponse=$id_formulaires_reponse");
			}
		}
	}
}


/**
 * Cherche tous les formulaires et migre le champ resume_reponse vers une option du traitement "enregistrer"
 *
 * Supprime ensuite ce champ de la structure de table
 * @return void
 */
function formidable_migrer_resume_reponse() {
	if ($res = sql_select(array('id_formulaire','traitements','resume_reponse'), 'spip_formulaires')) {
		while ($row = sql_fetch($res)) {
			$id_formulaire = $row['id_formulaire'];
			$traitements = unserialize($row['traitements']);
			$resume_reponse = $row['resume_reponse'];
			if ($resume_reponse) {
				if (isset($traitements['enregistrement'])) {
					$traitements['enregistrement']['resume_reponse'] = $resume_reponse;
				} else {
					$traitements['enregistrement'] = array('resume_reponse' => $resume_reponse);
				}
				sql_updateq(
					'spip_formulaires',
					array('traitements'=>serialize($traitements)),
					"id_formulaire=$id_formulaire"
				);
			}
		}
	}

	// suppression du champ
	sql_alter("TABLE spip_formulaires DROP COLUMN resume_reponse");

}
/**
 * Désinstallation/suppression des tables de formidable
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @return void
 */
function formidable_vider_tables($nom_meta_base_version) {

	include_spip('inc/meta');
	include_spip('base/abstract_sql');

	// On efface les tables du plugin
	sql_drop_table('spip_formulaires');
	sql_drop_table('spip_formulaires_reponses');
	sql_drop_table('spip_formulaires_reponses_champs');
	sql_drop_table('spip_formulaires_liens');

	// on efface les champs d'import de f&t si il y a lieu
	$trouver_table = charger_fonction('trouver_table', 'base');
	if ($trouver_table('spip_forms')) {
		sql_alter('TABLE spip_forms DROP id_formulaire');
	}
	if ($trouver_table('spip_forms_donnees')) {
		sql_alter('TABLE spip_forms_donnees DROP id_formulaires_reponse');
	}
	// On efface la version entregistrée
	effacer_meta($nom_meta_base_version);
}

/**
 * Associer les <formXX> issus de f&t aux articles concernes
 */
function formidable_associer_forms() {
	include_spip('inc/rechercher');
	include_spip('inc/editer_liens');
	$forms = sql_allfetsel('*', 'spip_formulaires', 'identifiant REGEXP '.sql_quote('^form[0-9]+$'));
	foreach ($forms as $form) {
		if (!sql_countsel('spip_formulaires_liens', 'id_formulaire='.intval($form['id_formulaire']))) {
			$articles = array();
			$id = $form['identifiant'];
			#var_dump($id);
			$res = recherche_en_base("/<{$id}[>|]/", 'article');
			#var_dump($res);
			if (count($res) and isset($res['article'])) {
				foreach ($res['article'] as $id_article => $details) {
					$articles[] = $id_article;
				}
			}
			#var_dump($form['id_formulaire']);
			#var_dump($articles);
			objet_associer(array('formulaire' => array($form['id_formulaire'])), array('article' => $articles));
		}
		if (time()>_TIME_OUT) {
			return;
		}
	}
}

/**
 * Importer les formulaires de f&t
 */
function formidable_importer_forms() {
	$trouver_table = charger_fonction('trouver_table', 'base');
	if ($trouver_table('spip_forms')) {
		sql_alter('TABLE spip_forms ADD id_formulaire bigint(21) NOT NULL DEFAULT 0');

		include_spip('echanger/formulaire/forms');

		$forms = sql_allfetsel('*', 'spip_forms', 'id_formulaire=0 AND type_form='.sql_quote('').' OR type_form='.sql_quote('sondage'), '', 'id_form');
		foreach ($forms as $form) {
			$formulaire = array();
			// configurer le formulaire (titre etc)
			forms_configure_formulaire($form, $formulaire);

			// identifiant formXX puisqu'on est en installation, pas de risque de conflits
			// et facilite la migration de modele
			$formulaire['identifiant'] = 'form' . $form['id_form'];
			// on peut faire ca aussi puisqu'on est a l'installation
			$formulaire['id_formulaire'] = $form['id_form'];

			$fields = sql_allfetsel('*', 'spip_forms_champs', 'id_form='.intval($form['id_form']), '', 'rang');
			foreach ($fields as $field) {
				$choix = sql_allfetsel('*', 'spip_forms_champs_choix', 'id_form='.intval($form['id_form']).' AND champ='.sql_quote($field['champ']), '', 'rang');
				if (count($choix)) {
					$field['choix'] = $choix;
				}

				if ($saisie = forms_champ_vers_saisie($field)) {
					$formulaire['saisies'][] = $saisie;
				}
			}

			// les traitements
			forms_configure_traitement_formulaire($form, $formulaire);

			// si ce formulaire a des reponses on le met en publie
			if (sql_countsel('spip_forms_donnees', 'id_form='.intval($form['id_form']))) {
				$formulaire['statut'] = 'publie';
			}

			$id_formulaire = forms_importe_en_base($formulaire);
			spip_log('Import spip_forms #'.$form['id_form']." en spip_formulaires #$id_formulaire", 'maj'._LOG_INFO_IMPORTANTE);

			sql_update('spip_forms', array('id_formulaire' => $id_formulaire), 'id_form='.intval($form['id_form']));

			if (time()>_TIME_OUT) {
				return;
			}
		}
	}
	include_spip('inc/drapeau_edition');
	debloquer_tous($GLOBALS['visiteur_session']['id_auteur']);
}

function formidable_importer_forms_donnees() {
	$trouver_table = charger_fonction('trouver_table', 'base');
	if ($trouver_table('spip_forms')) {
		sql_alter('TABLE spip_forms_donnees ADD id_formulaires_reponse bigint(21) NOT NULL DEFAULT 0');

		// 2 champs de plus pour ne pas perdre des donnees
		sql_alter("TABLE spip_formulaires_reponses ADD url varchar(255) NOT NULL default ''");
		sql_alter("TABLE spip_formulaires_reponses ADD confirmation varchar(10) NOT NULL default ''");

		// table de correspondance id_form=>id_formulaire
		$rows = sql_allfetsel('id_form,id_formulaire', 'spip_forms', 'id_formulaire>0');
		$trans = array();
		foreach ($rows as $row) {
			$trans[$row['id_form']] = $row['id_formulaire'];
		}

		$rows = sql_allfetsel('*', 'spip_forms_donnees', sql_in('id_form', array_keys($trans)).' AND id_formulaires_reponse=0', '', 'id_donnee', '0,100');
		do {
			foreach ($rows as $row) {
				#var_dump($row);
				$reponse = array(
					'id_formulaires_reponse' => $row['id_donnee'], // conserver le meme id par facilite (on est sur une creation de base)
					'id_formulaire' => $trans[$row['id_form']],
					'date' => $row['date'],
					'ip' => $row['ip'],
					'id_auteur' => $row['id_auteur'],
					'cookie' => $row['cookie'],
					'statut' => $row['statut'],
					'url' => $row['url'],
					'confirmation' => $row['confirmation'],
				);

				#var_dump($reponse);
				$id_formulaires_reponse = sql_insertq('spip_formulaires_reponses', $reponse);
				#var_dump($id_formulaires_reponse);
				if ($id_formulaires_reponse) {
					$donnees = sql_allfetsel(
						"$id_formulaires_reponse as id_formulaires_reponse,champ as nom,valeur",
						'spip_forms_donnees_champs',
						'id_donnee='.intval($row['id_donnee'])
					);
					$data = array();
					foreach ($donnees as $donnee) {
						$data[$donnee['nom']][] = $donnee;
					}
					$ins = array();
					foreach ($data as $nom => $valeurs) {
						if (count($valeurs) == 1) {
							$ins[] = reset($valeurs);
						} else {
							$v = array();
							foreach ($valeurs as $valeur) {
								$v[] = $valeur['valeur'];
							}
							$valeurs[0]['valeur'] = serialize($v);
							$ins[] = $valeurs[0];
						}
					}
					sql_insertq_multi('spip_formulaires_reponses_champs', $ins);
					// et on marque la donnee pour ne pas la rejouer
					sql_update('spip_forms_donnees', array('id_formulaires_reponse' => $id_formulaires_reponse), 'id_donnee='.intval($row['id_donnee']));
				}
				if (time()>_TIME_OUT) {
					return;
				}
			}
			if (time()>_TIME_OUT) {
				return;
			}
		} while ($rows = sql_allfetsel('*', 'spip_forms_donnees', sql_in('id_form', array_keys($trans)).' AND id_formulaires_reponse=0', '', 'id_donnee', '0,100'));
	}
}
