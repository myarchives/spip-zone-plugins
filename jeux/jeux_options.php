<?php
#---------------------------------------------------#
#  Plugin  : Jeux                                   #
#  Auteur  : Patrice Vanneufville, 2006             #
#  Gestion des scores : Maieul Rouquette, 2007      #
#  Contact : patrice�.!vanneufville�@!laposte�.!net #
#  Licence : GPL                                    #
#--------------------------------------------------------------------------#
#  Documentation : http://www.spip-contrib.net/Des-jeux-dans-vos-articles  #
#--------------------------------------------------------------------------#


include_spip('base/jeux_tables');
include_spip('inc/jeux_autoriser');

// Declaration du pipeline "jeux_caracteristiques" qui permet de declarer au plugin des jeux tierces
$GLOBALS['spip_pipeline']['jeux_caracteristiques']=''; 

?>