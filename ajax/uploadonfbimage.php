<?php

require_once '../vendor/autoload.php';
session_start();
if (isset($_SESSION['User']['social_user_id'], $_REQUEST['fb_upload_img_path'], $_REQUEST['imagecopy'])) {

    try {
        $session = new \Facebook\FacebookSession($_SESSION['User']['access_token']);
        //check user_photos permission
        /*
          //Use this code when server side permission check is required
          $response = (new \Facebook\FacebookRequest($session, 'GET', '/me/permissions'))->execute()->getGraphObject();
          $canUploadPhoto = false;
          foreach ($response->asArray() as $permission) {
          if ($permission->permission == 'user_photos' && $permission->status == 'granted') {
          $canUploadPhoto = true;
          break;
          }
          }
          if ($canUploadPhoto) {
          // Upload to a user's profile. The photo will be in the
          // first album in the profile. You can also upload to
          // a specific album by using /ALBUM_ID as the path
          $response = (new \Facebook\FacebookRequest(
          $session, 'POST', '/me/photos', array(
          //'source' => new CURLFile('20140515_170547.jpg', 'image/jpg'),
          'source' => '@' . realpath($_REQUEST['fb_upload_img_path']),
          'message' => $_REQUEST['imagecopy'] . " " . AppConfig::appBaseURL
          )
          ))->execute()->getGraphObject();
          // If you're not using PHP 5.5 or later, change the file reference to:
          // 'source' => '@/path/to/file.name'
          } else {
          echo 'permission';
          }
         */
        // Upload to a user's profile. The photo will be in the
        // first album in the profile. You can also upload to
        // a specific album by using /ALBUM_ID as the path
        $response = (new \Facebook\FacebookRequest(
                $session, 'POST', '/me/photos', array(
            //'source' => new CURLFile('20140515_170547.jpg', 'image/jpg'),
            'source' => '@' . realpath("../".$_REQUEST['fb_upload_img_path']),
            'message' => $_REQUEST['imagecopy'] . " " . AppConfig::appBaseURL
                )
                ))->execute()->getGraphObject();
        echo "done";
    } catch (Facebook\FacebookAuthorizationException $f) {
        echo 'session';
    } catch (Exception $ex) {
      echo $ex->getMessage();
    }
}