<?php
/*
 * Gets the OAuth request tokens and redirects to SimplyTapp's website for 
 * authorization.  When authorized, if the issuer callback is configured correctly,
 * the SimplyTapp website will redirect to getAccessToken.php.
 */
include_once 'IssuerConfig.php';
$issuer = IssuerConfig::get();

$oauth = new OAuth(
            $issuer->getIssuerKey(), 
            $issuer->getIssuerSecret(),
            OAUTH_SIG_METHOD_HMACSHA1,
            OAUTH_AUTH_TYPE_URI
        );
$oauth->enableDebug();

try {
    $request_token_info = $oauth->getRequestToken(IssuerConfig::$REQUEST_TOKEN_URL . "&brand_id={$issuer->getBrandId()}");
    
    $request_token = $request_token_info['oauth_token'];
    $issuer->setRequestToken($request_token);
    $issuer->setRequestTokenSecret($request_token_info['oauth_token_secret']);
    
    header("Location: " . IssuerConfig::$AUTH_TOKEN_URL . "?oauth_token=$request_token");

} catch(OAuthException $ex) {
    $log = $ex->getMessage() . "\n" . $ex->getTraceAsString();
    error_log($log, 0);

    header("Location: requestTokenError.html");
}

?>
