<?php

/**
 * Ajout de l'onglet Ajouter les plugins dont l'url depend du l'existence ou pas d'un depot
 * de plugins
 *
 * @param array $flux
 * @return array
 */
function relecture_ajouter_onglets($flux) {
    return $flux;
}


/**
 * Affichage en rappel dans la page d'accueil pour l'auteur connecte :
 * - des relectures a lesquelles il participe en tant que relecteur
 * - des relectures qu'il administre en tant qu'auteur de l'article
 *
 * @param array $flux
 * @return array
 *
**/
function relecture_accueil_encours($flux) {

	$flux .= recuperer_fond('prive/squelettes/contenu/accueil-relectures');

	return $flux;
}


/**
 * Affichage du bloc relecture de l'article en cours d'affichage :
 * - bouton ouvrir une relecture
 * - ou informations sur la relecture en cours
 *
 * @param array $flux
 * @return array
 *
**/
function relecture_affiche_gauche($flux) {

	if (($type = $flux['args']['exec'])=='article'){
		if ($id = intval($flux['args']['id_article'])) {
			$table = table_objet($type);
			$id_table_objet = id_table_objet($type);

			$flux['data'] .= recuperer_fond('prive/squelettes/navigation/article-relecture_ouverte',
								array($id_table_objet => $id));
		}
	}

	return $flux;
}


/**
 * Affichage dans la boite d'informations de l'article en cours d'affichage :
 * - du lien menant a l'historique des relectures cloturees
 *
 * @param array $flux
 * @return array
 *
**/
function relecture_boite_infos($flux){

	if (($type = $flux['args']['type'])=='article') {
		if ($id = intval($flux['args']['id'])) {
			$table = table_objet($type);
			$id_table_objet = id_table_objet($type);

			$flux['data'] .= recuperer_fond('prive/squelettes/infos/article-voir_relectures',
								array($id_table_objet => $id));
		}
	}

	return $flux;
}


/**
 * Surcharge de la fonction charger des formulaires concernes, a savoir :
 * - dater : dans la page relecture permet de choisir la date de fin des commentaires
 * - editer_liens : dans la page relecture permet de choisir les relecteurs
 * - instituer_objet : dans la page de l'article en cours de relecture bloque le statut de l'article
 *
 * @param array $flux
 * @return array
 *
**/
function relecture_formulaire_charger($flux){

	$form = $flux['args']['form'];
	$objet = $flux['data']['objet'] ? $flux['data']['objet'] : $flux['data']['_objet'];
	$id_objet = intval($flux['data']['id_objet']) ? intval($flux['data']['id_objet']) : intval($flux['data']['_id_objet']);

	if ($objet == 'relecture') {
		// Rendre editable le formulaire si la relecture n'est pas cloturee
		$from = 'spip_relectures';
		$where = array("id_relecture=$id_objet");
		$statut = sql_getfetsel('statut', $from, $where);
		$flux['data']['editable'] = ($statut !== 'fermee');

		if ($form == 'dater') {
			// Identifier le label comme la date de fin des commentaires
			$flux['data']['_label_date'] = _T('relecture:label_relecture_date_fin_commentaire');
		}
		else if ($form == 'editer_liens') {
			// Changer le titre du formulaire pour désigner clairement les relecteurs
			$flux['data']['titre'] = _T('relecture:titre_liste_relecteurs');
		}
	}
	else if ($objet == 'article') {
		if ($form == 'instituer_objet') {
			// Si une relecture est ouverte sur l'article alors on interdit de modifier
			// le statut de l'article qui reste a "en cours de redaction"
			$from = 'spip_relectures';
			$where = array("id_article=$id_objet", "statut=" . sql_quote('ouverte'));
			$flux['data']['editable'] = (sql_countsel($from, $where) == 0);
		}
	}

	return $flux;
}


/**
 * Surcharge de l'insertion standard d'un objet en incluant des traitements prealables pour une relecture :
 * - informations sur l'article
 * - information sur l'ouverture et la date de fin des commentaires
 * - positionnement du statut a ouvert
 *
 * @param array $flux
 * @return array
 *
**/
function relecture_pre_insertion($flux) {

	// Traitements particuliers de l'objet relecture dans le cas d'une ouverture :
	if ($flux['args']['table'] == 'spip_relectures') {
		if ($id_article = intval(_request('id_article'))) {
			// - recuperation des informations de l'article concerne (id, chapo, texte, descriptif, ps et la revision courante)
			$select = array('id_article, chapo AS article_chapo', 'descriptif AS article_descr', 'texte AS article_texte', 'ps AS article_ps');
			$from = 'spip_articles';
			$where = array("id_article=$id_article");
			$article = sql_fetsel($select, $from, $where);
			foreach ($article as $_cle => $_valeur) {
				$flux['data'][$_cle] = $_valeur;
			}

			// - mise a jour de la revision d'ouverture
			// - correction de la date de fin de commentaire positionnee par defaut a cause de la configuration
			// - mise a jour de la date d'ouverture
			$from = 'spip_versions';
			$where = array("objet=" . sql_quote('article'), "id_objet=$id_article");
			$revision = sql_getfetsel('max(id_version) AS revision_ouverture', $from, $where);
			$flux['data']['revision_ouverture'] = $revision;
			$flux['data']['date_ouverture'] = $flux['data']['date_fin_commentaire'];
			$flux['data']['date_fin_commentaire'] = date('Y-m-d H:i:s', strtotime("+1 week"));

			// - surcharge la valeur du statut mis par le traitement par defaut
			$flux['data']['statut'] = 'ouverte';
		}
	}

	return $flux;
}


/**
 * Surcharge de l'action instituer standard d'un objet en incluant des traitements prealables pour une relecture :
 * - date et revision de cloture
 *
 * @param array $flux
 * @return array
 *
**/
function relecture_pre_edition($flux) {

	$table = $flux['args']['table'];
	$id_relecture = intval($flux['args']['id_objet']);
	$action = $flux['args']['action'];

	// Traitements particuliers de l'objet relecture dans le cas d'une cloture :
	if (($table == 'spip_relectures')
	AND ($action == 'instituer')) {
		if (($id_relecture) AND ($flux['args']['statut_ancien'] == 'ouverte')) {
			// - mise a jour de la date de cloture
			$flux['data']['date_cloture'] = date('Y-m-d H:i:s');

			// - mise a jour de la revision de cloture
			$from = 'spip_relectures';
			$where = array("id_relecture=$id_relecture");
			$id_article = sql_getfetsel('id_article', $from, $where);

			$from = 'spip_versions';
			$where = array("objet=" . sql_quote('article'), "id_objet=$id_article");
			$flux['data']['revision_cloture'] = sql_getfetsel('max(id_version) AS revision', $from, $where);
		}
	}

	return $flux;
}

?>
