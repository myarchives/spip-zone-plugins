<?php

/*______________________________________________________________________________
 | Plugin SpipService 1.0 pour Spip 2.1                                           \
 | Copyright 2012 Sebastien Chandonay - Studio Lambda                            \
 |                                                                                |
 | SpipService est un logiciel libre : vous pouvez le redistribuer ou le          |
 | modifier selon les termes de la GNU General Public Licence tels que            |
 | publiés par la Free Software Foundation : à votre choix, soit la               |
 | version 3 de la licence, soit une version ultérieure quelle qu'elle            |
 | soit.                                                                          |
 |                                                                                |
 | SpipService est distribué dans l'espoir qu'il sera utile, mais SANS AUCUNE     |
 | GARANTIE ; sans même la garantie implicite de QUALITÉ MARCHANDE ou             |
 | D'ADÉQUATION À UNE UTILISATION PARTICULIÈRE. Pour plus de détails,             |
 | reportez-vous à la GNU General Public License.                                 |
 |                                                                                |
 | Vous devez avoir reçu une copie de la GNU General Public License               |
 | avec SpipService. Si ce n'est pas le cas, consultez                            |
 | <http://www.gnu.org/licenses/>                                                 |
 ________________________________________________________________________________*/ 

include_spip('inc/spip_service_core');
include_spip('inc/spip_service_utils');

function inc_spipservice_adddocumentarticle_dist($format, $service, $data){

	$id = (isset($data) && isset($data['id'])) ? $data['id'] : null;
	$filename = (isset($data) && isset($data['file_name'])) ? $data['file_name'] : null;
	$binaryBase64 = (isset($data) && isset($data['binary_base_64'])) ? $data['binary_base_64'] : null; // format binaire en base64

	return getBooleanResponse(addDocumentArticle($id, $filename, $binaryBase64));
}

?>