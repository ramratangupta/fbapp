<?php

require_once '../vendor/autoload.php';
session_start();
$userObj = new User();
$userObj->saveInvitesData($_POST);
$userObj->dbClose();
