<?php
function boucle_FLICKR_TAGS_GETHOTLIST_dist($id_boucle,&$boucles) {
  include_spip('inc/FpipR_boucle_utils');
  $boucle = &$boucles[$id_boucle];
  $id_table = $boucle->id_table;
  $boucle->from[$id_table] =  "spip_fpipr_tags";
 
  $arguments = '';
 
  if($boucle->limit) {
	list($debut,$pas) = split(',',$boucle->limit);
	$arguments['count'] = $pas;
  }

  FpipR_utils_search_criteres($boucle,$arguments,array('period'),$boucles,$id_boucle);

  $boucle->hash = FpipR_utils_calculer_hash('flickr.tags.getHotList',$arguments,$boucle);
  return calculer_boucle($id_boucle, $boucles); 
  }
?>
