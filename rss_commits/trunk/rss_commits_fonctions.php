<?php
/**
 * Fonctions utiles au plugin Commits de projet
 *
 * @plugin     Commits de projet
 * @copyright  2014
 * @author     Teddy Payet
 * @licence    GNU/GPL
 * @package    SPIP\RSSCommits\Fonctions
 */

if (!defined('_ECRIRE_INC_VERSION')) {
    return;
}

include_spip('base/abstract_sql');

function lister_rss_commits ()
{
    $rss_items = array();
    $projet_rss = sql_allfetsel('versioning_rss,id_projet', 'spip_projets', "versioning_rss IS NOT NULL");

    $analyser_rss_commits = charger_fonction('analyser_rss_commits', 'inc');
    if (count($projet_rss) >0) {
        foreach ($projet_rss as $key_rss => $value_rss) {
            $contenu_rss = $analyser_rss_commits($value_rss["versioning_rss"]);
            if (count($contenu_rss) > 0) {
                foreach ($contenu_rss['channel']['item'] as $key => $value) {
                        $rss_items[$key]['titre'] = $value['title'];
                        $rss_items[$key]['descriptif'] = $value['description'];
                        $rss_items[$key]['texte'] = $value['texte'];
                        $rss_items[$key]['auteur'] = $value['author'];
                        $rss_items[$key]['url_revision'] = $value['link'];
                        $rss_items[$key]['guid'] = $value['guid'];
                        $rss_items[$key]['id_projet'] = $value_rss['id_projet'];
                        $rss_items[$key]['date_creation'] = strftime(
                            "%Y-%m-%d %H:%M:%S",
                            strtotime($value['pubDate'])
                        );
                }
                // echo "<pre>";
                // var_dump($rss_items);
                // echo "</pre>";
            }
        } // end foreach $projet_rss
    }

    return $rss_items;
}
?>