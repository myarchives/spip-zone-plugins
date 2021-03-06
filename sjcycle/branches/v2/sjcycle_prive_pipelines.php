<?php
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function sjcycle_affiche_gauche($flux) {
	if ($flux['args']['exec'] == 'article_edit'
		and isset($flux['args']['id_article'])
		and (intval($flux['args']['id_article']) > 0)) {
		include_spip('inc/documents');
		include_spip('inc/config');
		$conf_jcycle = lire_config('sjcycle');
		if ($conf_jcycle['afficher_aide']) {
			$document='';
			$document = sql_countsel('spip_documents as docs JOIN spip_documents_liens AS lien ON docs.id_document=lien.id_document', '(lien.id_objet='.$flux['args']['id_article'].') AND (lien.objet="article") AND (docs.extension REGEXP "jpg|png|gif")');
			if ($document >= 2) {
				$flux['data'] .= recuperer_fond('prive/navigation/bloc_aide', array('id_article' => $flux['args']['id_article']));
			}
		}
	}
	return $flux;
}
