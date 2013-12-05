<!DOCTYPE html>
<?php
    session_start();
    $access_token = isset($_SESSION['access_token']) ? $_SESSION['access_token'] : "NO_VALUE";
    $access_token_secret = isset($_SESSION['access_token_secret']) ? $_SESSION['access_token_secret'] : "NO_VALUE";
?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Card Personalization</title>
     <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css"/>
    <style>
        body {
            text-align: center;
            font-family: 'Droid Sans', serif;
            color: #4e4e4e;
        }

        h5, h6 {
            text-align: left;
            margin-top: 0.2em;
            margin-bottom: 1em;
        }

        #exampleSwipeData {
            word-break: break-all;
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

        #form {
            padding-left: 1.5em;
            padding-right: 1.5em;
        }

        textarea {
            width: 100%;
            height: 35em;
            padding-left: 0.5em;
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

        #swipeInputContainer {
            display: table;
            margin-bottom: 1.5em;
        }

        #swipeInputContainer span, #swipeInputContainer button {
            display: table-cell;
        }

        #swipeInputContainer span, #swipeInputContainer input {
            width: 100%;
        }
        #swipeInputContainer span {
            padding-right: 1em;
        }

        .submitResetContainer {
            margin-top: 0.6em;
        }

    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="perso.js"></script>
</head>
    
<body>
    <img src="simplybank.png"/>
              
    <h2>Personalize Card</h2>
            
    <div id="tabs">
        
        <ul>
            <li><a href="#tabs-1">Visa Swipe-Yours</a></li>
            <li><a href="#tabs-2">PayPass with Test Credential</a></li>
        </ul>
            
        <div id="tabs-1">
            <h5>
                Enter swiped data of your own Visa card in-full or just the track 2 portion. Hit go and
                we'll display the GPJ personalization script. If you need some test swipe data to understand how
                this page works you can use this:
            </h5>
            <h6 id="exampleSwipeData">
                %B4046460664629718^000NETSPEND^161012100000181000000?;4046460664629718=16101210000018100000?
            </h6>
                
            <div id="swipeInputContainer">
                <span><input id="swipeInput" type="text"></span>
                <button id="track2ConvertButton">Go</button>
            </div>
            <form id="swipeYoursForm" action="runPerso.php" method="post">
                
                <textarea name="script" id="swipeYoursScript"
                          class="personalizationScript"><?php include("SwipeYoursPersonalize.scr"); ?></textarea>
                <div class="submitResetContainer">
                    <button type="submit" id="swipeYoursSubmit">Personalize Card</button>
                    <button type="reset" id="swipeYoursReset">Reset</button>
                </div>
            </form>
        </div>
            
        <div id="tabs-2">
            <h5>Use this personalize a well-known test credential for PayPass Mastercard:</h5>
            <form id="payPassForm" action="postscript.php" method="post">
                <textarea name="script" id="payPassScript" class="personalizationScript"
                          class="personalizationScript"><?php include("PayPassPersonalize.scr"); ?></textarea>
                <div class="submitResetContainer">
                    <button type="submit" id="payPassSubmit">Personalize Card</button>
                    <button type="reset" id="payPassReset">Reset</button>
                </div>
            </form>
        </div>
            
    </div>
        
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
    