<?php
/**
 * Fonction d'upgrade/installation du plugin foundation-4-spip
 *
 * @plugin     foundation-4-spip
 * @copyright  2013
 * @author     Phenix
 * @licence    GNU/GPL
 */
if (!defined('_ECRIRE_INC_VERSION')) return;

/**
 * Rendre les iframes responsive via un filtre et la classe flex-video de Foundation.
 * @param  string $texte HTML pouvant contenir des iFrames
 * @return string        HTML avec les iFrames modifiée pour être responsive.
 */
function filtre_iframe_responsive($texte) {
  include_spip('inc/foundation');
  // On détecte tout les iFrames et on les rends responsives.
  return preg_replace_callback('/<iframe(.+)><\/iframe>/', 'responsive', $texte);
}

/*
*   Cette balise va permettre de rendre le squelette compatible avec toutes les versions de Foundation.
*   La syntaxe est la suivante:
*
*   #COLONNES{nombre,type}
*   nombre: le nombre de colonne foundation
*   (optionnel) type: Dans le cas des version utilisant une syntaxe avec prefix, on lui passe le type (défaut: large)
*/
function balise_COLONNES_dist($p) {
  // On récupère les paramètres de la balise.
  $nombre_colonnes = interprete_argument_balise(1, $p);
  $type = interprete_argument_balise(2, $p);

  // On met une valeur par défaut à type.
  if (!$type) $type = 'large';

  // On va cherche trouver_syntaxe_foundation dans le inc
  include_spip('inc/trouver_syntaxe_foundation');

  // On calcule la syntaxe
  $p->code = "trouver_syntaxe_foundation($nombre_colonnes, $type).' columns'";
  $p->interdire_scripts = false;
  return $p;
}

/**
 * Balise #ORBIT, un alias pour le modèle orbit.
 */
function balise_ORBIT_dist($p) {
  // On récupère les paramètres de la balise.
  $objet = interprete_argument_balise(1, $p);
  $id_objet = interprete_argument_balise(2, $p);
  $data_option = interprete_argument_balise(3, $p);
  $class = interprete_argument_balise(4, $p);

  // On appel le modèle orbit avec les paramètres de la balise.
  // Inspirer la la balise #LESAUTEURS
  $p->code = sprintf(CODE_RECUPERER_FOND, "'modeles/orbit'",
           "array(
                  'objet' => $objet,
                  'id_objet' => $id_objet,
                  'data-options' => $data_option,
                  'class' => $class
                  )",
           '',
           _q($connect));
  return $p;
}