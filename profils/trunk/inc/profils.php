<?php
/**
 * Fonctions utilitaires pour les profils
 *
 * @plugin     Profils
 * @copyright  2018
 * @author     Les Développements Durables
 * @licence    GNU/GPL
 * @package    SPIP\Profils\Utils
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

include_spip('base/objets');
include_spip('base/abstract_sql');
include_spip('action/editer_liens');

/**
 * Cherche le profil suivant un id SQL ou un identifiant textuel
 * 
 * @param int|string $id_ou_identifiant_profil
 * 		ID SQL ou identifiant textuel du profil
 * @return array|bool
 * 		Retourne le profil demandé ou false
 */
function profils_chercher_profil($id_ou_identifiant_profil) {
	static $profils = array();
	$profil = false;
	
	// Si on l'a déjà trouvé avant
	if (isset($profils[$id_ou_identifiant_profil])) {
		return $profils[$id_ou_identifiant_profil];
	}
	// Sinon on cherche
	else {
		if (!$id_ou_identifiant_profil) {
			return $profil;
		}
		elseif ($id_ou_identifiant_profil === intval($id_ou_identifiant_profil)) {
			$profil = sql_fetsel('*', 'spip_profils', 'id_profil = '.intval($id_ou_identifiant_profil));
		}
		else {
			$profil = sql_fetsel('*', 'spip_profils', 'identifiant = '.sql_quote($id_ou_identifiant_profil));
		}
	}
	
	if ($profil) {
		$profil['config'] = unserialize($profil['config']);
	}
	
	$profils[$id_ou_identifiant_profil] = $profil;
	return $profil;
}

/**
 * Cherche les saisies d'édition d'un objet ET des champs extras ajoutés
 * 
 * @param string $objet
 * 		Nom de l'objet dont on cherche les saisies
 * @return array
 * 		Retoure un tableau de saisies
 * 
 */
function profils_chercher_saisies_objet($objet) {
	static $saisies = array();
	$objet = objet_type($objet);
	
	if (isset($saisies[$objet])) {
		return $saisies[$objet];
	}
	else {
		$saisies[$objet] = array();
		
		// Les saisies de base
		if ($saisies_objet = saisies_chercher_formulaire("editer_$objet", array())) {
			$saisies[$objet] = array_merge($saisies[$objet], $saisies_objet);
		}
		
		// Les saisies des champs extras
		if (defined('_DIR_PLUGIN_CEXTRAS')) {
			include_spip('cextras_pipelines');
			
			if ($saisies_extra = champs_extras_objet(table_objet_sql($objet))) {
				$saisies[$objet] = array_merge($saisies[$objet], $saisies_extra);
			}
		}
	}
	
	return $saisies[$objet];
}

/**
 * Cherche les saisies configurées pour un profil pour tel formulaire (inscription ou édition du profil)
 * 
 * @param string $form
 * 		Quel formulaire : "inscription" ou "edition" 
 * @param $id_auteur 
 * 		Identifiant du compte utilisateur dont on cherche les saisies
 * @param $id_ou_identifiant_profil 
 * 		Identifiant du profil, notamment si c'est une création
 * @return array
 * 		Retourne le tableau des saisies du profil
 */
function profils_chercher_saisies_profil($form, $id_auteur='', $id_ou_identifiant_profil='') {
	$saisies = array();
	
	// S'il y a un id_auteur on cherche s'il a un profil
	if (intval($id_auteur) > 0 and $id_profil = sql_getfetsel('id_profil', 'spip_auteurs', 'id_auteur = '.intval($id_auteur))) {
		$id_ou_identifiant_profil = $id_profil;
	}
	
	// On ne continue que si on a un profil sous la main
	if ($profil = profils_chercher_profil($id_ou_identifiant_profil) and $config = $profil['config']) {
		foreach (array('auteur', 'organisation', 'contact') as $objet) {
			// Si c'est autre chose que l'utilisateur, faut le plugin qui va avec et que ce soit activé
			if ($objet == 'auteur' or (defined('_DIR_PLUGIN_CONTACTS') and $config["activer_$objet"])) {
				// On récupère les champs pour cet objet ET ses champs extras s'il y a
				$saisies_objet = profils_chercher_saisies_objet($objet);
				$saisies_a_utiliser = array();
				
				// Pour chaque chaque champ vraiment configuré
				foreach ($config[$objet] as $champ => $config_champ) {
					// On cherche la saisie pour ce champ SI c'est pour le form demandé
					if (in_array($form, $config_champ) and $saisie = saisies_chercher($saisies_objet, $champ)) {
						// On modifie son nom
						$saisie['options']['nom'] = $objet . '[' . $saisie['options']['nom'] . ']';
						// On modifie son obligatoire suivant la config
						$saisie['options']['obligatoire'] = in_array('obligatoire', $config_champ) ? 'oui' : false;
						// On ajoute la saisie
						$saisies_a_utiliser[] = $saisie;
					}
				}
				
				// On cherche des coordonnées pour cet objet
				if (
					defined('_DIR_PLUGIN_COORDONNEES')
					and $config["activer_coordonnees_$objet"]
					and $coordonnees = $config['coordonnees'][$objet]
				) {
					// Pour chaque type de coordonnéees (num, email, adresse)
					foreach ($coordonnees as $coordonnee => $champs) {
						// Pour chaque champ ajouté
						foreach ($champs as $cle => $champ) {
							// Si ce cette coordonnées est configurée pour le form demandé
							if ($champ[$form]) {
								// Attention, si pas de type, on transforme ici en ZÉRO
								if (!$champ['type']) {
									$champ['type'] = 0;
								}
								// On va chercher les saisies de ce type de coordonnées
								$saisies_coordonnee = profils_chercher_saisies_objet($coordonnee);
								// On vire le titre libre
								$saisies_coordonnee = saisies_supprimer($saisies_coordonnee, 'titre');
								// On change le nom de chacun des champs
								$saisies_coordonnee =  saisies_transformer_noms(
									$saisies_coordonnee,
									'/^\w+$/',
									"coordonnees[$objet][$coordonnee][${champ['type']}][\$0]"
								);
								// On reconstitue le label
								$label = $champ['label'] ? $champ['label'] : _T(objet_info(table_objet_sql($coordonnee), 'texte_objet'));
								if ($champ['type'] and !$champ['label']) {
									$label .= ' (' . coordonnees_lister_types_coordonnees(objet_type($coordonnee), $champ['type']) . ')';
								}
								// Si c'est un numéro ou un email on change peut-être le label du champ lui-même et le obligatoire
								if (in_array($coordonnee, array('numeros', 'emails'))) {
									$saisies_coordonnee = saisies_modifier(
										$saisies_coordonnee,
										"coordonnees[$objet][$coordonnee][${champ['type']}][" . objet_type($coordonnee) . ']',
										array(
											'options' => array(
												'label' => $label,
												'obligatoire' => $champ['obligatoire'] ? 'oui' : false,
											),
										)
									);
									// On ajoute enfin
									$saisies_a_utiliser	= array_merge($saisies_a_utiliser, $saisies_coordonnee);
								}
								// Alors que si c'est une adresse on l'utilise pour le groupe de champs
								else {
									$saisies_a_utiliser[] = array(
										'saisie' => 'fieldset',
										'options' => array(
											'nom' => "groupe_${coordonnee}_$cle",
											'label' => $label,
										),
										'saisies' => $saisies_coordonnee,
									);
								}
							}
						}
					}
				}
				
				// On teste s'il faut un groupe de champs ou pas pour cet objet
				if ($saisies_a_utiliser and $legend = $config["activer_groupe_$objet"]) {
					$saisies[] = array(
						'saisie' => 'fieldset',
						'options' => array(
							'nom' => "groupe_$objet",
							'label' => $legend,
						),
						'saisies' => $saisies_a_utiliser,
					);
				}
				// Sinon on les ajoute directement
				else {
					$saisies = array_merge($saisies, $saisies_a_utiliser);
				}
			}
		}
	}
		
	return $saisies;
}

/**
 * Récupérer tous les identifiants des objets liés à un profil
 *
 * @param int $id_auteur=0
 * 		Identifiant d'un auteur précis, sinon visiteur en cours
 * @return array
 * 		Retourne un tableau de tous les identifiants
 */
function profils_chercher_ids_profil($id_auteur=0, $id_ou_identifiant_profil='') {
	$ids = array();
	$ids['id_auteur'] = intval($id_auteur);
	$coordonnees_liees = array();
	
	// Cherchons un utilisateur
	if (!$ids['id_auteur'] and !$ids['id_auteur'] = intval(session_get('id_auteur'))) {
		$ids['id_auteur'] = 'new';
	}
	// Si on a un utilisateur et qu'il n'y a pas de profil déjà fourni
	elseif (!$id_ou_identifiant_profil) {
		$id_ou_identifiant_profil = sql_getfetsel('id_profil', 'spip_auteurs', 'id_auteur = '.$ids['id_auteur']);
	}
	
	// Maintenant on ne continue que si on a trouvé un profil
	if ($profil = profils_chercher_profil($id_ou_identifiant_profil) and $config = $profil['config']) {
		// Si le plugin est toujours là
		if (defined('_DIR_PLUGIN_CONTACTS')) {
			// Est-ce qu'il y a une orga en fiche principale ?
			if ($config['activer_organisation']) {
				// Cherchons une organisation
				if (
					!intval($ids['id_auteur'])
					or !$id_organisation = intval(sql_getfetsel('id_organisation', 'spip_organisations', 'id_auteur = '.$ids['id_auteur']))
				) {
					$ids['id_organisation'] = 'new';
				}
				
				// Il peut aussi y avoir un contact physique *lié à l'orga*
				if (
					!intval($ids['id_organisation'])
					or !$liens = objet_trouver_liens(array('contact'=>'*'), array('organisation'=>$ids['id_organisation']))
					or !$contact = $liens[0]
					or !$ids['id_contact'] = intval($contact['id_contact'])
				) {
					$ids['id_contact'] = 'new';
				}
			}
			elseif ($config['activer_contact']) {
				// Cherchons un contact physique
				if (
					!intval($ids['id_auteur'])
					or !$ids['id_contact'] = intval(sql_getfetsel('id_contact', 'spip_contacts', 'id_auteur = '.$ids['id_auteur']))
				) {
					$ids['id_contact'] = 'new';
				}
			}
		}
		
		// Si on doit chercher des coordonnées
		if (defined('_DIR_PLUGIN_COORDONNEES')) {
			foreach (array('auteur', 'organisation', 'contact') as $objet) {
				// S'il y a des coordonnées activées pour cet objet
				if ($config["activer_coordonnees_$objet"] and $coordonnees = $config['coordonnees'][$objet]) {
					$cle_objet = id_table_objet($objet);
					
					foreach ($coordonnees as $coordonnee => $champs) {
						$cle_coordonnee = id_table_objet($coordonnee);
						
						foreach ($champs as $cle => $champ) {
							// On cherche s'il y a une liaison sinon new
							if (
								!$id_objet = $ids[$cle_objet]
								or !$liens = objet_trouver_liens(
									array(objet_type($coordonnee) => '*'),
									array($objet => $id_objet),
									array('type = '.sql_quote($champ['type']))
								)
								or !$liaison = $liens[0]
								or !$coordonnees_liees[$objet][$coordonnee][$champ['type']] = $liaison[$cle_coordonnee]
							) {
								$coordonnees_liees[$objet][$coordonnee][$champ['type']] = 'new';
							}
						}
					}
				}
			}
			
			// S'il y a des coordonnées on ajoute
			if ($coordonnees_liees) {
				$ids['coordonnees'] = $coordonnees_liees;
			}
		}
	}
	
	return $ids;
}

/**
 * Récupérer les informations complètes d'un profil
 *
 * @param int $id_auteur=0
 * 		Identifiant d'un auteur précis, sinon visiteur en cours
 * @return array
 * 		Retourne les informations d'un profil, chaque objet SPIP dans une clé (organisation, contact, telephone, etc).
 */
function profils_recuperer_infos($id_auteur=0, $id_ou_identifiant_profil='') {
	$retour = '';
	$infos = array();
	
	// Récupérer les objets liés au profil utilisateur
	extract(profils_chercher_ids_profil($id_auteur, $id_ou_identifiant_profil));
	
	// On charge les infos du compte SPIP
	$infos['auteur'] = formulaires_editer_objet_charger('auteur', $id_auteur, 0, 0, $retour, '');
	
	// On charge les infos de l'organisation
	if ($id_organisation) {
		$infos['organisation'] = formulaires_editer_objet_charger('organisation', $id_organisation, 0, 0, $retour, '');
		unset($infos['organisation']['_pipeline']);
	}
	
	// On charge les infos du contact
	if ($id_contact) {
		$infos['contact'] = formulaires_editer_objet_charger('contact', $id_contact, intval($id_organisation), 0, $retour, '');
	}
	
	// S'il y a des coordonnées
	if ($coordonnees and is_array($coordonnees)) {
		foreach ($coordonnees as $objet => $coordonnees_objet) {
			foreach ($coordonnees_objet as $coordonnee => $champs) {
				foreach ($champs as $type => $id) {
					// Attention, si pas de type, on transforme ici en ZÉRO
					if (!$type) {
						$type = 0;
					}
					$infos['coordonnees'][$objet][$coordonnee][$type] = formulaires_editer_objet_charger(objet_type($coordonnee), $id, 0, 0, $retour, '');
				}
			}
		}
	}
	
	return $infos;
}
