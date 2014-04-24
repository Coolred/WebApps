<?php
    include_once 'IssuerConfig.php';
    
    //
    // This is a special demo issuer that we publish the keys for and
    // comes preconfigured with our SwipeYours applet+agent.
    //
    IssuerConfig::init(
        "SwipeYours",
        "WaeQ08x0LrhzvGJdPZcBK67LdJH6aKVOjICpReGz", 
        "3kREFUqcMoaJWVLmbi9OTR8tZpGSlGt457aFCWXt",
        "56",
        "SwipeYoursPerso.scr"
    );
    
    include 'apply-cardtype.php';
?>