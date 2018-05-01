<?php
/**
 * Utilisations de pipelines par le plugin Métas+
 *
 * @plugin     Métas+
 * @copyright  2016-2018
 * @author     Tetue, Erational, Tcharlss
 * @licence    GNU/GPL
 * @package    SPIP\Metas+\Pipelines
 */

// Sécurité
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Effectuer des traitements juste avant l'envoi des pages publiques.
 *
 * => Ajout des metas Open Graph, Dublin Core et Twitter dans le <head> public.
 *
 * Règles :
 * On va chercher dans le dossier inclure/metasplus le squelette de la variante spécifique à la page si elle existe, sinon le squelette générique dist.html qui génère automatiquement les métas.
 *
 * @Note : on retrouve les informations du contexte de l apage actuelle au moyen d'un squelette pour bénéficier de la mise en cache et éviter des requêtes SQL à chaque hit via decoder_url()
 *
 * @param $flux
 * @return mixed
 */
function metasplus_affichage_final($flux) {

	include_spip('inc/config');
	include_spip('inc/utils'); // pour self()

	// Tests préliminaires avant d'inclure éventuellement les métas
	if (!test_espace_prive()
		// Il y a un <head>
		and $pos_head = strpos($flux, '</head>')
		// Les protocoles ne sont pas tous désactivés (improbable mais possible)
		and (
			!lire_config('metasplus')
			or count(lire_config('metasplus')) < 3
		)
		// Le contexte est retrouvé
		and $url = self()
		and $contexte = recuperer_fond('metasplus_trouver_contexte', array('url' => $url))
		and is_array($contexte = unserialize($contexte))
		// La page n'est pas en erreur
		and empty($contexte['erreur'])
		// La page n'est pas exclue
		and is_array($pages_exclues = (
			(defined('_METASPLUS_PAGES_EXCLUES') and _METASPLUS_PAGES_EXCLUES) ?
				explode(',', _METASPLUS_PAGES_EXCLUES) :
				array()
		))
		and (!in_array($contexte['type-page'], $pages_exclues))
		// Ce n'est pas une page d'un pseudo fichier (ex. robots.txt.html)
		and !strpos($contexte['type-page'], '.')
	) {

		// Trouver le squelette à utiliser : variante de la page si elle existe, sinon le squelette par défaut (dist.html)
		$fond_defaut   = 'inclure/metasplus/dist';
		$fond_variante = 'inclure/metasplus/' . $contexte['type-page'];
		if (find_in_path($fond_variante.'.html')) {
			$fond = $fond_variante;
		} elseif (find_in_path($fond_defaut.'.html')) {
			$fond = $fond_defaut;
		}

		// Si le squelette n'est pas vide, on ajoute son contenu à la fin du head
		if ($fond
			and $metas = recuperer_fond($fond, $contexte)
		) {
			$metas = "<!-- Plugin Métas + -->\n$metas\n";
			$flux = substr_replace($flux, $metas, $pos_head, 0);
		}
	}

	return $flux;
}

/**
 * pipeline post_edition pour supprimer la meta metasplus/id_doc_logo
 * quand on supprime l'image dans le formualire de configuration
 *
 * @param $flux
 * @return $flux
 * @author tofulm
 **/
function metasplus_post_edition($flux){
	if (
		$flux['args']['table'] === 'spip_documents' and
		$flux['args']['operation'] === 'supprimer_document' and
		$flux['args']['action'] === 'supprimer_document' and
		$flux['args']['id_objet'] == lire_config('metasplus/id_doc_logo')
	) {
		effacer_config('metasplus/id_doc_logo');
	}
	return $flux;
}
