<?php

require("../../oauth/demo/issuer/config.php");
require("../../oauth/demo/issuer/lib/STOAuth.php");  
session_start();

	chdir('./jar');
	exec('java -jar ./STBridge.jar -ck '.$consumer_key.' -cs '.$consumer_secret.' -at '.$_SESSION['token'].' -ts '.$_SESSION['secret'] .' -s '.'/var/www/matrix/demo/issuer/'.$_SESSION['filename'], $result);


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
 	<img src="images/simplybank.png" class="logo" height="55px" width="260px" />

 	<div id="top">
 		<img class="center" src="images/logo.svg" height="36px" />
 	</div>
 	<div id="form">
 		<form>
 			<fieldset>
 			<legend>CARD BASED TOKEN INFORMATION</legend>
 			<div class="marginleft">
 			<table border="1" cellpadding="6">
				<tr>
				<td>Auth Token</td>
				<td>
				<?php if(isset($_SESSION['token'])){
					echo $_SESSION['token'];
				} ?>
				</td>
				</tr>
				<tr>
				<td>Token Secret</td>
				<td>
				<?php if(isset($_SESSION['secret'])){
					echo $_SESSION['secret'];
				} ?></td>
				</tr>
			</table>
			</div>
			</fieldset>
			<br />
			<fieldset>
 			<legend>SCRIPT RESULT</legend>
 			<div class="marginleft">

 			<?php
 				foreach($result as $element) {
				echo $element."<br />";
			} ?>
			</div>
			</fieldset>
			<br />
 			<div class="marginleft">
 			<h6>Card successfully created!</h6>
 			<?php if(isset($_SESSION['CALLBACK'])){
					echo '<input type="button" value="OK" onclick="location.href=\''.$_SESSION['CALLBACK'].'\';">';
				}
				else
				{
					echo '<input type="button" value="Start again" onclick="location.href=\'apply.php\';">';
				} ?>
			</div>
		</form>
	</div>
				<br /><br />

</body>

</html>