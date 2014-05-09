<?php

session_start();
   
/*
 *  IssuerConfig is a singleton that stores itself in the user's session memory
 *  on the server.  Use init(...) to wipe and reset the instance and get() to
 *  retrieve the current instance. 
 */
class IssuerConfig {
    // static URLs are defined at the end of the file because PHP is lame.
    public static $REQUEST_TOKEN_URL;
    public static $AUTH_TOKEN_URL;
    public static $ACCESS_TOKEN_URL; 
    
    private $cardTypeName;
    private $issuerKey;
    private $issuerSecret;
    private $brandId;
    private $persoFileName;
    private $requestToken;
    private $requestTokenSecret;
    private $accessToken;
    private $accessTokenSecret;
    private $applyCompletedCallback;
    
    private static $instance;
    
    
    // constuctor private to enforce singleton 
    private function __construct($cardTypeName, $issuerKey, $issuerSecret, $brandId, $persoFileName) {
        $this->cardTypeName = $cardTypeName;
        $this->issuerKey = $issuerKey;
        $this->issuerSecret = $issuerSecret;
        $this->brandId = $brandId;
        $this->persoFileName = $persoFileName;
        $this->requestToken = "NOT_SET";
        $this->requestTokenSecret = "NOT_SET";
        $this->accessToken  = "NOT_SET";
        $this->accessTokenSecret = "NOT_SET";
        
        // We save the callback if it is given to us, but it's not a required
        // parameter.
        $request = ($_SERVER['REQUEST_METHOD'] == 'GET') ? $_GET : $_POST;
        if (isset($request['CALLBACK'])) {
            $this->applyCompletedCallback = $request['CALLBACK'];
        }

    }
    
    public static function init($cardTypeName, $issuerKey, $issuerSecret, $brandId, $persoFileName) {
        self::$instance = new IssuerConfig($cardTypeName, $issuerKey, $issuerSecret, $brandId, $persoFileName);
        $_SESSION['IssuerConfig'] = self::$instance;
        return self::$instance;
    }
    
    public static function get() {
        if (!isset(self::$instance)) {
            self::$instance = isset($_SESSION['IssuerConfig']) ?
                $_SESSION['IssuerConfig'] : self::createMockInstance();       
        }
        return self::$instance;
    }
    
    private static function createMockInstance() {
        return new IssuerConfig(
            "SessionExpired", 
            "ISSUER_KEY_NOT_SET",
            "ISSUER_SECRET_NOT_SET",
            "-1", 
            "SessionExpired.scr"
        );
    }
        
    public function getCardTypeName() {
        return $this->cardTypeName;
    }
    
    public function getIssuerKey() {
        return $this->issuerKey;
    }
    
    public function setIssuerKey($issuerKey) {
        $this->issuerKey = $issuerKey;
    }
    
    public function getIssuerSecret() {
        return $this->issuerSecret;
    }
    
    public function setIssuerSecret($issuerSecret) {
        $this->issuerSecret = $issuerSecret;
    }
    
    public function getBrandId() {
        return $this->brandId;
    }
    
    public function setBrandId($brandId) {
        $this->brandId = $brandId;
    }
    
    public function getPersoFileName() {
        return $this->persoFileName;
    }
    
    public function getRequestToken() {
        return $this->requestToken;
    }
      
    public function setRequestToken($requestToken) {
        $this->requestToken = $requestToken;
    }
    
    public function getRequestTokenSecret() {
        return $this->requestTokenSecret;
    }
    
    public function setRequestTokenSecret($requestTokenSecret) {
        $this->requestTokenSecret = $requestTokenSecret;
    }
    
    public function getAccessToken() {
        return $this->accessToken;
    }
    
    public function setAccessToken($accessToken) {
        $this->accessToken = $accessToken;
    }
    
    public function getAccessTokenSecret() {
        return $this->accessTokenSecret;
    }
    
    public function setAccessTokenSecret($accessTokenSecret) {
        $this->accessTokenSecret = $accessTokenSecret;
    }

    public function getApplyCompletedCallback() {
        return $this->applyCompletedCallback;
    }
    
    public function setApplyCompletedCallback($applyCompletedCallback) {
        $this->applyCompletedCallback = $applyCompletedCallback;
    } 

}

IssuerConfig::$REQUEST_TOKEN_URL = "https://{$_SERVER['OAUTH_DOMAIN']}/accounts/OAuthGetRequestToken?scope=CARD_OWNER";
IssuerConfig::$AUTH_TOKEN_URL    = "https://{$_SERVER['OAUTH_DOMAIN']}/accounts/OAuthAuthorizeToken";
IssuerConfig::$ACCESS_TOKEN_URL  = "https://{$_SERVER['OAUTH_DOMAIN']}/accounts/OAuthGetAccessToken";
