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
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Generic Bank Card Application</title>
	<link rel="stylesheet" type="text/css" href="styles/main.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Droid+Sans:Bold">

	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

    <script>
        $(function() {

            $("#tabs").tabs();

            function log(msg) {
                if (window.console) {
                    console.log(msg);
                }
            }

            $("#track2ConvertButton").click(function() {
                var convertedTrackData = "ENTER_YOUR_SWIPE_DATA_TO_FILL_THIS_IN";
                try {
                    var swipeInput = $("#swipeInput").val();
                    if (swipeInput) {
                        convertedTrackData = convertSwipeDataToApduCommand(swipeInput);
                    }
                } catch (ex) {
                    alert("Invalid swipe input")
                }

                try {
                    modifyPersonalizationScript(convertedTrackData);
                } catch (ex) {
                    log(ex.message);
                }
            });

            function modifyPersonalizationScript(convertedTrackData) {
                var text = $("#swipeYoursScript").val();
                text = text.replace(/\/send\b.*/, "/send " + convertedTrackData);
                $("#swipeYoursScript").val(text);
            }


            function convertSwipeDataToApduCommand(swipeData) {
                // strip any whitespace and then match the track 2 portion of the data
                var apduPayload = swipeData.replace(/\s/g, '').match(/[0-9]+=[0-9]+/)[0];

                // replace the equal sign with a hex 'D'
                apduPayload = apduPayload.replace('=', 'D');

                // append a hex 'F' if the ascii length is odd
                if (apduPayload.length % 2 !== 0) {
                    apduPayload += 'F';
                }

                // divide the length of the payload in hex by two in order to get the
                // payload byte count
                var payloadLength = (apduPayload.length / 2).toString(16);

                // 00e20000: CLA = 00, INS = e2, P1 = 00, p2 = 00
                return "00e20000" + payloadLength +  apduPayload + "00";
            }

        });

    </script>
</head>

<body>
 	<img src="images/simplybank.png" class="logo" height="55px" width="260px" />

 	<div id="top">
 		<h1>APPLY FOR A CARD</h1>
 	</div>
 	<div id="form">
 			<fieldset>
 			<legend>CARD BASED TOKEN INFORMATION</legend>
 			<div class="marginleft">
 			<table border="1" cellpadding="6">
				<tr>
				<td>Auth Token</td>
				<td>

				<?php
				if(isset($_SESSION['token'])){
					echo $_SESSION['token'];
				}
				?>

				</td>
				</tr>
				<tr>
				<td>Token Secret</td>
				<td>

				<?php
				if(isset($_SESSION['secret'])){
					echo $_SESSION['secret'];
				}
				?>

				</td>
				</tr>
			</table>
			</div>
			</fieldset><br>
			<fieldset>
 			<legend>CARD PERSONALIZATION SCRIPT</legend>
 			<div class="center"><h6>The prefilled text is of a PayPass script. Input your own script if needed.</h6></div>

 			<div class="marginleft">
			<div id="tabs">

    <ul>
        <li><a href="#tabs-1">Visa Swipe-Yours</a></li>
        <li><a href="#tabs-2">PayPass with Test Credential</a></li>
    </ul>


    <div id="tabs-1">

        <p>
            Enter swiped data of your own Visa card in-full or just the track 2 portion. Hit go and
            we'll display the GPJ personalization script. If you need some test swipe data to understand how
            this page works you can use this:
        
        <div class="swipeSpacing">
        <p>
            %B4046460664629718^000NETSPEND^161012100000181000000?;4046460664629718=16101210000018100000?
        </p>

            <input id="swipeInput" type="text">
            <button id="track2ConvertButton">Go</button>
        </div>
		<form id="swipeYoursForm" action="postscript.php" method="post">

        <textarea name="script" id="swipeYoursScript" class="personalizationScript">#card manager
/card
auth

#change the keys to the security domain
put-key -m add 1/1/DES/ffffffffffffffffffffffffffffffff 1/2/DES/ffffffffffffffffffffffffffffffff 1/3/DES/ffffffffffffffffffffffffffffffff

#delete applets if they are already there
delete -r a0000000031010
delete -r 325041592e5359532e4444463031

#install the applets
install -i a0000000031010 -q C9#() 636f6d2e7374 436172644170706c6574
install -i 325041592e5359532e4444463031 -q C9#() 636f6d2e7374 5070736532506179

#perso
/select a0000000031010
/send ENTER_YOUR_SWIPE_DATA_TO_FILL_THIS_IN

/atr
/select 325041592e5359532e4444463031
/select a0000000031010
        </textarea>
     	   <div>
      	      <button type="submit" id="swipeYoursSubmit">Personalize Card</button>
       	      <button type="reset" id="swipeYoursReset">Reset</button>
       	 </div>
        </form>
    </div>

    <div id="tabs-2">
        <p>Use this personalize a well-known test credential for PayPass Mastercard:</p>
        <form id="payPassForm" action="postscript.php" method="post">
        <textarea name="script" id="payPassScript" class="personalizationScript">#card manager
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
        </textarea>
        <div>
            <button type="submit" id="payPassSubmit">Personalize Card</button>
            <button type="reset" id="payPassReset">Reset</button>
        </div>
        </form>
    </div>

</div>

<noscript>
    Your web browser must have JavaScript enabled for this page to display correctly.
</noscript>

			<br />
			</div>
			</fieldset>
			</div>
		
	</div>
				<br /><br />

</body>

<?php
}
else {  
    header('Location: ../../oauth/demo/issuer/login.php');  
}
?>