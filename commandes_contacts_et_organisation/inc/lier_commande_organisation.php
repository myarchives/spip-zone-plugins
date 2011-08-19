<?php

if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('base/abstract_sql');

    function inc_lier_commande_organisation_dist($id_commande,$id_organisation) {

        if (intval($id_commande) && intval($id_organisation)) {
            //La commande est elle deja effectée ?
            $res = sql_getfetsel(
                'id_organisation',
                'spip_organisations_liens',
                'id_objet = '.$id_commande.' AND objet = "commande"'
            );

            if ($res) {
                $res = sql_updateq(
                    'spip_organisations_liens',
                    array(
                        'id_organisation' => $id_organisation,
                        'objet' => 'commande',
                        'id_objet' => $id_commande
                    ),
                    'id_objet = '.$id_commande.' AND objet = "commande"'
                );
            } else {
                $res = sql_insertq(
                    'spip_organisations_liens',
                    array(
                        'id_organisation' => $id_organisation,
                        'objet' => 'commande',
                        'id_objet' => $id_commande
                    )
                );
            }
        }
    }

?>
