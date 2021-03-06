<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_importer_boussole_charger_dist(){

	return array(
		'boussole' => 'spip',
		'id_parent' => 0,
		'langue_site' => 1,
		'importer_statut_publie' => 0,
	);
}


function formulaires_importer_boussole_verifier_dist(){
	$erreurs = array();

	if (!_request('id_parent'))
		$erreurs['id_parent'] = _T('info_obligatoire');

	return $erreurs;
}


function formulaires_importer_boussole_traiter_dist(){
	$retour = array();

	$id_parent = intval(_request('id_parent'));
	$langue_site = _request('langue_site') ? true : false;
	$forcer_statut_publie = _request('importer_statut_publie') ? true : false;
	$boussole = _request('boussole');

	// Actualiser la boussole avant l'importation.
	// En effet, si des modifications sauvages ont été faites sur la base de données il se peut
	// que l'id_syndic soit encore présent dans spip_boussoles alors que le site a disparu de spip_syndic.
    include_spip('inc/client');
    boussole_actualiser_boussoles(array($boussole));
	// Importer les sites de la boussole
	$nb_sites = importer_sites_boussole($boussole, $id_parent, $langue_site, $forcer_statut_publie);
	// Actualiser la boussole (en fait uniquement les id_syndic) maintenant que les sites référencés sont créés.
	boussole_actualiser_boussoles(array($boussole));

	if (!$nb_sites)
		$retour['message_erreur'] = _T('boussole:message_nok_0_site_importe', array('boussole' => boussole_traduire($boussole, 'nom_boussole')));
	else
		$retour['message_ok'] = singulier_ou_pluriel(
									$nb_sites,
									'boussole:message_ok_1_site_importe',
									'boussole:message_ok_n_sites_importes',
									'nb',
									array('boussole' => boussole_traduire($boussole, 'nom_boussole')));
	$retour['editable'] = true;

	return $retour;
}


/**
 * @param string	$boussole
 * @param int		$id_parent
 * @param bool 		$langue_site
 * @param bool 		$forcer_statut_publie
 * @return int
 */
function importer_sites_boussole($boussole, $id_parent, $langue_site=true, $forcer_statut_publie=false) {
	$nb_sites = 0;

	if ($id_parent) {
		$from = array('spip_boussoles as b', 'spip_boussoles_extras as x');
		$select = array('b.url_site', 'b.id_syndic', 'x.nom_objet', 'x.slogan_objet', 'x.descriptif_objet', 'x.logo_objet');
		$where = array(
					'b.aka_boussole=' . sql_quote($boussole),
					'b.aka_boussole=x.aka_boussole', 'b.aka_site=x.aka_objet',
					'x.type_objet=' . sql_quote('site'));
		$sites = sql_allfetsel($select, $from, $where);

		if ($sites) {
			include_spip('action/editer_site');
			include_spip('inc/filtres');
			foreach($sites as $_site) {
				// Nouveau site : il faut le créer préalablement dans la rubrique choisie
				$id_syndic = !$_site['id_syndic']  ? site_inserer($id_parent) : $_site['id_syndic'];

				if ($id_syndic) {
					// Mise à jour complète du site existant ou venant d'être créé
					$contenu = array(
								'url_site' => $_site['url_site'],
								'nom_site' => ($langue_site ? extraire_multi($_site['nom_objet']) : $_site['nom_objet']),
								'date' => date('Y-m-d H:i:s'),
								'descriptif' => ($langue_site ? extraire_multi($_site['descriptif_objet']) : $_site['descriptif_objet']));
					if (!$_site['id_syndic'])
						$contenu = array_merge($contenu, array('statut' => (($forcer_statut_publie AND autoriser('publierdans','rubrique',$id_parent)) ? 'publie' : 'prop')));
					$erreur = site_modifier($id_syndic, $contenu);

					if (!$erreur) {
						if ($_site['logo_objet']) {
							// Mise à jour du logo du site normal ("on").
                            $iconifier = charger_fonction('iconifier_site', 'inc');
						    $iconifier($id_syndic, 'on', $_site['logo_objet']);
						}

						$nb_sites ++;
					}
					else {
						// On traite l'erreur en supprimant le site si celui-ci vient d'être inséré
						if (!$_site['id_syndic'])
							sql_delete('spip_syndic', 'id_syndic=' . sql_quote($id_syndic));
					}
				}
			}
		}
	}

	return $nb_sites;
}