<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_liste_fonctions_completes_charger_dist () {

    $valeurs = array();
    $valeurs['prefixe'] = (_request('prefixe')) ? _request('prefixe') : '' ;

    return $valeurs;
}

function formulaires_liste_fonctions_completes_verifier_dist () {

    $erreurs = array();
    return $erreurs;
}

function formulaires_liste_fonctions_completes_traiter_dist () {

    $res = array();
    return $res;
}

?>