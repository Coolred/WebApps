<?php
    include_once 'IssuerConfig.php';
    
    global $ISSUER;
    $ISSUER = IssuerConfig::PAYPASS_DEFAULT();
    
    include 'apply-cardtype.php';
?>
