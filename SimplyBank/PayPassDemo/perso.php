<!DOCTYPE html>
<?php
    session_start();
    $access_token = isset($_SESSION['access_token']) ? $_SESSION['access_token'] : "NO_VALUE";
    $access_token_secret = isset($_SESSION['access_token_secret']) ? $_SESSION['access_token_secret'] : "NO_VALUE";
?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Card Personalization</title>
    <style>
        body {
            text-align: center;
            font-family: 'Droid Sans', serif;
            color: #4e4e4e;
            margin-left: 2em;
            margin-right: 2em;
        }

        h5, h6 {
            text-align: left;
            margin-top: 0.2em;
            margin-bottom: 1em;
        }

        #tokeInfoFieldset {
            padding-left: 2em;
            padding-right: 2em;
            margin-top: 2em;
        }

        #persoScriptFieldset {
            border: none;
        }

        legend {
            padding-left: 0.5em;
            padding-right: 0.5em;
            padding-bottom: 1em;
        }

        fieldset {
            padding-left: 1.5em;
            padding-right: 1.5em;
        }
        
        .pinInputContainer {
            margin-bottom: 1.5em;
        }
        
        textarea {
            height: 35em;
            width: 100%;
            padding-left: 0.5em;
            word-break: break-all;
            box-sizing: border-box; /* CSS3 */
            -moz-box-sizing: border-box; /* Firefox */
            -ms-box-sizing: border-box; /* IE8 */
            -webkit-box-sizing: border-box; /* Safari */
            -khtml-box-sizing: border-box; /* Konqueror */            
        }
        
        .submitResetContainer {
            margin-top: 0.6em;
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

    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $(function() {                      
            $("#modifyScriptButton").click(function() {
                var pin = $("#pinInput").val();
                if (!/^[0-9]{4}$/.test(pin)) {
                    alert("Invalid pin");
                } else {
                    var text = $("#script").val();                
                    if (text) {                   
                        text = text.replace(/\{4-DIGIT-PIN\}/, pin);
                        $("#script").val(text);
                        $("#modifyScriptButton").attr('disabled', '');
                    }   
                }
            });

            $("#scriptReset").click(function() {
                $("#modifyScriptButton").removeAttr('disabled');
            });

        });
    </script>
</head>
    
<body>
    <img src="/img/simplybank.png"/>
              
    <h2>Personalize Card</h2>
            
    <fieldset>
        <legend>PayPass with Test Credential</legend>
        <h5>
            Enter pin and hit "Modify Script" to customize the GPJ script.  If
            no further script changes after adding the pin data, hit "Personalize Card".
        </h5>
            
        <div class="pinInputContainer">
            <input id="pinInput" type="text" size="4" maxlength="4" pattern="[0-9]{4}">
            <button id="modifyScriptButton">Modify&nbsp;Script</button>
        </div>
        <form id="scriptForm" action="runPerso.php" method="post">
            
            <textarea name="script" id="script"
                class="personalizationScript"><?php include("PayPassPersonalize.scr"); ?></textarea>
            <div class="submitResetContainer">
                <button type="submit" id="scriptSubmit">Personalize Card</button>
                <button type="reset" id="scriptReset">Reset</button>
            </div>
        </form>            
    </fieldset>
        
    <fieldset id="tokeInfoFieldset">
        <legend>OAuth Request Tokens</legend>
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
    </fieldset>
        
        
    <noscript>
        Your web browser must have JavaScript enabled for this page to display correctly.
    </noscript>
        
</body>
    
