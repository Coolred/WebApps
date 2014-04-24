<?php

class IssuerConfig {
    private $cardTypeName;
    private $issuerKey;
    private $issuerSecret;
    private $brandId;
    private $persoFileName;
    
    private static $PAYPASS_DEFAULT;
    private static $PAYWAVE_DEFAULT;
    private static $SWIPEYOURS_DEFAULT;
    
    
    public function __construct($cardTypeName, $issuerKey, $issuerSecret, $brandId, $persoFileName) {
        $this->cardTypeName = $cardTypeName;
        $this->issuerKey = $issuerKey;
        $this->issuerSecret = $issuerSecret;
        $this->brandId = $brandId;
        $this->persoFileName = $persoFileName;
    }
    
    //
    // Normally, you would not publish issuer keys in an open GitHub repository,
    // but these are just demo issuers.
    //
    public static function PAYPASS_DEFAULT() {
        if (!isset(self::$PAYPASS_DEFAULT)) {
            self::$PAYPASS_DEFAULT = new IssuerConfig(
                    "PayPass", 
                    "ISSUER_KEY", 
                    "ISSUER_SECRET",
                    "BRAND_ID",
                    "PayPassPerso.scr"
                    );
        }
        return self::$PAYPASS_DEFAULT;
    }
    
    public static function PAYWAVE_DEFAULT() {
        if (!isset(self::$PAYWAVE_DEFAULT)) {
            self::$PAYWAVE_DEFAULT = new IssuerConfig(
                    "PayWave", 
                    "ISSUER_KEY", 
                    "ISSUER_SECRET",
                    "BRAND_ID",
                    "PayWavePerso.scr"
                    );
        }
        return self::$PAYWAVE_DEFAULT;
    }
    
    public static function SWIPEYOURS_DEFAULT() {
        if (!isset(self::$SWIPEYOURS_DEFAULT)) {
            self::$SWIPEYOURS_DEFAULT = new IssuerConfig(
                    "SwipeYours", 
                    "WaeQ08x0LrhzvGJdPZcBK67LdJH6aKVOjICpReGz", 
                    "3kREFUqcMoaJWVLmbi9OTR8tZpGSlGt457aFCWXt",
                    "56",
                    "SwipeYoursPerso.scr"
                    );
        }
        return self::$SWIPEYOURS_DEFAULT;
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
}
