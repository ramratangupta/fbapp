<?php require_once './includes.php'; 
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php clsMain::include_online_jquery(); ?>
        <script src="jsfbhelper/fblogin.js"></script>
    </head>
    <body>
        <?php
        clsMain::getGA_FBROOT();
        require_once './jsfbhelper/errordivhelper.php';
        ?>
        <div><a href="javascript:fbLogin('start','M');">FB Login</a></div>
    </body>
</html>
