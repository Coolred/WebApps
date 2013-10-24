<?php

require("../../oauth/demo/issuer/config.php");
require("../../oauth/demo/issuer/lib/STOAuth.php");  
session_start();

if(!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauthtoken']) && !empty($_SESSION['oauthsecret'])){  
	// TwitterOAuth instance, with two new parameters we got in login.php  
	$simplytappoauth = new SimplyTappOAuth($consumer_key, $consumer_secret, $_SESSION['oauthtoken'], $_SESSION['oauthsecret']);  
	// Let's request the access token  
	$access_token = $simplytappoauth->getAccessToken($_GET['oauth_verifier']); 
	
	//parse access token & secret
	$key = 'oauth_token';
	$token = $access_token[$key];

	$key = 'oauth_token_secret';
	$secret = $access_token[$key];

	$_SESSION['token'] = $token;
	$_SESSION['secret'] = $secret;
	//echo $token;

	// Save it in sessions
	$_SESSION['oauth_verifier'] = $_GET['oauth_verifier'];
	$_SESSION['oauth_token'] = $_GET['oauth_token'];
	$_SESSION['oauth_secret'] = $_GET['oauth_token_secret'];
	echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Generic Bank Card Application</title>
	<link rel="stylesheet" type="text/css" href="styles/main.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Sans:Bold">
</head>

<body>
 	<img src="images/simplybank.png" class="logo" height="55px" width="260px" />

 	<div id="top">
 		<h1>APPLY FOR A CARD</h1>
 	</div>
 	<div id="form">
		<form action="postscript.php" method="post">
 			<fieldset>
 			<legend>CARD BASED TOKEN INFORMATION</legend>
 			<div class="marginleft">
 			<table border="1" cellpadding="6">
				<tr>
				<td>Auth Token</td>
				<td>';

				if(isset($_SESSION['token'])){
					echo $_SESSION['token'];
				};

				echo'
				
				</td>
				</tr>
				<tr>
				<td>Token Secret</td>
				<td>';

				if(isset($_SESSION['secret'])){
					echo $_SESSION['secret'];
				};

				echo'
				</td>
				</tr>
			</table>
			</div>
			</fieldset><br>
			<fieldset>
 			<legend>CARD PERSONALIZATION SCRIPT</legend>
 			<div class="center"><h6>The prefilled text is of a PayPass script. Input your own script if needed.</h6></div>

 			<div class="marginleft">
			<br />

			<textarea name="script">#card manager
/card
auth

#change the keys to the security domain
put-key -m add 1/1/DES/ffffffffffffffffffffffffffffffff 1/2/DES/ffffffffffffffffffffffffffffffff 1/3/DES/ffffffffffffffffffffffffffffffff

#delete applets if they are already there
delete -r a0000000041010
delete -r 325041592e5359532e4444463031

install -i 325041592e5359532e4444463031 -q C9#() 636f6d2e7374 5070736532506179
#
#c9 = 01-VER(KMC) 541312ffffff-KMC(ID) A86A3D06CAE7046A106358D5B8239CBE-KD(PERSO) 89AA7F00-CSN
#
install -i a0000000041010 -q C9#(01541312ffffffa86a3d06cae7046a106358d5b8239cbe89aa7f00) 636f6d2e7374 50617950617373

/select a0000000041010
#perso store data command...see official paypass notes on formatting.
/send 84E2A000AB01017F9F6C020001563E42353431333132333435363738343830305E535550504C4945442F4E4F545E303930363130313333303030333333303030323232323230303031313131309F6401039F62060000003800009F630600000000E0E09F6502000E9F66020E709F6B135413123456784800D09061019000990000000F9F670103A0010B00004000000000778099D3A002105229A2B1820F3213CAF2243CB19C5DF7DE65E29F48C7F212
/atr
</textarea>
<br />
<input type="submit" value="Personalize Card" name="submit">
			<br />
			</div>
			</fieldset>
			</div>
		</form>
	</div>
				<br /><br />

</body>';

}
else {  
    header('Location: ../../oauth/demo/issuer/login.php');  
}