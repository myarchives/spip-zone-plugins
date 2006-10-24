<?php

/*
 * revision_nbsp
 *
 * Dans l'espace prive, souligne en grise les espaces insecables
 *
 * Auteur : fil@rezo.net
 * � 2005-2006 - Distribue sous licence GNU/GPL
 *
 * l'icone <edit-find-replace.png> est tiree de Tango Desktop Project
 * http://tango.freedesktop.org/Tango_Desktop_Project -- sous licence
 * http://creativecommons.org/licenses/by-sa/2.5/
 *
 */


	function RevisionNbsp_revision_nbsp($letexte) {
		if (!_DIR_RESTREINT) {
			$letexte = echappe_html($letexte, '', true, ',(<img[^<]*>),Ums');
			return str_replace('&nbsp;',
				'<span class="spip-nbsp">&nbsp;</span>', $letexte);
		} else
			return $letexte;
	}

	function RevisionNbsp_ajoute_bouton_corriger_les_notes($x) {
		if ($GLOBALS['auteur_session']['statut'] == '0minirezo')
		if ($x['args']['exec'] == 'articles') {
			$id_article = intval($x['args']['id_article']);
			$t = spip_fetch_array(spip_query("SELECT texte FROM spip_articles WHERE id_article=$id_article"));
			if ($c = notes_automatiques($t['texte'])) {
				$x['data'] .= "<br />\n"
				.debut_boite_info(true)
				.icone_horizontale(
					'Transformer les notes de cet article.',
					generer_url_action('corriger_notes', 'id_article='.$id_article),
						"../../plugins/revision_nbsp/edit-find-replace.png",  # grml!!
						"rien.gif", false)
				.fin_boite_info(true);
			}
#			else $x['data'] .= "<div>pas de notes a corriger</div>";
		}
		return $x;
	}


	function notes_automatiques($texte) {

		// Attrapper les notes
		$regexp = ', *\[\[(.*?)\]\],msS';
		if ($s = preg_match_all($regexp, $texte, $matches, PREG_SET_ORDER)
		AND $s==1
		AND preg_match(",^ *<>(.*),s", $matches[0][1], $r)) {
			$lesnotes = $r[1];
			$letexte = trim(str_replace($matches[0][0], '', $texte));

			$num = 0;
			while (($a = strpos($lesnotes, '('.(++$num).')')) !== false
			AND ($b = strpos($letexte, '('.($num).')')) !== false
			) {
				if (!isset($debut))
					$debut = trim(substr($lesnotes, 0, $a));

				$lanote = substr($lesnotes,$a+strlen('('.$num.')'));

				$lanote = preg_replace(
				',[(]'.($num+1).'[)].*,s', '',$lanote
				);

				$lanote = trim($lanote);
				$lanote = (strlen($lanote) ? '[[ '.$lanote.' ]]' : '');

				$letexte = substr($letexte,0,$b)
					. $lanote
					. substr($letexte,$b+strlen('('.$num.')'));
			}

			$suite = trim(substr($lesnotes,$a));
			if (strlen($suite))
				$letexte.= '[[<> '.$suite.' ]]';

			if (isset($debut)) {
				return (strlen($debut)?"\n\n[[<>$debut ]]":'') . $letexte;
			}
		}
	}

?>