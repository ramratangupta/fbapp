<?php
require_once './includes.php';
$fgmembersite = new Admin();

if (isset($_SESSION["UserAdmin"])) {
    header("Location: userinfo.php");
}
if (isset($_POST['username'], $_POST['password'])) {

    try {
        $_POST['password'] = sha1(AppConfig::PASSWORD_SALT . $_POST['password']);

        if ($fgmembersite->login($_POST['username'], $_POST['password'])) {
            $_SESSION["UserAdmin"] = $_POST;
            header("Location: userinfo.php");
            exit;
        } else {
            $error = "Invaild username and password.";
        }
    } catch (Exception $e) {

        error_log($e);
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Login</title>
        
            <?php require_once 'css/Style.css.php'; ?>
            <script type='text/javascript' src='js/gen_validatorv4.js'></script>
    </head>
    <body style="background-color:#f0f0f0;">

        <?php include_once("header.php"); ?>

        <br />
        <form id='login' action='index.php' method="post">
            <table width="68%" border="0" cellspacing="0" cellpadding="0" align="center">

                <tr>
                    <td class="login_text"><span class='error'><?php if (isset($error)) echo $error; ?></span>Email</td>
                    <td><input type='text' name='username' id='username' maxlength="50" class="input" /></td>
                    <td id='login_username_errorloc' class='error'></td>
                    <td  class="login_text">Password</td>
                    <td><input type='password' name='password' id='password' maxlength="50"  class="input" /></td>
                    <td id='login_password_errorloc' class='error'></td>
                    <td><input type='submit' name='Submit' value='Submit' class="button"/></td>
                </tr>
            </table> </form>


        <script type='text/javascript'>
            // <![CDATA[

            var frmvalidator = new Validator("login");
            frmvalidator.EnableOnPageErrorDisplay();
            frmvalidator.EnableMsgsTogether();
            frmvalidator.addValidation("username", "req", "Please provide your username");
            frmvalidator.addValidation("password", "req", "Please provide the password");

            // ]]>
        </script>

    </body>
</html>