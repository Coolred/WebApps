<!DOCTYPE html>
<?php
    session_start();
    
    function get_session_var($varname) { 
        return isset($_SESSION[$varname]) ? 
            $_SESSION[$varname] : (strtoupper($varname)."_IS_UNDEFINED");     
    } 
        
    $issuer_key = get_session_var('issuer_key');
    $issuer_secret = get_session_var('issuer_secret');   
    $access_token = get_session_var('access_token');
    $access_token_secret = get_session_var('access_token_secret');
    
    if(isset($_SESSION['script'])) {
        $tmpfname = tempnam("./jar", "script");
        $handle = fopen($tmpfname, "w");
        fwrite($handle, $_SESSION['script']);
        fclose($handle);

        $command = "java -jar ./STBridge.jar -ck $issuer_key -cs $issuer_secret"
            . " -at $access_token -ts $access_token_secret"
            . " -s $tmpfname";
        
        error_log("about to run command: $command", 0);
        chdir('./jar');
        $script_output = exec($command) or die("failed to execute: $command");
                
        unlink($tmpfname);
    } else {
        $script_output = "No GPJ script available to run";
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
        
        legend {
            padding-left: 0.5em;
            padding-right: 0.5em;
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

    <form action="apply.html">
        <button type="submit">Start again</button>
    </form>

</body>

</html>
