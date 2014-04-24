<?php
    include_once 'IssuerConfig.php';
    
    //
    // This is a special demo issuer that we publish the keys for and
    // comes preconfigured with our Remote-SE Mobile PayPass applet+agent.
    //
    IssuerConfig::init(
        "PayPass", 
        "WaeQ08x0LrhzvGJdPZcBK67LdJH6aKVOjICpReGz", 
        "3kREFUqcMoaJWVLmbi9OTR8tZpGSlGt457aFCWXt",
        "219",
        "PayPassPerso.scr"
    );
    
    include 'apply-cardtype.php';
?>
