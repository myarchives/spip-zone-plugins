<?php
/*
 * forms
 * version plug-in de spip_form
 *
 * Auteur :
 * Antoine Pitrou
 * adaptation en 182e puis plugin par cedric.morin@yterium.com
 * � 2005,2006 - Distribue sous licence GNU/GPL
 *
 */

include_spip("base/forms");
include_spip("inc/forms");

//
// Formulaires
//


	// A reintegrer dans echapper_html()
	function Forms_forms_avant_propre($texte) {
		static $reset;
	//echo "forms_avant_propre::";
		// Mecanisme de mise a jour des liens
		$forms = array();
		$maj_liens = ($_GET['exec']=='articles' AND $id_article = intval($_GET['id_article']));
		if ($maj_liens) {
			if (!$reset) {
				$query = "DELETE FROM spip_forms_articles WHERE id_article=$id_article";
				spip_query($query);
				$reset = true;
			}
		}

		// Remplacer les raccourcis de type <formXXX|modificateur>
		// par le produit du squelette modele_form[_modificateur]
		if ((strpos($texte, '<form')!==NULL) &&
			preg_match_all(',<form([0-9]+)([|]([a-z_0-9]+))?'.'>,', $texte, $regs, PREG_SET_ORDER)) {
			foreach ($regs as $r) {
				$id_form = $r[1];
				$forms[$id_form] = $id_form;
				
				$fond = 'modele_form'.($r[3]?("_".$r[3]):'');
				include_spip('public/assembler');
				$contexte = array('id_form' => $id_form);
				$page = recuperer_fond($fond, $contexte);
				
				$texte = str_replace($r[0], code_echappement($page), $texte);
			}
		}
		if ($maj_liens && $forms) {
			$query = "INSERT INTO spip_forms_articles (id_article, id_form) ".
				"VALUES ($id_article, ".join("), ($id_article, ", $forms).")";
			spip_query($query);
		}
	
		return $texte;
	}

	// Hack crade a cause des limitations du compilateur
	function _Forms_afficher_reponses_sondage($id_form) {
		return Forms_afficher_reponses_sondage($id_form);
	}

	function Forms_affiche_droite($flux){
		if (_request('exec')=='articles_edit'){
			$flux['data'] .= Forms_afficher_insertion_formulaire($flux['arg']['id_article']);
		}
		return $flux;
	}
	function Forms_insert_head($flux){
		$flux .= 	"<link rel='stylesheet' href='".find_in_path('spip_forms.css')."' type='text/css' media='all' />\n";
		return $flux;
	}

?>