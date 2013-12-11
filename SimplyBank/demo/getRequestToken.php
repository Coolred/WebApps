<?php
/*
 * Get's the OAuth request tokens and redirects to SimplyTapp's website for 
 * authorization.  When authorized, if the issuer callback is configured correctly,
 * the SimplyTapp website will redirect to getAccessToken.php.
 */

$req_url = 'https://www.simplytapp.com/accounts/OAuthGetRequestToken?scope=CARD_OWNER';

//
// Default to SwipeYours Issuer Key and Secret.  This is a special issuer
// open to any user.  Normally, you would not publish issuer keys in an
// open GitHub repository.
//
$issuer_key = 'WaeQ08x0LrhzvGJdPZcBK67LdJH6aKVOjICpReGz';
$issuer_secret = '3kREFUqcMoaJWVLmbi9OTR8tZpGSlGt457aFCWXt';
$issuer_brand_id = '56';

session_start();

unset($_SESSION['issuer_key']);
unset($_SESSION['issuer_secret']);
unset($_SESSION['access_token']);
unset($_SESSION['access_token_secret']);


//
//  Override the SwipeYours issuer key/secret with custom values if they were
//  given to us:
//
if(isset($_GET['issuer_key']) || isset($_GET['issuer_secret']) || isset($_GET['brand_id'])) {
    // sanitize user input to prevent XSS attacks
    $issuer_key = preg_replace("/[^A-Za-z0-9]/", '', $_GET['issuer_key']);
    $issuer_secret = preg_replace("/[^A-Za-z0-9]/", '', $_GET['issuer_secret']);
    if (isset($_GET['brand_id'])) {
        $brand_id = preg_replace("/[^0-9]/", '', $_GET[brand_id]);
        $req_url .= "&brand_id=$brand_id";
    }
} else {
    $req_url .= "&brand_id=$issuer_brand_id";
}

$_SESSION['issuer_key'] = $issuer_key;
$_SESSION['issuer_secret'] = $issuer_secret;


$oauth = new OAuth($issuer_key, $issuer_secret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
$oauth->enableDebug();

try {
    $request_token_info = $oauth->getRequestToken($req_url);

    $request_token = $request_token_info['oauth_token'];
    $request_token_secret = $request_token_info['oauth_token_secret'];

    error_log("retrieved: request_token=$request_token, request_token_secret=$request_token_secret", 0);
           
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