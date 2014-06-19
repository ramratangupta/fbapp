<?php

if (!strcasecmp(basename($_SERVER['SCRIPT_NAME']), basename(__FILE__)))
    die('Error');

class AppConfig {

    /**
     * App title
     */
    const appName = "";

    /**
     * FB App id
     * @link https://developers.facebook.com/apps get it from here
     */
    const appid = "";

    /**
     * FB app secret
     * @link https://developers.facebook.com/apps get it from here
     */
    const secret = "";

    /**
     * Canvas page link like https://apps.facebook.com/<appnamespace>
     * @link https://developers.facebook.com/apps/<appid>/settings/ and look for Namespace
     */
    const appBaseURL = "";
    //FB Page
    /**
     * FB page id for brand
     */
    const pageid = "";

    /**
     * FB page URL
     */
    const fbpage = "";

    /**
     * Facebook app tab link like https://www.facebook.com/<FBpage>/app_<appid>
     */
    const appTabLink = "";

    /**
     * domain name no www or http for Google univarsal analytics code
     */
    const domain = "";
    //database
    /**
     * A prefix to database tables
     */
    const DB_PREFIX = "";

    /**
     * Database host name default is localhost
     */
    const DB_HOST = "localhost";

    /**
     * Database user name
     */
    const DB_USER = "";

    /**
     * Database user password
     */
    const DB_PASS = "";

    /**
     * Database name
     */
    const DB_NAME = "";

    /**
     * GA code account id like UA-47162458-1
     */
    const GA_CODE = "";

    /**
     * A random value string for encryption and moderator password generator
     */
    const PASSWORD_SALT = "aads(**Iikasjkdsakk";

    /**
     * A folder in which user can upload images and etc with 755 permission
     */
    const UPLOAD_DIR = "useruploads";

    /**
     * this folder is under ORIGINAL_FILE_PATH to contain orginal files
     */
    const ORIGINAL_FILE_PATH = "orgfiles";

    /**
     * This is used in report geration for moderator
     */
    const PROJECT_START_DATE = "";

    /**
     * Short long url to bitly short URL api user key
     * @link https://bitly.com/a/your_api_key get your api user key
     */
    const BITLY_API_USER = "";

    /**
     * Short long url to bitly short URL api key
     * @link https://bitly.com/a/your_api_key get your api key
     */
    const BITLY_API_KEY = "";
   
    /**
     * Error popup test color for function showErrorPop() in file jsfbhelper/developer.js
     */
    const ERRORDIV_MESSAGE_COLOR = "black";
    /**
     * The brand color for background color in showErrorPop() function and moderator color
     */
    const BRAND_COLOR = "darkgrey";
    /**
     * full application folder name without www/http and should ends with / like localhost/fold1/fold2/
     */
    const APP_FOLDER_NAME="";

}

date_default_timezone_set("Asia/Kolkata");
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('error_log', 'errorlog/' . date('M') . '_' . date("Y") . '_error.txt');
//ini_set('zlib.output_compression', 1);
set_time_limit(600);
