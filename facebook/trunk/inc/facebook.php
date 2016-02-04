<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

include_spip('lib/facebook-php-sdk/src/Facebook/autoload');
include_spip('inc/facebook_poster');
// Le SDK de Facebook utilise des sessions PHP,
// Cependant, il n'est pas foutu de faire lui même ce test.
if (!session_id()) {
    session_start();
}

/**
 * Initialiser Facebook avec la configuration stockée dans SPIP
 *
 * @access public
 * @return object L'objet Facebook crée
 */
function facebook() {

	include_spip('inc/config');
	$config = lire_config('facebook');

	$fb = new Facebook\Facebook([
		'app_id' => $config['cle'],
		'app_secret' => $config['secret'],
		'default_graph_version' => 'v2.2'
	]);

	return $fb;
}


/**
 * Obtenir un lien de connection Facebook
 *
 * @access public
 * @return string Lien vers Facebook
 */
function facebook_lien_connection() {

	include_spip('inc/config');
	$config = lire_config('facebook');

	// Si facebook n'est pas configurer, on n'affiche pas de lien
	if (empty($config['cle']) or empty($config['secret'])) {
		return false;
	}

	$fb = facebook();

	$helper = $fb->getRedirectLoginHelper();

	$permission = explode(',', _FACEBOOK_PERMISSION);

	$url = generer_action_auteur('facebook_access_token', 'ok', self(), true);

	$loginUrl = $helper->getLoginUrl($url, $permission);

	// Dans le cas ou il y a déjà un compte facebook connecté, on le signale
	if (!empty($config['accessToken'])) {
		$user = facebook_profil();

		if (!is_string($user)) {
			$compte_connecte = _T('facebook:compte_connecte', array('compte' => $user['nom']));
		}
	}

	return '<a href="'.htmlspecialchars($loginUrl).'">Log in with Facebook !</a> '.$compte_connecte;
}

/**
 * On récupère le token d'accès et on le stocke dans le config SPIP
 *
 * @access public
 * @return string Un message d'erreur au besoin
 */
function facebook_access_token() {

	// S'il n'y a pas de code, pas besoin de chercher un token
	if (!_request('code')) {
		return false;
	}

	$fb = facebook();

	include_spip('inc/config');
	$config = lire_config('facebook');

	$helper = $fb->getRedirectLoginHelper();

	try {
		$accessToken = $helper->getAccessToken();
	} catch (Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		return 'Graph returned an error: ' . $e->getMessage();
	} catch (Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		return 'Facebook SDK returned an error: ' . $e->getMessage();
	}

	if (! isset($accessToken)) {
		if ($helper->getError()) {
			header('HTTP/1.0 401 Unauthorized');
			echo "Error: " . $helper->getError() . "\n";
			echo "Error Code: " . $helper->getErrorCode() . "\n";
			echo "Error Reason: " . $helper->getErrorReason() . "\n";
			echo "Error Description: " . $helper->getErrorDescription() . "\n";
		} else {
			header('HTTP/1.0 400 Bad Request');
			echo 'Bad request';
		}
		exit;
	}

	// The OAuth 2.0 client handler helps us manage access tokens
	$oAuth2Client = $fb->getOAuth2Client();

	// Get the access token metadata from /debug_token
	$tokenMetadata = $oAuth2Client->debugToken($accessToken);

	// Validation (these will throw FacebookSDKException's when they fail)
	$tokenMetadata->validateAppId($config['cle']);
	// If you know the user ID this access token belongs to, you can validate it here
	//$tokenMetadata->validateUserId('123');
	$tokenMetadata->validateExpiration();

	if (! $accessToken->isLongLived()) {
		// Exchanges a short-lived access token for a long-lived one
		try {
			$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
		} catch (Facebook\Exceptions\FacebookSDKException $e) {
			return "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
		}
	}

	// Stocker le token dans la session SPIP
	ecrire_config('facebook/accessToken', $accessToken);
}

function facebook_liste_pages() {

	$fb = facebook();

	include_spip('inc/config');
	$config = lire_config('facebook');

	try {
		// Returns a `Facebook\FacebookResponse` object
		$response = $fb->get('/me/accounts', $config['accessToken']);
	} catch (Facebook\Exceptions\FacebookResponseException $e) {
		return 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch (Facebook\Exceptions\FacebookSDKException $e) {
		return 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}

	// On récupère les éléments pages
	$graphEdges = $response->getGraphEdge();

	return $graphEdges;
}


function facebook_page_token($id_page) {

	$graphEdges = facebook_liste_pages();
	foreach ($graphEdges as $graphEdge) {
		if ($graphEdge['id'] == $id_page) {
			return $graphEdge['access_token'];
		}
	}

	return _T('facebook:erreur_page_access_token');
}

/**
 * Créer une datas saisies à partir des pages de la personne
 *
 * @access public
 * @return array Datas pour saisies
 */
function facebook_saisie_pages() {

	$graphEdges = facebook_liste_pages();
	if (!is_string($graphEdges)) {
		// Replir un tableau utilisable avec saisies
		$datas = array();
		foreach ($graphEdges as $graphEdge) {
			$datas[$graphEdge['id']] = $graphEdge['name'];
		}
	} else {
		// C'est une erreur, on la renvoie
		return $graphEdges;
	}


	return $datas;
}

function facebook_profil() {
	$fb = facebook();

	include_spip('inc/config');
	$config = lire_config('facebook');

	try {
		// Returns a `Facebook\FacebookResponse` object
		$response = $fb->get('/me', $config['accessToken']);
	} catch (Facebook\Exceptions\FacebookResponseException $e) {
		return 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch (Facebook\Exceptions\FacebookSDKException $e) {
		return 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}

	$user = $response->getGraphUser();

	return array(
		'nom' => $user['name'],
		'id' => $user['id'],
		'facebook' => $user
	);
}
