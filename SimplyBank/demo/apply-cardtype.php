<!DOCTYPE html>
<?php
    include_once 'IssuerConfig.php';
    $cardTypeName = IssuerConfig::get()->getCardTypeName();
?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <title><?=$cardTypeName;?> Mobile Card Application</title>
    <style>
        body {
            text-align: center;
            font-family: 'Droid Sans', serif;
            color: #4e4e4e;
        }

        #form {
            max-width: 60em;
            min-width: 25em;
            margin-left: auto;
            margin-right: auto;
        }

        input {
            margin-top: 0.45em;
            margin-bottom: 0.45em;
        }

        button {
            margin-top: 0.5em;
            margin-bottom: 0.5em;
        }

        .customIssuerOnly {
            display: none;
        }

        .fieldsetHint {
            text-align: center;
            font-size: smaller;
            font-weight: bold;
            margin-bottom: 0.5em;
        }

        fieldset {
            text-align: left;
            padding-left: 2em;
            margin-left: 2em;
            margin-right: 2em;
            margin-bottom: 1em;
        }

        legend {
            padding-left: 0.5em;
            padding-right: 0.5em;
        }

        .center {
            text-align: center;
        }

        /* error is used by validation plugin */
        .error {
            padding-left: 0.5em;
            color: red;
        }
        
        /* next two are only used by jQuery */
        .defaultIssuerOnly {}
        .customIssuerOnly {}
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script>
        $(function() {
            $("#form").validate();

            $("#useCustomIssuerButton").click(function(){
                $(".defaultIssuerOnly").hide();
                $(".customIssuerOnly input").removeAttr('disabled').attr('required', '');
                $("#form").attr("action", "getRequestTokenWithCustomIssuer.php");
                $(".customIssuerOnly").show();
            });

            $("#useDefaultIssuerButton").click(function(){
                $(".customIssuerOnly").hide();
                $(".customIssuerOnly input").removeAttr('required').attr('disabled', '');
                $("#form").attr("action", "getRequestToken.php");
                $(".defaultIssuerOnly").show();
            });

        });
    </script>
</head>

<body>
<img src="/img/simplybank.png"/>
<h2><?=$cardTypeName;?> Mobile Card Application</h2>
    
<form id="form" action="getRequestToken.php" method="get">
    
    <fieldset>
        <legend>GENERAL INFORMATION</legend>
            
        <div class="fieldsetHint">Non-editable Demo-only fields</div>
        <div>
            <label>Full Name: <input type="text" name="lastname" value="John Smith" size="10" disabled></label>
        </div>
        <div>
            <label>Email: <input type="text" name="email" value="john.smith@example.com" size="30" disabled></label>
        </div>
        <div>
            <label>Phone Number: <input type="text" name="phone" value="+1-512-555-1234" disabled></label>
        </div>
        <div>
            <label>Billing Address: <input type="text" name="address" value="678 NFC Payments Lane" size="25"
                                           disabled></label>
        </div>
        <div>
            <label>City: <input type="text" name="city" value="Austin" size="9" disabled></label>
        </div>
        <div>
            <label>State: <input type="text" name="state" value="TX" size="4" disabled></label>
        </div>
        <div>
            <label>Zip Code: <input type="text" name="zip" value="78701" size="8" disabled></label>
        </div>
    </fieldset>
    <div class="defaultIssuerOnly">
        <button type="button" id="useCustomIssuerButton">Custom Issuer &darr;</button> 
        You are using SimplyBank's demo <?=$cardTypeName;?> issuer, but can configure your own.
    </div>
    <fieldset class="customIssuerOnly" id="oauthFieldsSection">
        <legend>Issuer OAuth Configuration (values from Issuer section</legend>
        <div class="center">
            <div class="defaultIssuerOnly fieldsetHint">You are using SimplyBank's SwipeYours Issuer</div>
            <div class="customIssuerOnly fieldsetHint">Copy the values from the Issuer section of your
                SimplyTapp account
            </div>
        </div>
        <div>
            <label>Application Key:
                <input type="text" name="issuer_key" size="55" disabled>
            </label>
        </div>
        <div>
            <label>Application Secret:
                <input type="text" name="issuer_secret" size="55" disabled>
            </label>
        </div>
        <div>
            <label>Card Brand:
                <input type="number" name="issuer_brand_id" disabled>
            </label>
        </div>
        <div class="customIssuerOnly">
            <button id="useDefaultIssuerButton" type="button">Hide and use default <?=$cardTypeName;?> Issuer &uarr;</button>
        </div>
    </fieldset>
        
    <button type="submit">Send Application</button>
        
</form>


</body>
</html>
