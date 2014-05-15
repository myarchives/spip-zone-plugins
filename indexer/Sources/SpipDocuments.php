<?php

namespace Spip\Indexer\Sources;

use \Indexer\Sources\SourceInterface;

class SpipDocuments implements SourceInterface {

    /** SPIP récent ? spip_xx_liens ou spip_xx_yy */
    private $tables_liens = true;

    public function __construct() {}

    public function __toString() { return get_class($this); }

    public function getDocuments() {}

    public function getAllDocuments() {}

    /** @param bool $bool */
    public function setTablesLiens($bool) {
        $this->tables_liens = $bool;
    }


    public function getAuthorsProperties($objet, $id_objet) {
        if ($this->tables_liens) {
            $auteurs = sql_allfetsel('a.nom', 'spip_auteurs AS a, spip_auteurs_liens AS al', [
                "al.id_objet = " . intval($id_objet),
                "al.objet    = " . sql_quote($objet),
                "a.id_auteur = al.id_auteur",
            ]);
        } else {
            $auteurs = sql_allfetsel('a.nom', 'spip_auteurs AS a, spip_auteurs_articles AS al', [
                "al.id_article = " . intval($id_objet),
                "a.id_auteur = al.id_auteur",
            ]);
        }
        return array_map('array_shift', $auteurs);
    }


    public function getTagsProperties($objet, $id_objet) {
        if ($this->tables_liens) {
            $tags = sql_allfetsel('m.titre', 'spip_mots AS m, spip_mots_liens AS ml', [
                "ml.id_objet = " . intval($id_objet),
                "ml.objet    = " . sql_quote($objet),
                "m.id_mot = ml.id_mot",
            ]);
        } else {
            $tags = sql_allfetsel('m.titre', 'spip_mots AS m, spip_mots_articles AS ml', [
                "ml.id_article = " . intval($id_objet),
                "m.id_mot = ml.id_mot",
            ]);
        }
        return array_map('array_shift', $tags);
    }
}
