<!DOCTYPE html>
<?php
include_once 'IssuerConfig.php';
$issuer = IssuerConfig::get();
$cardTypeName = $issuer->getCardTypeName();
$persoFileName = $issuer->getPersoFileName();
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
            word-break: break-all;
        }

        .submitResetContainer {
            margin-top: 0.6em;
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
        
        .track2 {
            color: darkblue;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
    
<body>
    <img src="/img/simplybank.png"/>

    <fieldset id="tokeInfoFieldset">
        <legend>Personalize <?= $issuer->getCardTypeName(); ?> Credentials</legend>

<?php if($issuer->getCardTypeName() == "SwipeYours"): ?>
        <script src="persoSwipeYours.js"></script>
        <h5>
            Enter the swiped magstripe data of your own Visa card in-full or just the
            <span class="track2">track 2 portion</span>. Hit "Modify Script" and we'll
            customize the GPJ script with your card info. If you just need a test
            card with no funds on it, you can use this:
        </h5>
        <h6 id="exampleSwipeData">
            %B4046460664629718^000NETSPEND^161012100000181000000?<span class="track2">;4046460664629718=16101210000018100000?</span>
        </h6>
        <h5>
            If you have no further script changes after adding your card's swipe data,
            hit "Personalize Card".
        </h5>
        <div id="swipeInputContainer">
            <span><input id="swipeInput" type="text"></span>
            <button id="track2ConvertButton">Modify&nbsp;Script</button>
        </div>
<?php else: ?>
        <h5>
            Make any needed adjustments to the script and then click "Personalize Card".
        </h5>
<?php endif; ?>
        
        <form action="runPerso.php" method="post">
            <textarea name="script" id="persoScript"
                      class="personalizationScript"><?php include $issuer->getPersoFileName(); ?></textarea>
            <div class="submitResetContainer">
                <button type="submit">Personalize Card</button>
                <button type="reset">Reset</button>
            </div>
        </form>
    </fieldset>

    <fieldset id="tokeInfoFieldset">
        <legend>OAuth Request Tokens</legend>
        <table id="authTokenTable">
            <tr>
                <th>OAuth Request Token:</th>
                <td><?= $issuer->getRequestToken(); ?></td>
            </tr>
            <tr>
                <th>OAuth Request Token Secret:</th>
                <td><?= $issuer->getRequestTokenSecret(); ?></td>
            </tr>
        </table>
    </fieldset>
        
        
    <noscript>
        Your web browser must have JavaScript enabled for this page to display correctly.
    </noscript>
        
</body>
    
