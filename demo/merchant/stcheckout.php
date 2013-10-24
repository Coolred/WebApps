<?php

require("../../oauth/demo/merchant/config.php");
require("../../oauth/demo/merchant/lib/STOAuth.php");  
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

	//echo $token;

	// Save it in sessions
	$_SESSION['oauth_verifier'] = $_GET['oauth_verifier'];
	$_SESSION['oauth_token'] = $_GET['oauth_token'];
	$_SESSION['oauth_secret'] = $_GET['oauth_token_secret'];

	chdir('./jar');
	exec('java -jar ./SoftTerminal.jar -ck '.$consumer_key.' -cs '.$consumer_secret.' -at '.$token.' -ts '.$secret, $result);
//	echo 'java -jar ./SoftTerminal.jar -ck '.$consumer_key.' -cs '.$consumer_secret.' -at '.$_SESSION['oauth_token'].' -ts '.$_SESSION['oauth_secret'];
	$cardinfo = explode("?;", implode("",$result));
	if(substr($cardinfo[0], 0, 1) == '%'){
		$track1 = $cardinfo[0].'?';
		$track2 = ';'.$cardinfo[1];
		$track2S = explode("=", $cardinfo[1]);
		$pan = '**** **** **** '.substr($track2S[0], 12, 16);
		$expiration = substr((substr($track2S[1], 0, 4)), 0, 2).'/'.substr((substr($track2S[1], 0, 4)), 2, 4);
		$cardtype = substr($track2S[0], 0, 1);
	}
	else{
		$track1 = 'Track 1 not present';
		$track2 = $result[0];
		$track2S = explode("=", $result[0]);
		if($track2 == "card type not supported"){
			$pan = 'NA';
			$expiration = 'NA';
			$cardtype = 'NA';
		}
		else{
			$pan = '**** **** **** '.substr($track2S[0], 13, 17);
			$expiration = substr((substr($track2S[1], 0, 4)), 2, 4).'/'.substr((substr($track2S[1], 0, 4)), 0, 2);
			$cardtype = substr($track2S[0], 1, 1);
		}
	}

	$brand = null;

	if($cardtype == 3){
		$brand = 'American Express';
	}
	else if($cardtype == 4){
		$brand = '<image src=https://blog.asb.co.nz/wp-content/uploads/2012/12/logoVisapayWave.jpg height=13> VISA';
	}
	else if($cardtype == 5){
		$brand = '<image src=http://cdn.n4bb.com/wp-content/uploads/2011/10/mastercard_paypass_logo.jpg height=13> Mastercard';
	}
	else if($cardtype == 6){
		$brand = 'Discover';
	}
	else{
		$brand = 'Unrecognized Card Type';
	}
}
else {  
    // Something's missing, go back to square 1  
    header('Location: ../../oauth/demo/merchant/login.php');  
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Generic Co. Checkout</title>
	<link rel="stylesheet" type="text/css" href="styles/main.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Sans:Bold">

</head>

<body>
 	<img src="images/spark.png" class="logo" width="211" height="142" />

 	<div id="form">
 		<form>
 			<fieldset>
 			<legend>CARD PRESENT INFORMATION</legend>
 			<div class="marginleft">
 			<h5>FOR DEMO PURPOSES ONLY</h5>
 			<br />
 			<table border="1" cellpadding="6">
				<tr>
				<td>Track Number</td>
				<td>String</td>
				</tr>
				<tr>
				<td>1</td>
				<td><font color=red><?php echo $track1; ?></font></td>
				</tr>
				<tr>
				<td>2</td>
				<td><font color=red><?php echo $track2; ?></font></td>
				</tr>
			</table>
			</div>
			</fieldset>
			<br />
			</fieldset>
			<br />
 			<fieldset>
 			<legend>PAYMENT INFORMATION</legend>
 			<div class="marginleft">
			Account: <?php echo $pan; ?><br /><br />
			Card Type: <?php echo $brand; ?><br /><br />
			Expiration Date: <?php echo $expiration; ?>			
			</div>
			</fieldset>
                        <br />
                        <fieldset>
                        <legend>REVIEW CART</legend>
                        <div class="marginleft">
                        <table border="1" cellpadding="6">
                                <tr>
                                <td>#</td>
                                <td>Item Name</td>
                                <td>Price</td>
                                </tr>
                                <tr>
                                <td>1</td>
                                <td>Generic Item</td>
                                <td>$9.99</td>
                                </tr>
                        </table>
                                <br />
                                Total: $9.99
                        </div>
                        </fieldset>

 			<div class="marginleft">
 			<h6>By clicking submit you agree to the Terms of Service</h6>
			<input type="button" value="Submit Order" onclick="location.href='success.html';">
			</div>
		</form>
	</div>
				<br /><br />

</body>

</html>
