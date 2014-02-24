<?php
/*
 * Get's the OAuth request tokens and redirects to SimplyTapp's website for 
 * authorization.  When authorized, if the issuer callback is configured correctly,
 * the SimplyTapp website will redirect to getAccessToken.php.
 */
$issuer_key = 'OrLTYybfhpZNU2URBdrRuaN1jLloE3CZw4EuK73Y';
$issuer_secret = 'WFeARTwRdTCjsVCucIHll6o6DMDgQ3TW5IjuPwvN';
$issuer_brand_id = '85';

$req_token_url = "https://www.simplytapp.com/accounts/OAuthGetRequestToken?scope=CARD_OWNER&brand_id=$issuer_brand_id";

session_start();

unset($_SESSION['issuer_key']);
unset($_SESSION['issuer_secret']);
unset($_SESSION['access_token']);
unset($_SESSION['access_token_secret']);

$oauth = new OAuth($issuer_key, $issuer_secret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
$oauth->enableDebug();

try {
    $request_token_info = $oauth->getRequestToken($req_token_url);

    $request_token = $request_token_info['oauth_token'];
    $request_token_secret = $request_token_info['oauth_token_secret'];

    error_log("retrieved: request_token=$request_token, request_token_secret=$request_token_secret", 0);
           
    $_SESSION['issuer_key'] = $issuer_key;
    $_SESSION['issuer_secret'] = $issuer_secret;
    $_SESSION['request_token'] = $request_token;
    $_SESSION['request_token_secret'] = $request_token_secret;
    
    $auth_url = "https://www.simplytapp.com/accounts/OAuthAuthorizeToken?oauth_token=$request_token";
    
    header("Location: $auth_url");

} catch(OAuthException $ex) {
    $log = $ex->getMessage() . "\n" . $ex->getTraceAsString();
    error_log($log, 0);

    header("Location: requestTokenError.html");
}

?>
