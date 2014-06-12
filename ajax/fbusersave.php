<?php

require_once '../vendor/autoload.php';
session_start();
try {

    $data['social_user_id'] = $_POST['id'];
    $data['user_name'] = $_POST['name'];
    $data['email_id'] = (!empty($_POST['email'])) ? $_POST['email'] : '';
    if (isset($_POST['location']['name'])) {
        $data['user_location'] = $_POST['location']['name'];
    } else {
        $data['user_location'] = "";
    }
    if ($_POST['gender'] == 'male')
        $data['sex'] = 'M';
    else
        $data['sex'] = 'F';
    $data['user_type'] = $_REQUEST['user_type'];
    $userObj = new User();
    $row = $userObj->save($data);
    $row['user_type'] = $data['user_type'];
    $_SESSION['User'] = $row;

    if (isset($_REQUEST['access_token'], $_REQUEST['expiresIn'])) {
        $_SESSION['User']['access_token'] = $_REQUEST['access_token'];
        $_SESSION['User']['expiresIn'] = $_REQUEST['expiresIn'];
        $_SESSION['User']['sessioen_create_at'] = time();
    }
    $userObj->createUserLog();
    $userObj->dbClose();
    echo "done";
} catch (Exception $ex) {
    echo 'reload';
}