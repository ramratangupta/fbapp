<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Get website url HTTP/HTTPS
 *
 * @author ragupta
 */
class URLConfig {

    //put your code here
    //Domain and Website
    /**
     * if www need to be omit then keep it blank eles you can keep it www
     */
    const www_protocol = '';

    private $HTTP_PROTOCOL;
    private $app_path;
    protected $WWW_SITE_URL;
    protected $WWW_SITE_ROOT;
    protected $UNSECURE_WWW_SITE_ROOT;

    function __construct() {
        //Logic to check code is running on HTTP or HTTPS
        if (isset($_SERVER['HTTPS'])) {
            if ($_SERVER['HTTPS'] == 'off')
                $this->HTTP_PROTOCOL = "http";
            else
                $this->HTTP_PROTOCOL = "https";
        } else
            $this->HTTP_PROTOCOL = "http";
        $this->app_path = "://" . self::www_protocol . AppConfig::APP_FOLDER_NAME;
        $this->WWW_SITE_URL = $this->HTTP_PROTOCOL . $this->app_path . "index.php";
        $this->WWW_SITE_ROOT = $this->HTTP_PROTOCOL . $this->app_path;
        $this->UNSECURE_WWW_SITE_ROOT = "http" . $this->app_path;
    }

    public function getWWW_SITE_URL() {
        return $this->WWW_SITE_URL;
    }

    public function getWWW_SITE_ROOT() {
        return $this->WWW_SITE_ROOT;
    }

    public function getUNSECURE_WWW_SITE_ROOT() {
        return $this->UNSECURE_WWW_SITE_ROOT;
    }

}
