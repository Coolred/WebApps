<?php

session_start();
    
/*
 *  IssuerConfig is a singleton that stores itself in the user's session memory
 *  on the server.  Use init(...) to wipe and reset the instance and get() to
 *  retrieve the current instance. 
 */
class IssuerConfig {
    private $cardTypeName;
    private $issuerKey;
    private $issuerSecret;
    private $brandId;
    private $persoFileName;
    private $accessToken;
    private $accessSecret;
    private $applyCompletedCallback;
    
    private static $instance;
    
    
    // constuctor private to enforce singleton 
    private function __construct($cardTypeName, $issuerKey, $issuerSecret, $brandId, $persoFileName) {
        $this->cardTypeName = $cardTypeName;
        $this->issuerKey = $issuerKey;
        $this->issuerSecret = $issuerSecret;
        $this->brandId = $brandId;
        $this->persoFileName = $persoFileName;
        $this->accessToken  = "NOT_INITIALIZED";
        $this->accessSecret = "NOT_INITIALIZED";
        
        // We save the callback if it is given to us, but it's not a required
        // parameter.
        $request = ($_SERVER['REQUEST_METHOD'] == 'GET') ? $_GET : $_POST;   
        $this->applyCompletedCallback = $request['CALLBACK'];

    }
    
    public static function init($cardTypeName, $issuerKey, $issuerSecret, $brandId, $persoFileName) {
        self::$instance = new IssuerConfig($cardTypeName, $issuerKey, $issuerSecret, $brandId, $persoFileName);
        $_SESSION['IssuerConfig'] = self::$instance;
        return self::$instance;
    }
    
    public static function get($returnMockValueIfSessionExpired = false) {
        if (!isset(self::$instance)) {
            self::$instance = $_SESSION['IssuerConfig'];
            if (!isset(self::$instance)) {
                $returnMockValueIfSessionExpired || die("ISSUER NOT SET");
                self::$instance = self::createMockInstance();
            }
        }
        return self::$instance;
    }
    
    private static function createMockInstance() {
        return new IssuerConfig(
            "SessionExpired", 
            "ISSUER_KEY_NOT_SET",
            "ISSUER_SECRET_NOT_SET",
            "-1", 
            "/dev/null"
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
    
    public function getAccessKey() {
        return $this->accessKey;
    }
    
    public function setAccessKey($accessKey) {
        $this->accessKey = $accessKey;
    }
    
    public function getAccessSecret() {
        return $this->accessSecret;
    }
    
    public function setAccessSecret($accessSecret) {
        $this->accessSecret = $accessSecret;
    }

    public function getApplyCompletedCallback() {
        return $this->applyCompletedCallback;
    }
    
    public function setApplyCompletedCallback($applyCompletedCallback) {
        $this->applyCompletedCallback = $applyCompletedCallback;
    } 

}
