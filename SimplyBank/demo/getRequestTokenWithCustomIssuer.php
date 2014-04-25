<?php
/*
 * Set the custom values, then load the regular getRequestToken.php
 */

include_once 'IssuerConfig.php';
$issuer = IssuerConfig::get();

if(isset($_POST['issuer_key']) && $_POST($request['issuer_secret']) && $_POST($request['issuer_brand_id'])) {
    // sanitize user input to prevent XSS attacks
    $issuer_key = preg_replace("/[^A-Za-z0-9]/", '', $_POST['issuer_key']);
    $issuer_secret = preg_replace("/[^A-Za-z0-9]/", '', $_POST['issuer_secret']);
    $issuer_brand_id = preg_replace("/[^0-9]/", '', $_POST['issuer_brand_id']);

    $issuer->setIssuerKey($issuer_key);
    $issuer->setIssuerSecret($issuer_secret);
    $issuer->setBrandId($issuer_brand_id);
} else {
    die("issuer_key, issuer_secret and issuer_brand_id not all set");
}

include 'getRequestToken.php';