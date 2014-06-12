<?php

if (!strcasecmp(basename($_SERVER['SCRIPT_NAME']), basename(__FILE__)))
    die('Error');

class AppConfig {

    //FB App
    const appName = "Graph 2.0 Test";
    const appid = "290012744506603";
    const secret = "b6ffb229ffd81a993903ac134970692d";
    const appBaseURL = "https://apps.facebook.com/";
    //FB Page
    const pageid = "";
    const fbpage = "";
    const appTabLink = "";
    const domain = "ramratangupta.blogspot.in";
    //database
    const DB_PREFIX = "fbg";
    const DB_HOST = "localhost";
    const DB_USER = "root";
    const DB_PASS = "";
    const DB_NAME = "fbgraph2";
    //Ga code
    const GA_CODE = "UA-47162458-1";
    const PASSWORD_SALT = "sfdsdfdslfkjjk(*(*)(*809fdjdshjjj";
    const UPLOAD_DIR = "useruploads";
    const ORIGINAL_FILE_PATH = "orgfiles";
    const PROJECT_START_DATE = "2014-05-29";
    // below are key for https://www.facebook.com/solidigi FB account on bitly
    const BITLY_API_USER = "o_3d58at6os9";
    const BITLY_API_KEY = "R_8cfb46fa0aff4eec9578ae987398357a";
    //Errordive Helper color
    const ERRORDIV_MESSAGE_COLOR = "black";
    const BRAND_COLOR = "darkgrey";

}

date_default_timezone_set("Asia/Kolkata");
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('error_log', 'errorlog/' . date('M') . '_' . date("Y") . '_error.txt');
//ini_set('zlib.output_compression', 1);
set_time_limit(600);
