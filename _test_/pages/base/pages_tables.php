<?php
#---------------------------------------------------#
#  Plugin  : Pages                                  #
#  Auteur  : RastaPopoulos                          #
#  Licence : GPL                                    #
#--------------------------------------------------------------- -#
#  Documentation : http://www.spip-contrib.net/Plugin-Pages       #
#-----------------------------------------------------------------#

if (!defined("_ECRIRE_INC_VERSION")) return;

function pages_declarer_tables_principales($tables_principales){

	$tables_principales['spip_articles']['field']['page'] = 'varchar(20) not null';
	return $tables_principales;

}

?>
