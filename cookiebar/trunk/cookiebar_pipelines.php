<?php

/**
 * Plugin Cookie bar pour Spip 3.0.
 */
if (!defined('_ECRIRE_INC_VERSION')) {
    return;
}

/**
 * Inserer la CSS de cookie bar.
 *
 * @param $flux
 *
 * @return mixed
 */
function cookiebar_insert_head_css($flux)
{
    if (defined('_COOKIEBAR_CSS_NON')) {
        return $flux;
    }

    $flux .= '<link rel="stylesheet" type="text/css" href="'.find_in_path('css/jquery.cookiebar.css').'" />';

    return $flux;
}

/**
 * Inserer le javascript de cookiebar.
 *
 * @param $flux
 *
 * @return mixed
 */
function cookiebar_insert_head($flux)
{
    //$js_cookiebar = parametre_url(generer_url_public('jquery.cookiebar.js'), 'lang', $lang);
    include_spip('inc/filtres');
    if (!$lang) {
        $lang = (isset($GLOBALS['spip_lang']) ? $GLOBALS['spip_lang'] : 'fr');
    }
    $js_cookiebar = produire_fond_statique('jquery.cookiebar.js', array('lang' => $lang));

    $flux .= "<script type='text/javascript' src='$js_cookiebar'></script>\n"
    ."<script type='text/javascript' src='".find_in_path('js/jquery.cookiebar.call.js')."'></script>";

    return $flux;
}
