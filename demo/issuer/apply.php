<?php

session_start();
$_SESSION['CALLBACK'] = $_GET['CALLBACK'];
?>

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
 		<form>
 			<fieldset>
 			<legend>GENERAL INFORMATION</legend>
 			<div class="marginright">
 		
                        <?php	
 			if((isset($_COOKIE['customappkey'])) || (isset($_COOKIE['customappsecret'])) || (isset($_COOKIE['custombrand']))){
 				echo '<a href="delcookies.php">Click here to clear issuer settings</a>';
 			}
 			else{
 				echo '<input type="button" value="Issuers, configure here" onclick="location.href=\'customissuer.php\';">';
 			}
                        ?>

 			</div>
 			<div class="marginleft">
 			<div class="center"><h6>Input fields are for demo purposes. You do not need to edit them.</h6></div>
			<br />
			First Name: <input type="text" name="firstname" value="John" size="8" disabled><br />
			Last Name: <input type="text" name="lastname" value="Smith" size="10" disabled><br />
			Email: <input type="text" name="email" value="john.smith@example.com" size="30" disabled><br />
			Phone Number: <input type="text" name="phone" value="+1-512-555-1234" disabled><br />
			Billing Address: <input type="text" name="address1" value="678 Applier Lane" disabled><br />
			City: <input type="text" name="city" value="Austin" size="10" disabled><br /> 
                        State: <input type="text" name="state" value="TX" size="4" disabled><br /> 
                        Zip Code: <input type="text" name="zip" value="78701" size="8" disabled><br />
			</div>
			</fieldset><br>
			<fieldset>
 			<legend>Employment</legend>
 			<div class="marginleft">
			Current Employer: <input type="text" name="employer" value="Big Mart" disabled><br />
			Work Phone Number: <input type="text" name="workphone" value="+1-512-555-4321" disabled><br />
			Annual Income: <input type="text" name="income" value="$40000" size="8" disabled><br />
			</div>
			</fieldset>
 			<div class="marginleft">
			<h6>Click apply to send card application</h6>
			<input type="button" value="Apply" onclick="location.href='perso.php';">
			</div>
		</form>
	</div>
				<br /><br />

</body>

</html>
