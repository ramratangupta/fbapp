<div class="loginpopup">
    <div class="login_toppart" style="background:url('img/logo.jpg'); background-repeat:repeat-y;">
        <br /><br />
        <h1><?php echo AppConfig::appName;
if (!isset($_SESSION['UserAdmin'])) echo 'Login' ?></h1><br />
       
        <?php
        if (isset($_SESSION['UserAdmin'])) {
            echo '<div class="menu"> <a href="userinfo.php">Users</a>
               <a href="logout.php">Sign Out</a>
        </div>';
        }
        ?>
    </div></div>