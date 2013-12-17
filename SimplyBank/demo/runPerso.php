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
    
    $script_input = "No GPJ script provided";
    $script_output = "No output available";
    
    if(isset($_POST['script'])) {
        $script_input = $_POST['script'];
        $tmpfname = tempnam("./jar", "script");
        $handle = fopen($tmpfname, "w");
        fwrite($handle, $script_input);
        fclose($handle);

        $command = "java -jar ./STBridge.jar -ck $issuer_key -cs $issuer_secret"
            . " -at $access_token -ts $access_token_secret"
            . " -s $tmpfname";
        
        error_log("about to run command: $command", 0);
        chdir('./jar');
        
        $script_output = array();
        $return_val = null;
        exec($command, $script_output, $return_val);
        if ($script_output) {
            // convert array to string
            $script_output = implode(PHP_EOL, $script_output);
        } else {
            unlink($tmpfname);
            error_log("We just ran STBridge command with no output: $command");
        }
    }
    
    $finishedButtonText = "Start New Application";
    $finishedButtonAction = "apply.php";
    if(isset($_SESSION['CALLBACK'])) {
        $finishedButtonText = "Return";
        $finishedButtonAction = $_SESSION['CALLBACK'];
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
            word-break: break-all;
        }
        
        .commandOutput, .inputScript {
            display: inline-block;
            text-align: left;
            white-space: pre-wrap;
        }
        
        .inputScript {
            word-break: break-all;
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
        <legend>GPJ Input Script</legend>
        <code class="inputScript"><?php echo $script_input; ?></code>
    </fieldset>
    
    <fieldset>
        <legend>GPJ Output</legend>
        <code class="commandOutput"><?php echo $script_output; ?></code>
    </fieldset>

    <button id="finishedButton" type="button"
            onclick="location.href='<?php echo $finishedButtonAction; ?>';">
        <?php echo $finishedButtonText?>
    </button>

</body>

</html>
