<?php
require_once './includes.php';
$url = new URLConfig();
if (!isset($_SESSION['User']['social_user_id'])) {
    header("Location:index.php");
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title><?php echo "Welocme {$_SESSION['User']['user_name']}"; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
        clsMain::include_online_jquery();
        clsMain::include_fancybox();
        require_once 'jsfbhelper/socialshare.js.php';
        require_once './jsfbhelper/errordivhelper.php';
        ?>

    </head>
    <body>
        <?php
        clsMain::getGA_FBROOT();
        require_once './jsfbhelper/errordivhelper.php';
        echo "Welocme {$_SESSION['User']['user_name']}\n";
        ?>
        <div>
            <a href="javascript:fbinvite('Start');">FB Invite FB API 2.0 will not notify USER and user can check invites in app center</a> <br/>
            <a href="javascript:twittershare('#test','Start','<?php echo $url->getWWW_SITE_ROOT() ?>');">Share on Twitter</a> 
            <a href="javascript:fbshare('#test','Start','<?php echo $url->getWWW_SITE_ROOT() ?>','');">Share on FB</a> 
        </div>

        Tab / URL Like (URL Like)
        <?php echo socialSharing::getFBLikeSharePlugin('http://dotherex.com/'); ?>
        <br/>
        Auto Post
        <a href="javascript:autopost('#test','Start','<?php echo $url->getWWW_SITE_ROOT() ?>','');">FB Auto Post</a> 
        <br/>
        Photo Upload on Facebook
        <script src="jsfbhelper/fbphotoupload.js"></script>
        <a href="javascript:fbphotoupload('#test','20140515_170547.jpg','Start');">FB Photo Upload</a>
        <br/>
        Upload Photo from Facebook
        <?php require_once './jsfbhelper/getPhotosFromFB.js.php'; ?>
        <a href="javascript:void(0);" onclick="getPhotosFromFB('Start');">Upload Photo from Facebook</a>
        <div id="fbuploadedimg"></div>
    </body>
</html>


