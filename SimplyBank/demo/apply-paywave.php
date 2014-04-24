<?php
    include_once 'IssuerConfig.php';
    
    //
    // This is a special demo issuer that we publish the keys for and
    // comes preconfigured with our Cloud based PayWave applet+agent.
    //
    IssuerConfig::init(
        "PayWave", 
        "WaeQ08x0LrhzvGJdPZcBK67LdJH6aKVOjICpReGz", 
        "3kREFUqcMoaJWVLmbi9OTR8tZpGSlGt457aFCWXt",
        "220",
        "PayWavePerso.scr"
    );
    
    include 'apply-cardtype.php';
?>
