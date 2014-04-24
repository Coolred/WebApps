<?php
    include_once 'IssuerConfig.php';
    
    //
    // This is a special demo issuer that we publish the keys for and
    // comes preconfigured with our Remote-SE Mobile PayPass applet+agent.
    //
    IssuerConfig::init(
        "PayPass", 
        "ISSUER_KEY", 
        "ISSUER_SECRET",
        "BRAND_ID",
        "PayPassPerso.scr"
    );
    
    include 'apply-cardtype.php';
?>
