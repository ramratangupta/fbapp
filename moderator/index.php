<?php
require_once './includes.php';
require_once 'indexlogic.php';
?>
<!DOCTYPE HTML>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Vanish Mother’s Day</title>
        <meta name="description" content="That’s what my mom used to say! Create your own Mom’N’Me video and share what your mom said."/>
        <meta property="og:title" content="Vanish Mother’s Day" />
        <meta property="og:type" content="website" />

        <meta property="og:description" content="That’s what my mom used to say! Create your own Mom’N’Me video and share what your mom said." />
        <meta name="twitter:card" content="summary_large_image"/>
        <meta name="twitter:site" content="@VanishIndia"/>
        <meta name="twitter:title" content="Vanish Mother’s Day"/>
        <meta name="twitter:description" content="That’s what my mom used to say! Create your own Mom’N’Me video and share what your mom said."/>
        <?php
        $entry = false;
        if (isset($_REQUEST['id'])) {
            $entry = $userObj->getSingleEntry($_REQUEST['id']);
            $path = UPLOAD_DIR . "/fbshare/";

            echo <<<EOT
        <meta property="og:image" content="http://thatswhatmomsaid.in/$path{$entry['videothumb']}" />
        <meta name="twitter:image:src" content="http://thatswhatmomsaid.in/$path{$entry['videothumb']}"/>
        <meta property="og:url" content="http://thatswhatmomsaid.in/index.php?id={$entry['entry_id']}" />
EOT;
        } else {
            echo <<<EOT
        <meta property="og:image" content="http://thatswhatmomsaid.in/fbshare.jpg" />
        <meta name="twitter:image:src" content="http://thatswhatmomsaid.in/fbshare.jpg"/>
        <meta property="og:url" content="http://thatswhatmomsaid.in/index.php" />
EOT;
        }
        ?>
        <link href="css/layout.css" rel="stylesheet" type="text/css">
        <link href="fonts/stylesheet.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="js/jquery-1.7.min.js"></script>
        <link href="fancybox/jquery.fancybox-1.3.4.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="fancybox/fancybox.js"></script>

        <script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>

        <style type="text/css">  
            ::-webkit-input-placeholder { color:#D60070; }
            ::-moz-placeholder { color:#D60070; } /* firefox 19+ */
            :-ms-input-placeholder { color:#D60070; } /* ie */
            input:-moz-placeholder { color:#D60070; }
        </style> 
    </head>

    <body>
        <?php
        echo clsMain::getGACode();
        require_once 'errordiv.php';
        ?>
        <div class="wrapper">
            <div class="mainWrap">
                <header><a href="index.php"><img src="images/vanish_logo.png" alt=""></a></header>
                <section>
                    <div class="videoPart"><a href="video_page.php" class="large_video"><img src="images/video.png" alt=""></a></div>
                    <div class="rightContent">
                        <div class="logo2"><img src="images/mom_said.png" alt=""></div>
                        <div class="titile">
                            <h1>THIS MOTHER'S DAY</h1>
                            <p>CREATE YOUR OWN MOM'N'ME VIDEO<br>
                             &amp; WE WILL SEND HER A FREE PERSONALISED POSTCARD.</p>
                        </div>
                        <div id="main">
                            <ul class="gallery">
                                <li id="replaceImage1"><img src="images/banner_small_one.png" data="1" /></li>
                                <li id="replaceImage2"><img src="images/banner_small_two.png" data="2" /> </li>
                                <li id="replaceImage3"><img src="images/banner_small_three.png" data="3" /> </li>
                                <li id="replaceImage4"><img src="images/banner_small_four.png" data="4" /> </li>
                            </ul>
                        </div>
                        <div class="subContent">
                            WHEN DID SHE SAY?
                        </div>
                    </div>
                </section>

            </div>
            <div class="contentBox2">
                <div class="conMid">
                    <div class="conLeft">
                        <h3>TOP 3 MOM ONE-LINERS ALSO WIN SURPRISE VOUCHERS!</h3>
                        <ul>
                            <?php require_once './top3.php'; ?>
                        </ul>
                        <div class="buttonBox">
                            <a href="gallery.php">VOTE NOW</a>
                        </div>
                    </div>
                    <div class="conRight">
                        <form method="post" enctype='multipart/form-data' id="frm" name="frm">
                            <input type="hidden" name="themeId" value="0" id="themeId"/>
                            <div class="rowForm1">
                                <textarea maxlength="100" name="comment" id="comment" cols="" rows="" placeholder="What did she say?"></textarea>
                            </div>
                            <div class="uploadPart">
                                <p>Upload your  picture</p>
                                <input name="userPic" id="userPic" type="file" accept="*/images" class="uploadImg">
                            </div>
                            <div class="uploadPart">
                                <p>Upload a picture of your mom </p>
                                <input name="momPic" id="momPic" type="file" accept="*/images" class="uploadImg">
                            </div>
                            <div class="buttonBox button2">
                                <input type="submit" name="name" id="name" value="SUBMIT" onclick="javascript:return validate();"/>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="footer">
                <div class="ftrInn">
                    <?php require_once './footer.php'; ?>
                </div>

            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('ul.gallery li img').hover(function()
                {
                    $(this).css({'z-index': '10'});
                    $(this).stop(true, true).animate({
                        marginTop: '-14px',
                        marginLeft: '-11px',
                        width: '168px',
                        height: '188px'
                    }, 300);
                }, function() {
                    $(this).css({'z-index': '0'});
                    if ($(this).attr('class') != 'active') {
                        $(this).stop(true, true).animate({
                            marginTop: '0',
                            marginLeft: '0',
                            width: '138px',
                            height: '158px'
                        }, 300);
                    }
                });

<?php
if ($entry != false) {
    echo <<<EOT
        $.fancybox({
        'padding': 0,
        'margin': 0,
        'width': 775.0,
        'height': 355.0,
        'autoScale': false,
        'transitionIn': 'none',
        'transitionOut': 'none',
        'type': 'iframe','showCloseButton': false,
        'onClosed':function(){location.href="index.php"},
        'href':'pop_up_share_gallery.php?entry_id={$entry['entry_id']}&finalimg={$entry['videothumb']}'});
EOT;
}
?>
            });
            function  validate() {
                if ($("#themeId").val() == '0') {
                    showErrorPop("Please select the theme");
                    return false;
                } else
                if ($.trim($("#comment").val()) == '') {
                    showErrorPop("Please enter the comment");
                    return false;
                } else
                if ($("#comment").length > 50) {
                    showErrorPop("Please enter the comment less than 75 characters");
                    return false;
                }
                if ($.trim($("#userPic").val()) == '' && $.trim($("#momPic").val()) == '') {
                    showErrorPop("Please upload atleast one  pic");
                    return false;
                }
                showErrorPop("Please wait...");
                return true;
            }
            var browserName = navigator.appName;
            if (browserName !== "Microsoft Internet Explorer")
            {
                $(".uploadImg").change(function() {
                    var ext = $(this).val().split('.').pop().toLowerCase();
                    if ($.inArray(ext, ['png', 'jpg', 'jpeg', 'JPG', 'PNG', 'JPEG']) == -1) {
                        showErrorPop('Invalid file format use only jpg,jpeg,png');
                        $(this).val("");
                        return false;
                    }
                    if (this.files[0].size > (1048576 * 4))
                    {
                        showErrorPop("Image size should be smaller than 4MB.");
                        $(this).val("");
                        return false;
                    }
                });
            }
            $(document).ready(function() {
                $("#main .gallery li img").click(function() {
                    $(".gallery li img").removeClass("active");
                    $(".gallery li img").stop(true, true).animate({
                        marginTop: '0',
                        marginLeft: '0',
                        width: '138px',
                        height: '158px'
                    }, 0);
                    $(this).addClass("active");
                    $(this).stop(true, true).animate({
                        marginTop: '-14px',
                        marginLeft: '-11px'
                    }, 0);
                    resetImages();
                    $("#themeId").val($(this).attr('data'));

                });

                function resetImages(){
                    $('#replaceImage1 img').attr("src","images/banner_small_one.png");
                    $('#replaceImage2 img').attr("src","images/banner_small_two.png");
                    $('#replaceImage3 img').attr("src","images/banner_small_three.png");
                    $('#replaceImage4 img').attr("src","images/banner_small_four.png");
                };

                $('#replaceImage1 img').hover(function () {
                    $(this).attr("src","images/banner_small_one_h.png");
                }, function () {
                    if(!$(this).hasClass("active")){
                        $(this).attr("src","images/banner_small_one.png");    
                    }
                }).click(function () {
                    $(this).attr("src","images/banner_small_one_h.png");
                });

                $('#replaceImage2 img').hover(function () {
                    $(this).attr("src","images/banner_small_two_h.png");
                }, function () {
                    if(!$(this).hasClass("active")){
                        $(this).attr("src","images/banner_small_two.png");
                    }
                }).click(function () {
                    $(this).attr("src","images/banner_small_two_h.png");
                });

                $('#replaceImage3 img').hover(function () {
                    $(this).attr("src","images/banner_small_three_h.png");
                }, function () {
                    if(!$(this).hasClass("active")){
                        $(this).attr("src","images/banner_small_three.png");
                    }
                }).click(function () {
                    $(this).attr("src","images/banner_small_three_h.png");
                });

                $('#replaceImage4 img').hover(function () {
                    $(this).attr("src","images/banner_small_four_h.png");
                }, function () {
                    if(!$(this).hasClass("active")){
                        $(this).attr("src","images/banner_small_four.png");
                    }
                }).click(function () {
                    $(this).attr("src","images/banner_small_four_h.png");
                });


<?php if ($err == 'none') {
    ?>
                    showErrorPop("Please wait...");
                    $.ajax({url: "create_img.php?id=<?php echo $_SESSION['entry_id']; ?>"}).done(function() {
                        hideErrorPop();
                        $.fancybox({
                            'padding': 0,
                            'margin': 0,
                            'width': 775.0,
                            'height': 355.0,
                            'autoScale': false,
                            'transitionIn': 'none',
                            'transitionOut': 'none',
                            'type': 'iframe',
                            'hideOnOverlayClick': false,
                            'hideOnContentClick': false,
                            'showCloseButton': false,
                            'href': 'pop_up.php'
                        });
                    });

    <?php
}
//else {
//
//    echo "showErrorPop('" . $err . "');";
//}
?>
            });

        </script>
        <style>
            .active{
                marginTop: -14px !important;
                marginLeft: -11px !important;
                width: 168px !important;
                height: 188px !important;
                z-index: 10 !important;
            }

        </style>
    </body>
</html>