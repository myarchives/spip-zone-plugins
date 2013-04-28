<?php

if (!defined('_ECRIRE_INC_VERSION')) return;


if (!defined('_LANGONET_PATTERN_FONCTION_L'))
	define("_LANGONET_PATTERN_FONCTION_L", "#\b_L\s*[(]\s*(['\"])([^\\1]+)\\1[^)]*\)#Uims");
if (!defined('_LANGONET_PATTERN_FICHIERS_L'))
	define('_LANGONET_PATTERN_FICHIERS_L', '(?<!/charsets|/lang|/req)(/[^/]*\.(php))$');


/**
 * Verification de l'utilisation de la fonction _L() dans le code PHP.
 *
 * Cette fonction construit le tableau des occurrences du premier argument de _L.
 * Ce tableau est indexe par un representant canonique de chaque chaine trouvee.
 * Les valeurs de ce tableau sont des sous-tableaux indexes par le nom du fichier.
 * Chacun a pour valeur un sous-sous-tableau indexe par le numero de ligne, pointant
 * sur un sous-sous-sous-tableau des resultats des preg_match(donc encore des tableaux, indexe numeriquement)
 *
 * @param $module
 * 		nom du module de langue
 * @param $ou_fichier
 * 		racine de l'arborescence a verifier.
 * 		On n'examine pas les ultimes sous-repertoires charsets/,lang/ , req/ et /.
 * 		On n'examine que les fichiers php (voir le fichier regexp.txt).
 * @return array
 * 		Si une erreur se produit lors du deroulement de la fonction, le tableau resultat contient le libelle
 * 		de l'erreur dans l'index 'erreur'; sinon, cet index n'existe pas.
 */
function inc_langonet_verifier_l($ou_fichier) {

	// Initialisation du tableau des resultats
	// Si une erreur se produit lors du deroulement de la fonction, le tableau contient le libelle
	// de l'erreur dans $resultats['erreur'].
	// Sinon, cet index n'existe pas
	$resultats = array();

	// Construire la liste des fichiers php dans lesquels rechercher la fonction _L()
	// On passe les arborescences une par une
	$fichiers = array();
	foreach($ou_fichier as $_arborescence) {
		if ($f = preg_files(_DIR_RACINE . $_arborescence, _LANGONET_PATTERN_FICHIERS_L))
			$fichiers[$_arborescence] = preg_files(_DIR_RACINE . $_arborescence, _LANGONET_PATTERN_FICHIERS_L);
	}

	// Chercher, pour chaque fichier collecté, le pattern de la fonction _L()
	if ($fichiers) {
		include_spip('inc/langonet_utils');

		$item_md5 = array();
		$fichier_non = array();
		$correction = array();
		$nb_occurrences = 0;
		foreach ($fichiers as $_arborescence => $_fichiers_arbo) {
			if ($_fichiers_arbo) {
				foreach ($_fichiers_arbo as $_fichier) {
					$contenu = file($_fichier);
					if ($contenu) {
						foreach ($contenu as $_no_ligne => $_ligne) {
							if (preg_match_all(_LANGONET_PATTERN_FONCTION_L, $_ligne, $matches, PREG_OFFSET_CAPTURE)) {
								foreach ($matches[2] as $_cle => $_occurrence) {
									// Calcul du nom du raccourci de l'item de langue
									$texte = $_occurrence[0];
									list($raccourci, $raccourci_brut) = langonet_calculer_raccourci($texte, $item_md5);
									// Stockage de ce raccourci et du texte exact contenu dans l'occurence _L()
									$item_md5[$raccourci] = $texte;
									// Ajout de l'occurrence trouvée dans la liste des erreurs
									$expression = $matches[0][$_cle][0];
									$colonne = $matches[0][$_cle][1];
									$fichier_non[$raccourci][$_fichier][$_no_ligne][$colonne] =
										array($expression, $raccourci_brut, $texte, $_ligne);
									// Insertion du raccourci dans la liste des corrections à introduire pour l'arborescence
									// en cours d'analyse
									if (!isset($correction[$raccourci]))
										$correction[$raccourci] = $_arborescence;
									// Compteur d'occurences
									$nb_occurrences++;
								}
							}
						}
					}
				}
			}
		}

		$resultats['ou_fichier'] = $ou_fichier;
		$resultats['item_non'] = array_keys($item_md5);
		$resultats['nb_occurrences'] = $nb_occurrences;
		$resultats['fichier_non'] = $fichier_non;
		$resultats['item_md5'] = $item_md5;
		$resultats['arborescence'] = $correction;
	}
	else {
		$resultats['erreur'] = _T('langonet:message_nok_arborescence_l');
	}

	return $resultats;
}
?>
