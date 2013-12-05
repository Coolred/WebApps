<?php
$req_url = 'https://www.simplytapp.com/accounts/OAuthGetRequestToken?scope=CARD_OWNER';

//
// Default to Swipe Yours Issuer Key and Secret.  This issuer is currently located in
// doug@simplytapp.com's account.
//
$issuer_key = 'WaeQ08x0LrhzvGJdPZcBK67LdJH6aKVOjICpReGz';
$issuer_secret = '3kREFUqcMoaJWVLmbi9OTR8tZpGSlGt457aFCWXt';
$issuer_brand_id = '56';

session_start();

unset($_SESSION['oauth_token']);
unset($_SESSION['oauth_token_secret']);
unset($_SESSION['issuer_key']);
unset($_SESSION['issuer_secret']);

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


try {
   $oauth = new OAuth($issuer_key, $issuer_secret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
   $oauth->enableDebug();
   $access_token_info = $oauth->getRequestToken($req_url);

   $_SESSION['oauth_token'] = $access_token_info['oauth_token'];
   $_SESSION['oauth_token_secret'] = $access_token_info['oauth_token_secret'];
   $_SESSION['issuer_key'] = $issuer_key;
   $_SESSION['issuer_secret'] = $issuer_secret;
   
   header('Location: perso.php');

} catch(OAuthException $ex) {
    $log = $ex->getMessage() . "\n" . $ex->getTraceAsString();
    error_log($log, 0);

    header('Location: requestTokenError.html');
}
?>