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
 		<h1>Issuer OAuth Configuration</h1>
 	</div>
 	<div id="form">
 		<form action="appconfig.php" method="post">
 			<fieldset>
 			<legend>PARAMETERS</legend>
 			<div class="marginleft">
 			<div class="center"><h6>For demo purposes. No information inputted in fields below will be saved.</h6></div>
			<br />
			Issuer Key: <input type="text" name="appkey" class="customissuer"><br />
			Issuer Secret: <input type="text" name="appsecret" class="customissuer"><br />
			(Optional) Card Brand: <input type="text" name="cardbrand" class="customissuer"><br />
			</div>
			</fieldset><br>
 			<div class="marginleft">
			<h6>These parameters will be stored in cookies for demo implementation</h6>
			<input type="submit" value="Configure">
			</div>
		</form>
	</div>
				<br /><br />

</body>

</html>


