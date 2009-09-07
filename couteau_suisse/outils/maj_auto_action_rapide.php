<?php

// module inclu dans la description de l'outil en page de configuration

if (!defined("_ECRIRE_INC_VERSION")) return; // securiser
include_spip('inc/actions');

define('_MAJ_SVN_DEBUT', 'svn://zone.spip.org/spip-zone/');
define('_MAJ_SVN_TRAC', 'svn://trac.rezo.net/spip-zone/');
define('_MAJ_LOG_DEBUT', 'http://zone.spip.org/trac/spip-zone/log/');
define('_MAJ_LOG_FIN', '?format=changelog');
define('_MAJ_ZIP', 'http://files.spip.org/spip-zone/');

function maj_auto_action_rapide() {
	include_spip('inc/plugin');
	$plugins = liste_plugin_files();
	$plugins_actifs = liste_chemin_plugin_actifs();
	$html_actifs = $html_inactifs = array();
	foreach ($plugins as $p) /*if(preg_match(',^auto/,', $p))*/ {
		$actif = array_search($p, $plugins_actifs, true);
		$auto = preg_match(',^auto/,', $p);
		$infos = plugin_get_infos_maj($p);
		$maj_lib = $checked = '';
		if($infos['maj_dispo']) { 
			$maj_lib = _T('couteau:maj_rev_ok', 
				array('revision' => $infos['rev_rss'], 'url'=>$infos['url_origine']));
			$checked = " class='maj_checked'"; }
		elseif($infos['rev_rss']>0 && $infos['rev_local'])
			$maj_lib = _T('couteau:maj'.($infos['svn']?'_svn':'_ok'),
				array('zip'=>$infos['zip_trac'], 'url'=>$infos['url_origine']));
		elseif($auto) {
			$maj_lib = _T('couteau:maj_rev_ko', array('url'=>$infos['url_origine']));
			$checked = " class='maj_checked'"; }
		elseif($infos['rev_local'] && $infos['rev_rss']<=0)
			$maj_lib = _T('couteau:maj_rev_ko', array('url'=>$infos['url_origine']));
		$nom = trim($infos['nom']). '&nbsp;(v' .$infos['version'] . ')' . ($maj_lib?"\n_ {{".$maj_lib.'}}':'');
		$rev = $infos['rev_local']?_T('couteau:maj_rev', array('revision' => $infos['rev_local'])):'';
		if(strlen($infos['commit'])) $rev .= (strlen($rev)?'<br/>':'') . cs_date_court($infos['commit']);
		if($infos['svn']) $rev .= '<br/>SVN';		
		if(!strlen($rev)) $rev = '&nbsp;';
		$zip_log = (strlen($infos['zip_log']) && $infos['zip_log']!=$infos['zip_trac'])
			?"<label><input type='radio' value='$infos[zip_log]'$checked name='url_zip_plugin'/>[->$infos[zip_log]]</label>":'';
		$bouton = $auto			
			?"<input type='radio' value='$infos[zip_trac]'$checked name='url_zip_plugin'/>"
			:'&nbsp;';
		if(strlen($zip_log)) {
			$nom .= "\n_ "._T('couteau:maj_verif') . "\n_ $zip_log\n_ {$bouton}[->$infos[zip_trac]]<label>";
			$bouton = '&nbsp;';
		}
		${$actif?'html_actifs':'html_inactifs'}[] = "|$bouton|$nom|$rev|";
	}

	$html1 = "\n<div style='padding:0.4em;' id='maj_auto_div'><fieldset><legend style='padding:0.4em;'>"
		. _T('couteau:maj_liste').'</legend>'
		. propre(
			(count($html_actifs)? "\n|{{" . _T('couteau:plug_actifs') . "}}|<|<|\n" . join("\n",$html_actifs) . "\n" : '')
			. (count($html_inactifs)? "\n|{{" . _T('couteau:plug_inactifs') . "}}|<|<|\n" . join("\n",$html_inactifs) . "\n" : '')
		  )
		. "<div style='text-align: right;'><input class='fondo' type='submit' value=\""
		. attribut_html(_T('couteau:maj_maj'))
		. '" /><p><i>'._T('couteau:maj_verif2').'</i></p></div></fieldset></div>'
		. http_script("
jQuery(document).ready(function() {
	jQuery('#maj_auto_div .maj_checked')[0].checked = true;
	if(!jQuery('#maj_auto_div :radio:checked').length)
		jQuery('#maj_auto_div :radio:first')[0].checked = true;
});");
	$html2 = "\n<div class='cs_sobre'><input class='cs_sobre' type='submit' value=\"["
		. attribut_html(_T('couteau:maj_actu'))	. ']" /></div>';

// premier formulaire non ajax, lancant directement charger_plugin
	return redirige_action_post('charger_plugin', '', 'admin_couteau_suisse', "cmd=descrip&outil=maj_auto#cs_infos", $html1)
// second formulaire ajax : lien d'actualisation forcee
		. ajax_action_auteur('action_rapide', 'maj_auto_forcer', 'admin_couteau_suisse', "arg=retour_normal&cmd=descrip&outil=maj_auto#cs_action_rapide", $html2);
}

// renvoie le pattern present dans la page distante
function maj_auto_rev_distante($url, $pattern, $lastmodified = 0, $force = false) {
	$force |= in_array(_request('var_mode'), array('calcul', 'recalcul'));

	// pour la version distante, on regarde toutes les 24h00 (meme en cas d'echec)
	$maj_ = isset($GLOBALS['meta']['tweaks_maj_auto'])?unserialize($GLOBALS['meta']['tweaks_maj_auto']):array();
	if(!isset($maj_[$url])) $maj_[$url] = array(0, false);
	$maj = &$maj_[$url];
	// prendre le cache si svn.revision n'est pas modifie recemment, si les 24h ne sont pas ecoulee, et si on ne force pas
	if (!$force && $maj[1]!==false && ($lastmodified<$maj[0]) && (time()-$maj[0] < 24*3600)) $distant = $maj[1];
	else {
		include_spip('inc/distant');
		$distant = recuperer_page($url);
		$distant = $maj[1] = $distant?(preg_match($pattern, $distant, $regs)?$regs[1]:'-2'):'-1';
		$maj[0] = time();
		ecrire_meta('tweaks_maj_auto', serialize($maj_));
		ecrire_metas();
	}
	return intval($distant);
}

function plugin_get_infos_maj($p, $force = false) {
	$infos = plugin_get_infos($p);
	$p2 = preg_match(',^auto/(.*)$,', $p, $regs)?$regs[1]:'';
	if(strlen($p2)) {
		// supposition du nom d'archive sur files.spip.org
		$infos['zip_trac'] = _MAJ_ZIP . $p2. '.zip';
		// nom de l'archive recemment installee par chargeur
		$ok = lire_fichier(sous_repertoire(_DIR_CACHE, 'chargeur').$p2.'/install.log', $log);
		$infos['zip_log'] = ($ok && preg_match(',[\n\r]source: *(.*)(?:[\n\r]|$),i', $log, $regs))
			?$regs[1]:'';
	} else $infos['zip_log'] = $infos['zip_trac'] = '';
	// fichier svn.revision
	$ok = lire_fichier($svn_rev = _DIR_PLUGINS.$p.'/svn.revision', $svn);
	$lastmodified = @file_exists($svn_rev)?@filemtime($svn_rev):0;
	$url_origine = ($ok && preg_match(',<origine>(.+)</origine>,', $svn, $regs))
		?str_replace(_MAJ_SVN_DEBUT, _MAJ_LOG_DEBUT, $regs[1]):'';
	$infos['commit'] = ($ok && preg_match(',<commit>(.+)</commit>,', $svn, $regs))?$regs[1]:'';
	$rev_local = (strlen($svn) && preg_match(',<revision>(.+)</revision>,', $svn, $regs))
		?intval($regs[1]):version_svn_courante(_DIR_PLUGINS.$p);
	if($infos['svn'] = $rev_local<0) { 
		// fichier SVN
		if (lire_fichier(_DIR_PLUGINS.$p.'/.svn/entries', $svn) && preg_match(',('.preg_quote(_MAJ_SVN_TRAC).'[^\n\r]*),ms', $svn, $regs))
			$url_origine = str_replace(_MAJ_SVN_TRAC, _MAJ_LOG_DEBUT, $regs[1]);
		$infos['zip_trac'] = 'SVN';
	}
	$infos['url_origine'] = strlen($url_origine)?$url_origine._MAJ_LOG_FIN:'';
	$infos['rev_local'] = abs($rev_local);
	$infos['rev_rss'] = maj_auto_rev_distante($infos['url_origine'], ', \[(\d+)\],', $lastmodified, $force);
	$infos['maj_dispo'] = $infos['rev_rss']>0 && $infos['rev_local']>0 && $infos['rev_rss']>$infos['rev_local'];
	return $infos;
}

?>