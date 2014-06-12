
<div class="loginpopup">
    <div class="login_toppart" style="background:url('img/logo.jpg'); background-repeat:repeat-y;">
        <br /><br />
        <h1>Vanish Mother’s Day <?php if (!isset($_SESSION['UserAdmin'])) echo 'Login' ?></h1><br />
        <h1><?php echo ''; ?></h1>
        <?php
       if (isset($_SESSION['UserAdmin'])) {
           echo '<div class="menu"> <a href="userinfo.php">Users</a> <a href="entries.php">Vanish Entries</a>
               <a href="../useruploads/compressed.zip">Vanish Entries Post Card Download</a>
               <a href="logout.php">Sign Out</a>
        </div>';
          }?>
    </div></div>