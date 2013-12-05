<!DOCTYPE html>
<?php
    session_start();
    
    function get_session_var($varname) { 
        return isset($_SESSION[$varname]) ? 
            $_SESSION[$varname] : (strtoupper($varname)."_IS_UNDEFINED");     
    } 
    
    $oauth_token = get_session_var('oauth_token');
    $oauth_token_secret = get_session_var('oauth_token_secret');    
    $issuer_key = get_session_var('issuer_key');
    $issuer_secret = get_session_var('issuer_secret');   
    $access_token = "ACCESS_TOKEN_IS_UNDEFINED";
    $access_token_secret = "ACCESS_TOKEN_SECRET_IS_UNDEFINED";
        
    try {
        $oauth = new OAuth($issuer_key, $issuer_secret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
        $oauth->enableDebug();
	$access_token_info = $oauth->getAccessToken("https://www.simplytapp.com/accounts/OAuthGetAccessToken");
        
        $access_token = $access_token_info['oauth_token'];
        $access_token_secret = $access_token_info['oauth_token_secret'];

    } catch(OAuthException $E) {
        die($E->lastResponse);
    }
    
    if(isset($_POST['script'])) {
        $tmpfname = tempnam("./jar", "script");
        $handle = fopen($tmpfname, "w");
        fwrite($handle, $_POST['script']);
        fclose($handle);

        $command = "java -jar ./STBridge.jar -ck $issuer_key -cs $issuer_secret"
            . " -at $access_token -ts $access_token_secret"
            . " -s $tmpfname";
        
        error_log("about to run command: $command", 0);
        chdir('./jar');
        $script_output = exec($command) or die("failed to execute: $command");
                
        unlink($tmpfname);
    } else {
        $script_output = "No 'script' passed in as POST\nparameter to run";
    }  
?>

<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Run Card Personalization</title>
    <style>
        body {
            text-align: center;
            font-family: 'Droid Sans', serif;
            color: #4e4e4e;
        }
        
        fieldset {
            margin: 1em;
        }
        
        #authTokenTable {
            margin-right: auto;
            margin-left: auto;
        }

        #authTokenTable th {
            text-align: right;
            padding-right: 1em;
            padding-top: 0.2em;
            padding-bottom: 0.2em;
        }
        
        #authTokenTable td {
            text-align: left;
        }
    </style>
</head>

<body>
    <img src="simplybank.png"/>

    <fieldset>
        <legend>Personalization OAuth Tokens</legend>
        <div class="marginleft">
            <table id="authTokenTable">
                <tr>
                    <th>OAuth Request Token:</th>
                    <td><?php echo $oauth_token; ?></td>
                </tr>
                <tr>
                    <th>OAuth Request Token Secret:</th>
                    <td><?php echo $oauth_token_secret; ?></td>
                </tr>
                <tr>
                    <th>OAuth Access Token:</th>
                    <td><?php echo $access_token; ?></td>
                </tr>
                <tr>
                    <th>OAuth Access Token Secret:</th>
                    <td><?php echo $access_token_secret; ?></td>
                </tr>                
            </table>
        </div>
    </fieldset>

    <fieldset>
        <legend>SCRIPT RESULT</legend>
        <pre><?php echo $script_output; ?></pre>
    </fieldset>

    <form action="apply.html" method="GET">
        <button type="submit">Start again</button>
    </form>

</body>

</html>
