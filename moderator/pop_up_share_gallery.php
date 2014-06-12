<?php
require_once './includes.php';
require_once './utility/socialSharing.php';
$url = clsMain::bitly_short_url(WWW_SITE_ROOT . "index.php?id=" . $_REQUEST['entry_id']);
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Vanish Share Video Gallery Pop-up</title>
        <link href="css/layout.css" rel="stylesheet" type="text/css">
        <link href="fonts/stylesheet.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="js/jquery-1.7.min.js"></script> 
        <style type="text/css" media="screen">
            html, body { height:100%; background-color: #ffffff;}
            body { margin:0; padding:0; overflow:hidden; }
            #flashContent { width:100%; height:100%; }
            .video_pop img{cursor: pointer;}
        </style>
    </head>
    <body style="background:none;">
        <?php echo clsMain::getGA_FBROOT();
        ?>
        <div class="main_pop" id="defalutDiv">
            <div class="video_pop">
                <img src="useruploads/final/<?php echo $_REQUEST['finalimg']; ?>" width="282" height="190"/>
                <div class="playIcon"><img src="images/play_icon.png" lt=""></div>

            </div>

            <div class="right_pop_share">
                <h1>SHARE ON :</h1>


                <a href="javascript:void(0);" onclick="fbshare('That’s what my mom used to say! Create your own Mom’N’Me video and share what your mom said.', 'pop up share', '<?php echo $url; ?>', '<?php echo $_REQUEST['finalimg']; ?>', false);"><img src="images/share_on_facebook.jpg" /></a>
                <a href="javascript:void(0);" onclick="twittershare('Watch what my mom used to say and make your own Mom’N’Me video! #ThatsWhatMomSaid', 'pop up share', '<?php echo $url; ?>');"><img src="images/share_on_tweet.jpg" /></a>
                <?php echo socialSharing::getFBLikeSharePlugin(); ?>
                <?php
                $function = (isset($_SESSION['User']['social_user_id'])) ? "vote" : "fbLogin";
                 
                echo <<<EOT
                <div class="voteDetail">
                                               
                                                <div class="pinkButton"><a href="javascript:void(0);" onclick="$function('{$_REQUEST['entry_id']}');" class="votenow">VOTE</a></div>
                                                <div class="voteRate">
                                                    <span>total votes</span><div class="likeBg" id="v_{$row['entry_id']}">{$row['vote_count']}</div>
                                                </div>
                                            </div>
EOT;
                ?>
                <div class="crossBox"><a href="javascript:void(0);" onclick="parent.$.fancybox.close();"><img src="fancybox/fancy_close.png" width="46" height="46"/></a></div>
            </div>
        </div>
        <div class="main_pop" id="videoDiv"  style="display: none;">

            <div id="flashContent">
                <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="100%" height="100%" id="vanishplayer" align="middle">
                    <param name="movie" value="vanishplayer.swf" />
                    <param name="quality" value="high" />
                    <param name="bgcolor" value="#ffffff" />
                    <param name="play" value="true" />
                    <param name="loop" value="true" />
                    <param name="wmode" value="window" />
                    <param name="scale" value="showall" />
                    <param name="menu" value="true" />
                    <param name="devicefont" value="false" />
                    <param name="flashvars" value="image=" />
                    <param name="salign" value="" />
                    <param name="flashvars" value="image=<?php echo $_REQUEST['finalimg']; ?>" />
                    <param name="allowScriptAccess" value="sameDomain" />
                    <!--[if !IE]>-->
                    <object type="application/x-shockwave-flash" data="vanishplayer.swf" width="100%" height="100%">
                        <param name="movie" value="vanishplayer.swf" />
                        <param name="quality" value="high" />
                        <param name="bgcolor" value="#ffffff" />
                        <param name="play" value="true" />
                        <param name="loop" value="true" />
                        <param name="wmode" value="window" />
                        <param name="scale" value="showall" />
                        <param name="menu" value="true" />
                        <param name="devicefont" value="false" />
                        <param name="salign" value="" />
                        <param name="flashvars" value="image=<?php echo $_REQUEST['finalimg']; ?>" />
                        <param name="allowScriptAccess" value="sameDomain" />
                        <!--<![endif]-->
                        <a href="http://www.adobe.com/go/getflash">
                            <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
                        </a>
                        <!--[if !IE]>-->
                    </object>
                    <!--<![endif]-->
                </object>
            </div>


        </div>
        <?php require_once 'js/socialshare.js.php'; ?>
        <script type="text/javascript">
            function videoclose() {
                $("#videoDiv").hide();
                $("#defalutDiv").show();

            }
            $(document).ready(function() {
                $(".video_pop img").click(function() {
                    $("#videoDiv").show();
                    $("#defalutDiv").hide();

                });

            });</script>
    </body>
</html>
