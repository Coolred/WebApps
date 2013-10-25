<?php

session_start();
$_SESSION['CALLBACK'] = $_GET['CALLBACK'];

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
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
 		<form>
 			<fieldset>
 			<legend>GENERAL INFORMATION</legend>
 			<div class="marginright">';
 			
 			if((isset($_COOKIE['customappkey'])) || (isset($_COOKIE['customappsecret'])) || (isset($_COOKIE['custombrand']))){
 				echo '<a href="delcookies.php">Click here to clear issuer settings</a>';
 			}
 			else{
 				echo '<input type="button" value="Issuers, configure here" onclick="location.href=\'customissuer.php\';">';
 			}

 			echo '</div>
 			<div class="marginleft">
 			<div class="center"><h6>For demo purposes. No information inputted in fields below will be saved.</h6></div>
			<br />
			First Name: <input type="text" name="firstname"><br />
			Last Name: <input type="text" name="lastname"><br />
			Email: <input type="text" name="email"><br />
			Phone Number: <input type="text" name="phone"><br />
			Billing Address (Line 1): <input type="text" name="address1"><br />
			Billing Address (Line 2): <input type="text" name="address2"><br />
			City: <input type="text" name="city"><br /> State: <input type="text" name="state"><br /> Zip Code: <input type="text" name="zip"><br />
			Country: <input type="text" name="country"><br />
			</div>
			</fieldset><br>
			<fieldset>
 			<legend>Employment</legend>
 			<div class="marginleft">
 			<div class="center"><h6>For demo purposes. No information inputted in fields below will be saved.</h6></div>
			<br />
			Current Employer: <input type="text" name="employer"><br />
			Work Phone Number: <input type="text" name="workphone"><br />
			Annual Income: <input type="text" name="income"><br />
			</div>
			</fieldset>
 			<div class="marginleft">
			<h6>Card application will be sent upon clicking Apply</h6>
			<input type="button" value="Apply" onclick="location.href=\'perso.php\';">
			</div>
		</form>
	</div>
				<br /><br />

</body>

</html>';

?>