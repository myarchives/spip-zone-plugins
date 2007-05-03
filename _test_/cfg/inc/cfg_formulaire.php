<?php
/*
 * Plugin cfg : la classe fabricant le formulaire
 *
 * Auteur : bertrand@toggg.com
 * � 2007 - Distribue sous licence LGPL
 *
 */

// la classe cfg represente une page de configuration
class cfg_formulaire
{
// le storage, par defaut metapack: spip_meta serialise
	var $storage = 'metapack';
// l'objet de classe cfg_<storage> qui assure lecture/ecriture des config
	var $sto = null;
// les options de creation de cet objet
	var $optsto = array();
// le "faire" de autoriser($faire), par defaut, autoriser_defaut_dist(): que les admins complets
	var $autoriser = 'defaut';
// le nom du meta (ou autre) ou va etre stocke la config concernee
	var $nom = '';
// le fond html utilise , en general pour config simple idem $nom
	var $vue = '';
// pour une config multiple , l'id courant
	var $cfg_id = '';
// sous tableau optionel du meta ou va etre stocke le fragment de config
// vide = a la "racine" du meta nomme $nom
	var $casier = '';
// descriptif
	var $descriptif = '';
// compte-rendu des mises a jour, vide == pas d'erreur
	var $message = '';
// liens optionnels sur des sous-config [(#REM) liens*=xxx]
	var $liens = array();
// les champs trouve dans le fond
	var $champs = array();
// les champs index
	var $champs_id = array();
// leurs valeurs
	var $val = array();
// pour tracer les valeurs modifiees
	var $log_modif = '';
	
	function cfg_formulaire($nom, $vue = '', $cfg_id = '', $opt = array())
	{
		$this->nom = $nom;
		$this->base_url = generer_url_ecrire('');
		foreach ($opt as $o=>$v) {
			$this->$o = $v;
		}

		// pre-analyser le formulaire
		if ($vue) {
			$this->message .= $this->set_vue($vue);
		}
		
		if (_request('_cfg_affiche')) {
			$this->cfg_id = $sep = '';
			foreach ($this->champs_id as $name) {
				$this->cfg_id .= $sep . _request($name);
				$sep = '/';
		    }
	    } else {
			$this->cfg_id = $cfg_id;
	    }
		
		// creer le storage et lire les valeurs
		$classto = 'cfg_' . $this->storage;
		include_spip('inc/' . $classto);
		$this->sto = new $classto($this, $this->optsto);
		$this->val = $this->sto->lire();
	}

	function nom_config()
	{
	    return $this->nom . ($this->casier ? '/' . $this->casier : '') .
	    		($this->cfg_id ? '/' . $this->cfg_id : '');
	}

	function set_vue($vue)
	{
		$this->vue = $vue;
		$fichier = find_in_path($nom = 'fonds/cfg_' . $this->vue .'.html');
		if (!lire_fichier($fichier, $this->controldata)) {
			return _L('erreur_lecture_') . $nom;
		}
		$sans_rem = preg_replace_callback('/(\[\(#REM\) (\w+)(\*)?=)(.*?)\]/sim',
						array($this, 'post_params'), $this->controldata);
		if (!preg_match_all(
		  '#<(?:(select|textarea)|input type="(text|password|checkbox|radio)") name="(\w+)(\[\])?"(?: class="[^"]*?(?:type_(\w+))?[^"]*?(?:cfg_(\w+))?[^"]*?")?( multiple=)?[^>]*?>#ims',
						$sans_rem, $matches, PREG_SET_ORDER)) {
			return _L('pas_de_champs_dans_') . $nom;
		}
		foreach ($matches as $regs) {
			if (substr($regs[3], 0, 5) == '_cfg_') {
				continue;
			}
		    if (!empty($regs[1])) {
		    	$regs[2] = strtolower($regs[1]);
			    if ($regs[2] == 'select' && !empty($regs[7])) {
			    	$regs[2] = 'selmul';
			    }
		    }
		    $this->champs[$regs[3]] =
		    	array('inp' => $regs[2], 'typ' => '', 'array' => !empty($regs[4]));
		    if (!empty($regs[5])) {
		    	$this->champs[$regs[3]]['typ'] = $regs[5];
		    }
		    if (!empty($regs[6])) {
		    	$this->champs[$regs[3]]['cfg'] = $regs[6];
		    	if ($regs[6] == 'id') {
			    	$this->champs[$regs[3]]['id'] = count($this->champs_id);
		    		$this->champs_id[] = $regs[3];
		    	}
		    }
	    }
	    return '';
	}

	function autoriser()
	{
		return autoriser($this->autoriser);
	}

	function log($message)
	{
		($GLOBALS['auteur_session'] && ($qui = $GLOBALS['auteur_session']['login']))
		|| ($qui = $GLOBALS['ip']);
		spip_log('cfg (' . $this->nom_config() . ') par ' . $qui . ': ' . $message);
	}

	function modifier($supprimer = false)
	{
		if ($supprimer) {
			$this->sto->modifier($supprimer);
			$this->message .= ($msg = _L('config_supprimee')) . ' <b>' . $this->nom_config() . '</b>';
			$this->log($msg);
			return;
		}
		if (($this->message = $this->controle())) {
			return;
		}
		if (!$this->log_modif) {
			$this->message .= _L('pas_de_changement') . ' <b>' . $this->nom_config() . '</b>';
			return;
		}
		$this->sto->modifier();
		$this->message .= ($msg = _L('config_enregistree')) . ' <b>' . $this->nom_config() . '</b>';
		$this->log($msg . ' ' . $this->log_modif);
	}

	function traiter()
	{
		$enregistrer = $supprimer = false;
		if ($this->message ||
			! (($enregistrer = _request('_cfg_ok')) ||
							($supprimer = _request('_cfg_delete')))) {
			return;
		}

		$securiser_action = charger_fonction('securiser_action', 'inc');
		$securiser_action();
		if ($supprimer) {
			$this->modifier('supprimer');
		} elseif (!($this->message = $this->controle())) {
			if ($this->new_id != $this->cfg_id && !_request('_cfg_copier')) {
				$this->modifier('supprimer');
			}
			$this->cfg_id = $this->new_id;
			$this->modifier();
		}
//		$this->message .= print_r($this->champs, true);
	}

	function controle()
	{
		$chk = array(
		  'id' => array('#^[a-z_]\w*$#i', _L('lettre ou &#095; suivie de lettres, chiffres ou &#095;')),
		  'idnum' => array('#^\d+$#', _L('chiffres')),
		  'pwd' => array('#^\w+$#',  _L('lettres, &#095; ou chiffres')));
	    $return = '';
		foreach ($this->champs as $name => $def) {
			$oldval = $this->val[$name];
		    $this->val[$name] = _request($name);
		    if ($oldval != $this->val[$name]) {
		    	$this->log_modif .= $name . ':' .
		    		var_export($oldval, true) . '/' . var_export($this->val[$name], true) .', ';
		    }
		    if (!empty($def['typ']) && isset($chk[$def['typ']])) {
		    	if (!preg_match($chk[$def['typ']][0], $this->val[$name])) {
		    		$return .= _L($name) . '&nbsp;:<br />' .
		    		  $chk[$def['typ']][1] . '<br />';
		    	}
		    }
	    }
		$this->new_id = '';
		$sep = '';
		foreach ($this->champs_id as $name) {
			$this->new_id .= $sep . $this->val[$name];
			$sep = '/';
	    }
	    return $return;
	}

	/*
	 Fabriquer les balises des champs d'apres un modele fonds/cfg_<driver>.html
		$contexte est un tableau (nom=>valeur)
		qui sera enrichi puis passe � recuperer_fond
	*/
	function formulaire($contexte = array())
	{
		include_spip('inc/securiser_action');
	    $arg = 'cfg0.0.0-' . $this->nom . '-' . $this->vue;
		$contexte['_cfg_'] =
			'?exec=cfg&cfg=' . $this->nom .
			'&vue=' . $this->vue .
			'&cfg_id=' . $this->cfg_id .
			'&base_url=' . $this->base_url .
		    '&lang=' . $GLOBALS['spip_lang'] .
		    '&arg=' . $arg .
		    '&hash=' .  calculer_action_auteur('-' . $arg);
	    include_spip('public/assembler');
	    $return = recuperer_fond('fonds/cfg_' . $this->vue,
	    		$this->val ? array_merge($contexte, $this->val) : $contexte);

		// liste des post-proprietes de l'objet cfg, lues apres recuperer_fond()
		$this->rempar = array(array());
		if (preg_match_all('/<!-- \w+\*?=/', $this->controldata, $this->rempar)) {
			$return = preg_replace_callback('/(<!-- (\w+)(\*)?=)(.*?)-->/sim',
								array($this, 'post_params'), $return);
		}
		if (!empty($this->rempar[0])) {
			die("erreur manque parametre externe");
		}
		return $return;
	}
	// callback pour interpreter les parametres objets du formulaire
	// commun avec celui de set_vue()
	function post_params($regs) {
		// a priori, eviter l'injection du motif
		if (isset($this->rempar) && $regs[1] != array_shift($this->rempar[0])) {
			die("erreur parametre interne: " . htmlentities($regs[1]));
		}
		if (empty($regs[3])) {
		    $this->{$regs[2]} = $regs[4];
		} elseif (is_array($this->{$regs[2]})) {
		    $this->{$regs[2]}[] = $regs[4];
		}
		// plus besoin de garder ca
		return '';
	}
}
?>
