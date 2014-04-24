<?php
    include_once 'IssuerConfig.php';
    
    global $ISSUER;
    $ISSUER = IssuerConfig::SWIPEYOURS_DEFAULT();
    
    include 'apply-cardtype.php';
?>