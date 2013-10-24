<?php

if(isset($_COOKIE['customappkey']) && isset($_COOKIE['customappsecret'])){
	$consumer_key = $_COOKIE['customappkey'];
	$consumer_secret = $_COOKIE['customappsecret'];
}
else{
	$consumer_key = 'HArhxSPONUctLFkTFyybsXC7EkVL417KEr1FV8sS';
	$consumer_secret = '3v6mmmB97o6WIQMstW3ZAyq0ydLDQBUH8dq1vzWN';
}

?>