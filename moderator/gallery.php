<?php
require_once './includes.php';
require_once './mysql/mysql.php';
require_once './mysql/GalleryModel.php';
$userObj = new GalleryModel();
$page = isset($_REQUEST['pageno']) ? $_REQUEST['pageno'] - 1 : 0;
$perpage = 4;
if(!isset($_GET['pageno'])){
    $_SESSION['momname']='';
}
if (isset($_POST['momname'])) {
    $_SESSION['momname'] = $momname = $_POST['momname'];$page=1;
} else {
    $momname = isset($_SESSION['momname']) ? $_SESSION['momname'] : "";
}

$result = $userObj->getGallery($page, $perpage, $momname);
$totalcount = $userObj->getGalleryCount($momname);
?>

<!DOCTYPE HTML>
<html>
    <head id="<?php echo $totalcount; ?>">
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
        <meta property="og:image" content="http://thatswhatmomsaid.in/fbshare.jpg" />
        <meta name="twitter:image:src" content="http://thatswhatmomsaid.in/fbshare.jpg"/>
        <meta property="og:url" content="http://thatswhatmomsaid.in/gallery.php" />

        <link href="css/layout.css" rel="stylesheet" type="text/css">
        <link href="fonts/stylesheet.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="js/jquery-1.7.min.js"></script>
        <link href="fancybox/jquery.fancybox-1.3.4.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="fancybox/fancybox.js"></script>
        <script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    </head>

    <body>
        <?php
        echo clsMain::getGA_FBROOT();
        require_once './errordiv.php';
        require_once './js/vote.js.php';
        ?>
        <div class="wrapper">
            <div class="mainWrap">
                <header class="voteHeader"><a href="index.php"><img src="images/vanish_logo.png" alt=""></a>
                    <div class="titile2">
                        <h1>VOTE FOR FAVOURITE MOM ONE-LINERS</h1>
                        <p>TOP 3 WIN A SURPRISE GIFT*</p>
                    </div>

                </header>
                <section>

                    <div class="searchMain">
                        <div class="searchPart">
                            <form method="post" action="gallery.php">
                                <div class="inpBox">
                                    <input name="momname" id="momname" type="text" placeholder="search by name" value="<?php echo $momname; ?>">
                                </div>
                                <div class="searchButton">
                                    <input type="submit" value="SEARCH"/>
                                </div>
                            </form>
                        </div>
                        <div class="voteList">
                            <ul>
                                <?php
                                $path = UPLOAD_DIR . "/thumb/";
                                if ($result != FALSE) {

                                    $function = (isset($_SESSION['User']['social_user_id'])) ? "vote" : "fbLogin";
                                    while ($row = mysql_fetch_assoc($result)) {
                                        echo <<<EOT
                                          <li>
                                            <div class="imgPart">
                                                <a class="video_detail" href="pop_up_share_gallery.php?entry_id={$row['entry_id']}&finalimg={$row['videothumb']}">
                                                    <img src="$path{$row['videothumb']}" alt="">
                                                 </a></div>
                                            <div class="voteDetail">
                                                <h4>{$row['momname']}</h4>
                                                <div class="pinkButton"><a href="javascript:void(0);" onclick="$function('{$row['entry_id']}');" class="votenow">VOTE</a></div>
                                                <div class="voteRate">
                                                    <span>total votes</span><div class="likeBg" id="v_{$row['entry_id']}">{$row['vote_count']}</div>
                                                </div>
                                            </div>
                                        </li>
EOT;
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="pageIn">
                            <ul>
                                <span>PAGE</span>
                                <?php require_once 'pagination.php'; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="logo3"><img src="images/mom_said.png" alt=""></div>

                </section>

            </div>
            <div class="contentBox2 conVote">
                <div class="conMid">
                    <div class="conLeft2">
                        <h3>TOP 3 MOM ONE-LINERS</h3>
                        <ul>
                            <?php require_once './top3.php'; ?>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="footer">
                <div class="ftrInn">
                    <?php require_once './footer.php'; ?>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $(".voteList ul li").last().addClass('padd');
                });
            </script>

    </body>
</html>