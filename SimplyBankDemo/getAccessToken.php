<?php
session_start();

function get_session_var($varname) {
    return isset($_SESSION[$varname]) ?
            $_SESSION[$varname] : (strtoupper($varname) . "_IS_UNDEFINED");
}

$issuer_key = get_session_var('issuer_key');
$issuer_secret = get_session_var('issuer_secret');

$request_token = get_session_var('request_token');
$request_token_secret = get_session_var('request_token_secret');

if (!isset($_GET['oauth_verifier'])) {    
    error_log("getAccessToken.php called without oauth_verifier", 0);
    header('Location: accessTokenError.html');
    exit;
}

if ($request_token != $_GET['oauth_token']) {
    error_log("session/callback token mismatch: session: $request_token, request: $_GET[oauth_token]");
    header('Location: accessTokenError.html');
    exit;
}

try {
    $oauth = new OAuth($issuer_key, $issuer_secret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
    $oauth->enableDebug();
    $oauth->setToken($request_token, $request_token_secret);
    
    $access_url = "https://www.simplytapp.com/accounts/OAuthGetAccessToken";
    $access_token_info = $oauth->getAccessToken($access_url);

    $_SESSION['access_token'] = $access_token_info['oauth_token'];
    $_SESSION['access_token_secret'] = $access_token_info['oauth_token_secret'];

    header('Location: perso.php');
    
} catch (OAuthException $ex) {
    $log = $ex->getMessage() . "\n" . $ex->getTraceAsString();
    error_log($log, 0);

    header('Location: accessTokenError.html');
}

?>
