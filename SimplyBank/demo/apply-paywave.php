<?php
    include_once 'IssuerConfig.php';
    
    //
    // This is a special demo issuer that we publish the keys for and
    // comes preconfigured with our Cloud based PayWave applet+agent.
    //
    IssuerConfig::init(
        "PayWave", 
        "ISSUER_KEY", 
        "ISSUER_SECRET",
        "BRAND_ID",
        "PayWavePerso.scr"
    );
    
    include 'apply-cardtype.php';
?>