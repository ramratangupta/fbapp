<?php

require_once '../includes/AppConfig.php';
$moderator_password = 'localhost';
$admin = "admin";
if ($moderator_password == "") {
    die('Please define moderator password in this file');
}
$form = <<<EOL
 <form id='login' action='sql.php' method="post">
    Please enter user id and password defiend in this file
            <table width="68%" border="0" cellspacing="0" cellpadding="0" align="center">

                <tr>
                    <td class="login_text"><span class='error'></span>User</td>
                    <td><input type='text' name='username' id='username' maxlength="50" class="input" /></td>
                    <td id='login_username_errorloc' class='error'></td>
                    <td  class="login_text">Password</td>
                    <td><input type='password' name='password' id='password' maxlength="50"  class="input" /></td>
                    <td id='login_password_errorloc' class='error'></td>
                    <td><input type='submit' name='Submit' value='Submit' class="button"/></td>
                </tr>
            </table> </form>
EOL;
if (isset($_POST['username'], $_POST['password'])) {
    if ($admin == $_POST['username'] && $moderator_password == $_POST['password']) {
        $project_sql = array(
            "CREATE TABLE IF NOT EXISTS `" . AppConfig::DB_PREFIX . "_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(40) NOT NULL,
  `is_active` enum('Y','N') NOT NULL DEFAULT 'Y',
  `user_type` enum('A') NOT NULL COMMENT 'A=>admin',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8",
            "INSERT INTO `" . AppConfig::DB_PREFIX . "_admin` (`id`, `username`, `password`, `is_active`, `user_type`, `created_on`) VALUES
(1, '" . $admin . "', '" . sha1(AppConfig::PASSWORD_SALT . $moderator_password) . "', 'Y', 'A', '" . date("Y-m-d H:i:s") . "')",
            "CREATE TABLE IF NOT EXISTS `" . AppConfig::DB_PREFIX . "_users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `social_user_id` varchar(20) NOT NULL,
  `user_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `user_location` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` enum('Y','N') NOT NULL DEFAULT 'Y',
  `created_on` datetime NOT NULL,
  `user_type` enum('F','M','W') NOT NULL DEFAULT 'F' COMMENT 'F->Facebook, M-Microsite, W-Wap site',
  `sex` enum('F','M') NOT NULL DEFAULT 'M',
  PRIMARY KEY (`user_id`),
  KEY `social_user_id_active` (`is_active`,`social_user_id`),
  KEY `email_id` (`email_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8",
            "CREATE TABLE IF NOT EXISTS `" . AppConfig::DB_PREFIX . "_users_logs` (
  `users_logs_id` int NOT NULL AUTO_INCREMENT,
  `fk_user_id` int NOT NULL,
  `user_ip` varchar(16) NOT NULL,
  user_type enum('F','M','W') NOT NULL DEFAULT 'F' COMMENT 'F->Facebook, M-Microsite, W-Wap site',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`users_logs_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8",
            "CREATE TABLE IF NOT EXISTS `" . AppConfig::DB_PREFIX . "_users_invites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `social_user_id` varchar(20) NOT NULL,
  `freind_fb_id` varchar(20) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8"
        );
        mysql_connect(AppConfig::DB_HOST, AppConfig::DB_USER, AppConfig::DB_PASS);
        $create_db = "create database if not exists " . AppConfig::DB_NAME;
//create the database
        $result = mysql_query($create_db);
        if ($result) {
            echo "Database created <br>Query Executed";
            echo '<hr/>';
            mysql_select_db(AppConfig::DB_NAME);
            foreach ($project_sql as $sql) {
                $test = mysql_query($sql);
                echo $sql . "<br>";
                if (!$test)
                    echo mysql_error();
                else
                    echo "Query Executed";
                echo '<hr/>';
            }
        }else {
            echo "Error has been occured for database creation";
            echo mysql_error();
        }
        echo "<br/> Creating Upload Dir";
        chdir("..");
        mkdir('error_log',0755);
        mkdir(AppConfig::UPLOAD_DIR, 0755);
        chdir(AppConfig::UPLOAD_DIR);
        mkdir(AppConfig::ORIGINAL_FILE_PATH, 0755);
        mkdir('thumb', 0755);
        echo "<br/> Creating Upload Dir - Done";
        die;
    }
}
echo $form;
