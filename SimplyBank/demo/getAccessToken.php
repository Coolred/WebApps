<?php

/*
 *  This URL of this PHP page should be configured as the access token
 *  callback in the Isser section of SimplyTapp's website.
 */
include_once 'IssuerConfig.php';
$issuer = IssuerConfig::get();

/*
 * Check to see that the oauth_verifier is set, but we don't need it for anything.
 */
if (!isset($_GET['oauth_verifier'])) {    
    error_log("getAccessToken.php called without oauth_verifier", 0);
    header('Location: accessTokenError.html');
    exit;
}

if ($issuer->getRequestToken() != $_GET['oauth_token']) {
    error_log("session/callback token mismatch: session: {$issuer->getRequestToken()}, request: {$_GET[oauth_token]}");
    header('Location: accessTokenError.html');
    exit;
}

$oauth = new OAuth(
            $issuer->getIssuerKey(),
            $issuer->getIssuerSecret(),
            OAUTH_SIG_METHOD_HMACSHA1, 
            OAUTH_AUTH_TYPE_URI
        );
$oauth->enableDebug();

try {
    $oauth->setToken($issuer->getRequestToken(), $issuer->getRequestTokenSecret());    
    $access_token_info = $oauth->getAccessToken(IssuerConfig::$ACCESS_TOKEN_URL);
    
    $issuer->setAccessToken($access_token_info['oauth_token']);
    $issuer->setAccessTokenSecret($access_token_info['oauth_token_secret']);

    // Redirect (instead of using include) so the user's URL changes for the perso page
    header('Location: perso.php');
    
} catch (OAuthException $ex) {
    $log = $ex->getMessage() . "\n" . $ex->getTraceAsString();
    error_log($log, 0);
    error_log("Debug info: " . var_export($oauth->debugInfo, true));

    header('Location: accessTokenError.html');
}

?>
