<?php
require("demo/checkoutconfig.php");
require("lib/STOAuth.php");  
session_start();

$simplytappoauth = new SimplyTappOAuth($consumer_key, $consumer_secret, $_COOKIE['oauth_token'], $_COOKIE['oauth_secret']);  
$user_info = $simplytappoauth->get('account/verify_credentials'); 

if(isset($_POST['submit'])){
	$simplytappoauth->post('statuses/update', array('status' => 'Hello world!'));
	echo 'success';
}
else{
	header('Location: ../demo/merchant/stcheckout.php');
}