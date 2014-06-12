<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../vendor/autoload.php';
session_start();
if (isset($_POST['fbpicid'], $_SESSION['User']['social_user_id'])) {
    $temp_file_name = $_SESSION['User']['social_user_id'] . "_" . time() . ".jpg";
    $path = AppConfig::UPLOAD_DIR . '/' . AppConfig::ORIGINAL_FILE_PATH . '/' . $temp_file_name;
    $fbimg = 'https://graph.facebook.com/' . $_REQUEST['fbpicid'] . '/picture?access_token=' . $_SESSION['User']['access_token'];

    $fileData = file_get_contents($fbimg);
    chdir("..");
    $fp = fopen($path, 'w');
    fwrite($fp, $fileData);
    fclose($fp);
    $path = AppConfig::UPLOAD_DIR . '/thumb/' . $temp_file_name;
    $fbimg = 'https://graph.facebook.com/' . $_REQUEST['fbpicid'] . '/picture?type=album&access_token=' . $_SESSION['User']['access_token'];
    $fileData = file_get_contents($fbimg);
    $fp = fopen($path, 'w');
    fwrite($fp, $fileData);
    fclose($fp);
    unset($fileData);
    echo $temp_file_name;
}
