<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function selecteurgenerique_jqueryui_plugins($plugins){
	if (
		// Il ne faut pas avoir désactivé explicitement
		(!defined('DESACTIVER_SELECTEUR_GENERIQUE') or !DESACTIVER_SELECTEUR_GENERIQUE)
		and (
			// Soit être dans l'admin
			test_espace_prive()
			// Soit avoir activé explicitement pour le public
			or (defined('_SELECTEUR_GENERIQUE_ACTIVER_PUBLIC') and _SELECTEUR_GENERIQUE_ACTIVER_PUBLIC)
		)
	) {
		$plugins[] = 'jquery.ui.position';
		$plugins[] = 'jquery.ui.autocomplete';
		$plugins[] = 'autocomplete.html';
	}

	return $plugins;
}

function selecteurgenerique_inserer_auteur() {

	$ac = generer_url_ecrire('selecteur_generique');
	$id_article = _request('id_article');
	$statut = _request('statut');
	$input = 'input[name=cherche_auteur][autocomplete!=off]';

	return <<<EOS

(function($) {
	var appliquer_selecteur_cherche_auteur = function() {
		// chercher l'input de saisie
		var me = jQuery('$input');
		me.autocomplete(
			{
				source: function( request, response ) {
					$.ajax({
						url: "$ac",
						data:{quoi:'auteur',id_article:'$id_article',statut:'$statut',q:request.term},
						success: function(data) {
							datas = selecteur_format(data);
							response( $.map( datas, function( item ) {
								return item;
							}));
						}
					});
				},
				delay: 300,
				html: true,
				select: function( event, ui ) {
					if (ui.item.result > 0) {
						me.attr('name', 'old_value')
							.parents('form')
							.append(
								jQuery("<input type='hidden' name='nouv_auteur' value='"+ui.item.result+"' />" // signature SPIP 1.9
								+"<input type='hidden' name='auteur_article_${id_article}_new' value='"+ui.item.result+"' />"  // signature SPIP 2.0
								)
							)
							.find("input[type=submit]")
								.click()
							.end();
					}
					return false;
				}
			}
		);
	};
	$(function(){
		appliquer_selecteur_cherche_auteur();
		onAjaxLoad(appliquer_selecteur_cherche_auteur);
	});
})(jQuery);
EOS;

}

function selecteurgenerique_inserer_mot() {
	if ($id = _request('id_article')) {
		$type = 'id_article';
	} elseif ($id = _request('id_rubrique')) {
		$type = 'id_rubrique';
	} elseif ($id = _request('id_syndic')) {
		$type = 'id_syndic';
	} else {
		$id = _request('id_breve');
		$type = 'id_breve';
	}

	$ac = generer_url_ecrire('selecteur_generique');
	return <<<EOS

(function($) {
	var appliquer_selecteur_cherche_mot = function() {
		// chercher l'input de saisie
		var groupes = new Array;
		var groupes_titre = new Array;
		var hide=false;
		$('input[name=cherche_mot][autocomplete!=off]')
		.each(function(){
			var id_groupe = $(this).parents('form').find('input[name=select_groupe]').val();
			groupes.push(id_groupe);
			groupes_titre.push($(this).val());
			if (hide)
				$(this).parent().hide();
			hide=true;
		});
		hide=false;
		$('input[name=cherche_mot][autocomplete!=off]:first')
		.each(function(){
			var inp = this;
			$(this)
			.val(groupes_titre.join(', '))
			.attr('title',groupes_titre.join(', '));
			$(this)
			.parents('form')
			.bind('submit', function(){
				$('.ac_results').remove();
			})
			.find('input[name=select_groupe]')
			.val(groupes.join(','));
			$(inp).autocomplete(
				{
					source: function( request, response ) {
						$.ajax({
							url: "$ac",
							data:{quoi:'mot',$type:'$id',groupes: groupes.join(','),q:request.term},
							success: function(data) {
								datas = selecteur_format(data);
								response( $.map( datas, function( item ) {
									return item;
								}));
							}
						});
					},
					html: true,
					select:function( event, ui ) {
						if (ui.item.result > 0) {
							$(inp)
								.attr('name', 'old_value')
								.parents('form')
								.append(
									$("<input type='hidden' name='nouv_mot' value='"+ui.item.result+"' />")
								).find('input[type=submit]')
								.click()
								.end();
						}else{
							return ui.item.entry;
						}
						return false;
					}
				}
			);
		});
	};
	$(function(){
		appliquer_selecteur_cherche_mot();
		onAjaxLoad(appliquer_selecteur_cherche_mot);
	});
})(jQuery);
EOS;

}

function selecteurgenerique_inserer_rubrique() {

	$ac = parametre_url(generer_url_ecrire('selecteur_generique',
		'quoi=rubrique'),
		'id_article', _request('id_article'), '\\x26');
	$ac = generer_url_ecrire('selecteur_generique');

	return <<<EOS
(function($) {
	var appliquer_selecteur_cherche_rubrique = function() {

		// chercher l'input de saisie
		var me = jQuery('input[id=titreparent]');
		me.each(function(){
			var inp = this;
			var id_groupe = jQuery(this).parents('form').find('input[name=select_groupe]').val();

			jQuery(inp).focus(function(){
				$(this).val('');
			});
			jQuery(inp).attr('disabled','').autocomplete(
				{
					source: function( request, response ) {
						$.ajax({
							url: "$ac",
							data:{quoi:'rubrique',q:request.term},
							success: function(data) {
								datas = selecteur_format(data);
								response(
									datas
								);
							}
						});
					},
					delay: 300,
					html: true,
					select:function( event, ui ) {
						if (ui.item.result > 0) {
							jQuery(inp)
								.val(ui.item.entry)
								.parents('form').find('input[id=id_parent]')
								.val(ui.item.result)
								.end();
						}else{
							return ui.item.entry;
						}
						return false;
					}
				}
			);
		});
	};
	$(function(){
		appliquer_selecteur_cherche_rubrique();
		onAjaxLoad(appliquer_selecteur_cherche_rubrique);
	});
})(jQuery);
EOS;
}

// Calcule et insere le javascript necessaire pour la page
function selecteurgenerique_inserer_javascript($flux) {
	if (
		(defined('DESACTIVER_SELECTEUR_GENERIQUE') and DESACTIVER_SELECTEUR_GENERIQUE)
		or
		(
			!test_espace_prive()
			and (!defined('_SELECTEUR_GENERIQUE_ACTIVER_PUBLIC') or !_SELECTEUR_GENERIQUE_ACTIVER_PUBLIC)
		)
	) {
		return $flux;
	}

	$js = '';
	$js_final = "\n".'<script type="text/javascript">var selecteurgenerique_test_espace_prive = '.(test_espace_prive() ? 'true':'false').';</script>';

	if (_request('exec') == 'articles'
	OR _request('exec') == 'acces_restreint_edit') {
		$js .= selecteurgenerique_inserer_auteur();
	}

	if (_request('exec') == 'articles'
	OR _request('exec') == 'naviguer'
	OR _request('exec') == 'breves_voir'
	OR _request('exec') == 'sites') {
		$js .= selecteurgenerique_inserer_mot();
	}
	if (_request('exec') == 'articles_edit'
	OR _request('exec') == 'rubriques_edit') {
		$js .= selecteurgenerique_inserer_rubrique();
	}
	/**
	 * jquery.ui.autocomplete.html
	 * Ajoute la prise en compte de code html dans le sélecteur et l'interprète
	 * Par exemple des images / icones
	 */
	if(strpos($flux,'autocomplete.html')===FALSE){
		$autocompleter_html = find_in_path('javascript/ui/autocomplete.html.js');
		$js_final .= $autocompleter_html ? "
<script type='text/javascript' src='$autocompleter_html'></script>
" : '';
	}
	/**
	 * On insére les fonctions génériques de l'autocomplétion (attribut data-selecteur)
	 */
	if(strpos($flux, 'selecteur_generique_functions') === FALSE){
		$functions = find_in_path('javascript/selecteur_generique_functions.js');
		$js_final .= "\n<script type='text/javascript' src='$functions'></script>\n";
	};

	/**
	 * On compléte selon le contexte de l'espace privé
        */
	if ($js) {
	    $js_final .= '<script type="text/javascript"><!--'
	    . "\n"
	    . $js
	    . "\n"
	    . '// --></script>'
	    . "\n";
	}

	return $flux.$js_final;
}
