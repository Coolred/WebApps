<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Mobile Card Credential Selector</title>
    <style>
        body {
            text-align: center;
            font-family: 'Droid Sans', serif;
            color: #4e4e4e;
        }
        
         #selectionList > a {
            text-align: center;
            display: block;
            padding: 0.25em;
            border: solid #4e4e4e 1px;
            margin-bottom: 1.5em;
        }       
        
        #selectionList {
            margin-top: 1em;
            display: inline-block;
            margin-left: auto;
            margin-right: auto;
        }
        

    </style>
    <body>
        <img src="../img/simplybank.png" alt="SimplyBank Logo"/>
        <h2>Select Mobile Card Credential Type</h2>
        <div id="selectionList">
            <a href="apply-paypass.php">
                <figure>
                    <img src="../img/paypass.png" alt="PayPass Logo">
                    <figcaption>Remote-SE Mobile PayPass</figcaption>
                </figure>
            </a>
            <a href="apply-paywave.php">
                <figure>
                    <img src="../img/paywave.png" alt="PayWave Logo">
                    <figcaption>Visa Cloud-based PayWave</figcaption>
                </figure>
            </a>
            <a href="apply-swipeyours.php">
                <figure>
                    <img src="../img/swipeyours.png" alt="SwipeYours Logo">
                    <figcaption>Visa Magstripe SwipeYours</figcaption>
                </figure>
            </a>
        </div>
    </body>
</html>
