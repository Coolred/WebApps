<?php
/*
 * Gets the OAuth request tokens and redirects to SimplyTapp's website for 
 * authorization.  When authorized, if the issuer callback is configured correctly,
 * the SimplyTapp website will redirect to getAccessToken.php.
 */
include_once 'IssuerConfig.php';
$issuer = IssuerConfig::get();

error_log("AAA: Made it here", 0);

$oauth = new OAuth(
            $issuer->getIssuerKey(), 
            $issuer->getIssuerSecret(),
            OAUTH_SIG_METHOD_HMACSHA1,
            OAUTH_AUTH_TYPE_URI
        );
$oauth->enableDebug();

error_log("BBB: Made it here", 0);

try {
    $request_token_info = $oauth->getRequestToken(IssuerConfig::REQUEST_TOKEN_URL . "&brand_id={$issuer->getBrandId()}");
    error_log("XXXX Made it here", 0);
    
    $request_token = $request_token_info['oauth_token'];
    $issuer->setRequestToken($request_token);
    $issuer->setRequestTokenSecret($request_token_info['oauth_token_secret']);
    
    error_log("Location: " . IssuerConfig::AUTH_TOKEN_URL . "?oauth_token=$request_token", 0);
    header("Location: " . IssuerConfig::AUTH_TOKEN_URL . "?oauth_token=$request_token");

} catch(OAuthException $ex) {
    $log = $ex->getMessage() . "\n" . $ex->getTraceAsString();
    error_log($log, 0);

    header("Location: requestTokenError.html");
}

?>
