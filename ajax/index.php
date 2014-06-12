
<?php

session_start();
require './vendor/autoload.php';

$u = new User();
$u->name = "Ram";
var_dump($u);

Facebook\FacebookSession::setDefaultApplication('290012744506603', 'b6ffb229ffd81a993903ac134970692d');
$helper = new Facebook\FacebookRedirectLoginHelper("http://localhost/FacebookGraph2.0/index11.php", $apiVersion = NULL);
try {
    $session = $helper->getSessionFromRedirect();
} catch (Facebook\FacebookRequestException $ex) {
    // When Facebook returns an error
} catch (\Exception $ex) {
    // When validation fails or other local issues
}
if (isset($session)) {

    $request = new Facebook\FacebookRequest($session, 'GET', '/me');
    $response = $request->execute();
    $graphObject = $response->getGraphObject();
    var_dump($graphObject);



    // Upload to a user's profile. The photo will be in the
    // first album in the profile. You can also upload to
    // a specific album by using /ALBUM_ID as the path     
//    $response = (new FacebookRequest(
//            $session, 'POST', '/me/photos', array(
//        //'source' => new CURLFile('20140515_170547.jpg', 'image/jpg'),
//                'source' =>'@' . realpath('20140515_170547.jpg'),
//        'message' => 'User provided message'
//            )
//            ))->execute()->getGraphObject();
    // If you're not using PHP 5.5 or later, change the file reference to:
    // 'source' => '@/path/to/file.name'
    //echo "Posted with id: " . $response->getProperty('id');
} else {
    echo '<a href="' . $helper->getLoginUrl(array('email', 'publish_actions')) . '">Login with Facebook</a>';
}
