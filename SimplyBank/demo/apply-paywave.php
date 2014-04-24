<?php
    include_once 'IssuerConfig.php';
    
    global $ISSUER;
    $ISSUER = IssuerConfig::PAYWAVE_DEFAULT();
    
    include 'apply-cardtype.php';
?>