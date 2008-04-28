<?php

# securite
if (!defined("_ECRIRE_INC_VERSION")) return;

/*! \file abstract_arbre.php
 *  \brief Abstraction pour manipuler des tables en tant qu'arbres  intervallaire
 *
 *  Il est possible de :
 *      -* créer une table de type autojointure en table intervallaire
 *      -* de rechercher des feuilles et noeud
 *  
 *  Convention de nommage :
 *      feuille :   element pour le quel bord_droit - bord_gauche = 1
 *      noeud :     element contenant des feuilles ou bien bord_droit - bord_gauche > 1
 *      racine :    element n'ayant pas de parent    
 *      element : n'importe quel enregistrement (feuille ou noeud)
 */
 
 
 
/*! \brief Convertir une table de type autojointure en intervallaire
 *
 *  Formate la table donnée en argument en ajoutant les champs requis et parcours l'arbre afin de le remplir correctement
 *  Il n'y a pas de notion d'ordre dans une fratrie, les noeuds sont remplis dans l'ordre de lecture de la base
 *
 *  \param $table table à convertir, nom de table complet
 *  \param $champ_noeud nom du champ contenant l'index de table en général id_objet
 *  \param $champ_parent nom du champ contenant l'index de l'element parent
 *
 *  \return booleen retourne un controle sur le nombre d'elements traités
 */
function sql_arbre_convertir($table, $id_noeud, $champs = array()) {

    // test la presence des noms des champs
    if(!isset($champs['noeud']) || !isset($champs['parent']) ) {
        return false;
    }
    
    //création des champs necessaires
    sql_alter('TABLE '.$table.' ADD bord_gauche INT');
    sql_alter('TABLE '.$table.' ADD bord_droit INT');
        
    //formatage intervallaire
    $bord_gauche = sql_arbre_convertir_noeud(1,$id_noeud,$table,$champs);

    //controle la conversion
    //bord_gauche = 2 * nb d'element dans la table + 1
    $nb_element = sql_countsel(
        $table
    );
    
    if ($nb_element * 2 == $bord_gauche - 1) {
        return true;
    } else {
        return false;
    }
}




/*! \brief Defini les bords d'un noeud et de sa descendance
 *
 *
 *  \param $bord_gauche valeur du premier bord gauche à donner
 *  \param $id_noeud identifiant du noeud à traiter
 *  \param $table
 *  \param $champ_noeud
 *  \param $champ_parent
 *
 *  \return int retourne la valeur du prochain bord gauche à donner, pour le noeud frere par exemple
 */
function sql_arbre_convertir_noeud($bord_gauche,$id_noeud,$table,$champs = array()) {
    
    //on sauve le bord gauche du noeud en cours
    $bord_gauche_noeud = $bord_gauche;
    
    //le prochain bord gauche 
    $bord_gauche ++;

    //recherche des enfants immédiats
    $ressource = sql_select(
        $champs['noeud'],
        $table,
        $champs['parent']." = ".$id_noeud
    );
      
    //parcours les enfants
    while($fils = sql_fetch($ressource)) {
        $id_fils = $fils[$champs['noeud']];
        $bord_gauche = sql_arbre_convertir_noeud($bord_gauche,$id_fils,$table,$champs);
    }
    
    //insert les bordures du du noeud
    sql_updateq(
        $table,
        array(
            'bord_gauche' => $bord_gauche_noeud,
            'bord_droit' => $bord_gauche
        ),
        $champs['noeud']." = ".$id_noeud
    );
    
    //le prochain bord_gauche
    $bord_gauche ++;
    
    return $bord_gauche;
}
/*
function sql_select (
	$select = array(), $from = array(), $where = array(),
	$groupby = array(), $orderby = array(), $limit = '', $having = array(),
	$serveur='', $option=true) {
*/

/*! \brief Obtenir toutes les feuilles
 *
 *  Retourne une ressource qui contient tous les elements finaux d'un arbre
 *
 *  \param $from table à traiter
 *  \param $serveur serveur sollicité
 *  \param $option peut avoir 3 valeurs 
 *      - true -> executer la requete, 
 *      - false -> ne pas l'executer mais la retourner, 
 *      - 'continue' -> ne pas echouer en cas de serveur sql indisponible
 *
 *  \return ressource une ressource à traiter par un sql_fetch
 */
function sql_arbre_get_feuilles($table ='', $serveur='', $option=true) {

    return sql_select(
        "*",
        $table,
        "bord_droit - bord_gauche = 1",
        '',
        '',
        '',
        '',
        $serveur,
        $option        
    );
}


/*! \brief Inserer une feuille
 *
 *  Fait un sql_insertq dans l'abre
 *
 *  \param $parent : tableau de clefs id (id du parent)et champ (nom du champ de la clef)
 *  \param $bord : droit ou gauche indique le coté d'insertion, droit par defaut
 *  \param $table table à traiter
 *  \param $serveur serveur sollicité
 *  \param $option peut avoir 3 valeurs 
 *      - true -> executer la requete, 
 *      - false -> ne pas l'executer mais la retourner, 
 *      - 'continue' -> ne pas echouer en cas de serveur sql indisponible
 *
 *  \return ressource une ressource à traiter par un sql_fetch
 */
function sql_arbre_set_feuille($table ='',$parent = array(),$bord = 'droit', $couples= array(),  $serveur='', $option=true) {

    //recherche les bords du parent
    $bordures = sql_arbre_get_bord($table,$parent,$bord,$couples,$serveur,$option);

    //si bordure droite, alors le bord droit du parent devient le bord gauche de l'enfant
    if ($bord=='aine' || $bord=='droit') {
        $bordure = $bordures['bord_droit'];
    }

    //si bordure gauche, alors le bord gauche suit le bord gauche du parent
    if ($bord=='cadet' || $bord=='gauche') {
        $bordure = $bordures['bord_gauche'] + 1;
    }


    //mise à jour bord droit
    $toto = sql_update(
        $table,
        array(
            'bord_droit' => 'bord_droit + 2'
        ),
        "bord_droit >= ".$bordure,
        '',
        $serveur
    );

    print_r($toto."-droit".$bordure);

    //mise à jour gauche
    $toto = sql_update(
        $table,
        array(
            'bord_gauche' => 'bord_gauche + 2'
        ),
        "bord_gauche >= ".$bordure,
        '',
        $serveur
    );
    
    print_r($toto."-gauche".$bordure);
    
    //defini les bordures de l'element à inserer
    $bords = array(
        'bord_gauche' => $bordure,
        'bord_droit' => $bordure +1 
    );
    
    $couples = array_merge($couples,$bords);
    
    return sql_insertq(
        $table,
        $couples,
        '',
        $serveur
    );

}

function sql_arbre_get_bord($table ='',$element = array(),$bord = 'droit', $couples= array(),  $serveur='', $option=true) {

    //recherche les bords de l'element
    return sql_fetsel(
        array(
            'bord_gauche',
            'bord_droit'
        ),
        $table,
        $element['champ'].'='.$element['id'],
        '',
        '',
        '',
        '',
        $serveur
    );


}

function sql_arbre_delete_feuille($table ='',$feuille = array(),$bord = 'droit', $couples= array(),  $serveur='', $option=true) {



}

?>
