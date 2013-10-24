<?php

require("config.php");
require("lib/STOAuth.php");  
session_start();

// The SimplyTappOAuth instance
$simplytappoauth = new SimplyTappOAuth($consumer_key, $consumer_secret);  
// Requesting authentication tokens, the parameter is the URL we will be redirected to  

$request_token = $simplytappoauth->getRequestToken('../../../demo/merchant/stcheckout.php');  

// Saving them into session
$oauthtoken = $request_token['oauth_token'];
$oauthsecret = $request_token['oauth_token_secret'];
$_SESSION['oauthtoken'] = $oauthtoken; 
//('oauthtoken', $oauthtoken, time() + (86400 * 7)); //store for a year
$_SESSION['oauthsecret'] = $oauthsecret;
//setcookie('oauthsecret', $oauthsecret, time() + (86400 * 7));
  
//crashes here
// If everything goes well..  
if($simplytappoauth->http_code==200){  
    // Let's generate the URL and redirect  
    $url = $simplytappoauth->getAuthorizeURL($request_token['oauth_token']); 

    header('Location:' . $url);  

} else { 
	echo $result;
    // It's a bad idea to kill the script, but we've got to know when there's an error.  
    die('Something wrong happened.');  
}   