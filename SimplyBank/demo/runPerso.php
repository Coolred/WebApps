<!DOCTYPE html>
<?php
    include_once 'IssuerConfig.php';
    $issuer = IssuerConfig::get();
    
    $script_input = "No GPJ script provided";
    $script_output = "No output available";
    
    if(isset($_POST['script'])) {
        $script_input = $_POST['script'];
        chdir('../STBridge/');
        $tmpfname = tempnam(getcwd(), "script");
        $handle = fopen($tmpfname, "w");
        fwrite($handle, $script_input);
        fclose($handle);

        $command = "/usr/bin/java -jar STBridge.jar "
                .  "-ck {$issuer->getIssuerKey()}   -cs {$issuer->getIssuerSecret()}"
                . " -at {$issuer->getAccessToken()} -ts {$issuer->getAccessTokenSecret()}"
                . " -s $tmpfname 2>&1";
        
        error_log("about to run command: $command", 0);
        
        $script_output = array();
        $return_val = null;
        exec($command, $script_output, $return_val);
        unlink($tmpfname);
        
        if ($script_output) {
            // convert array to string
            $script_output = implode(PHP_EOL, $script_output);
        } else {
            error_log("We just ran STBridge command with return status '$return_val' and no output: $command");
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
    <meta name="viewport" content="width=device-width">
    <title>Run <?=$issuer->getCardTypeName();?> Mobile Card Personalization</title>
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
        
        .commandOutput {
            display: inline-block;
            text-align: left;
            white-space: pre-wrap;
        }
        
        #inputScript {
            word-break: break-all;
        }
        
    </style>
</head>

<body>
    <img src="/img/simplybank.png"/>
    
    <fieldset>
        <legend>GPJ Input Script</legend>
        <code id="inputScript" class="commandOutput"><?= $script_input; ?></code>
    </fieldset>
    
    <fieldset>
        <legend>GPJ Output</legend>
        <code class="commandOutput"><?= $script_output; ?></code>
    </fieldset>
    
    <fieldset>
        <legend>Personalization OAuth Tokens</legend>
        <div class="marginleft">
            <table id="authTokenTable">
                <tr>
                    <th>OAuth Access Token:</th>
                    <td><?= $issuer->getAccessToken(); ?></td>
                </tr>
                <tr>
                    <th>OAuth Access Token Secret:</th>
                    <td><?= $issuer->getAccessTokenSecret(); ?></td>
                </tr>                
            </table>
        </div>
    </fieldset>
    
    <button id="finishedButton" type="button"
            onclick="location.href='<?= $finishedButtonAction; ?>';">
        <?= $finishedButtonText; ?>
    </button>

</body>

</html>
