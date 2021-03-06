<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

if (!defined('_LANGONET_PATTERN_FONCTION_L'))
	define("_LANGONET_PATTERN_FONCTION_L", "#\b_L\s*[(]\s*([\"'])((?:\\\\\\1|[^\\1])+)\\1[^)]*\)#Uims");
if (!defined('_LANGONET_PATTERN_FICHIERS_L'))
	define('_LANGONET_PATTERN_FICHIERS_L', '(?<!/charsets|/lang|/req)(/[^/]*\.(php))$');


/**
 * Verification de l'utilisation de la fonction _L() dans le code PHP.
 *
 * Cette fonction construit le tableau des occurrences du premier argument de _L.
 * Ce tableau est indexe par un representant canonique de chaque chaine trouvee.
 * Les valeurs de ce tableau sont des sous-tableaux indexes par le nom du fichier.
 * Chacun a pour valeur une série de sous-tableaux [n° de ligne][n° de colonne] pointant
 * sur un tableau des résultats :
 * - [0] : l'expression complète renvoyée par la regexp
 * - [1] : le raccourci brut sans gestion des collisions
 * - [2] : le texte du premier argument de la fonction _L
 * - [3] : la ligne complète d'où est tirée l'expression reconnue
 *
 * @param string $ou_fichier
 * 		Racine de l'arborescence à vérifier.
 * 		On n'examine pas les ultimes sous-répertoires charsets/,lang/ , req/ et /.
 * 		On n'examine que les fichiers php (voir le fichier regexp.txt).
 * @return array
 * 		Si une erreur se produit lors du deroulement de la fonction, le tableau resultat contient le libelle
 * 		de l'erreur dans l'index 'erreur'; sinon, cet index n'existe pas.
 */
function inc_verifier_l($ou_fichier) {

	// Initialisation du tableau des resultats
	// Si une erreur se produit lors du déroulement de la fonction, le tableau contient le libellé
	// de l'erreur dans $resultats['erreur'].
	// Sinon, cet index n'existe pas
	$resultats = array();

	// Construire la liste des fichiers php dans lesquels rechercher la fonction _L()
	$fichiers = preg_files(_DIR_RACINE . $ou_fichier, _LANGONET_PATTERN_FICHIERS_L);

	// Chercher, pour chaque fichier collecté, le pattern de la fonction _L()
	if ($fichiers) {
		include_spip('inc/outiller');

		$occurrences = array();
		$nb_occurrences = 0;
		$items = array();
		foreach ($fichiers as $_fichier) {
			$contenu = file($_fichier);
			if ($contenu) {
				foreach ($contenu as $_no_ligne => $_ligne) {
					if (preg_match_all(_LANGONET_PATTERN_FONCTION_L, $_ligne, $matches, PREG_OFFSET_CAPTURE)) {
						foreach ($matches[2] as $_cle => $_occurrence) {
							// Calcul du nom du raccourci de l'item de langue
							$traduction = $_occurrence[0];
							list($raccourci, $raccourci_brut) = calculer_raccourci_unique($traduction, $items);
							// Stockage de ce raccourci et du texte exact contenu dans l'occurrence _L() pour les corrections
							$items[$raccourci] = $traduction;
							// Ajout de l'occurrence trouvée dans la liste des erreurs
							$expression = $matches[0][$_cle][0];
							$no_colonne = $matches[0][$_cle][1];
							$occurrences[$raccourci][$_fichier][$_no_ligne][$no_colonne] =
								array($expression, $raccourci_brut, $traduction, $_ligne);
							// Compteur d'occurrences
							$nb_occurrences++;
						}
					}
				}
			}
		}

		$resultats['ou_fichier'] = $ou_fichier;
		$resultats['total_occurrences'] = $nb_occurrences;
		$resultats['occurrences_non'] = $occurrences;
		$resultats['items_a_corriger'] = $items;
	}
	else {
		$resultats['erreur'] = _T('langonet:message_nok_arborescence_l');
	}

	return $resultats;
}
