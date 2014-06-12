<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    @charset "utf-8";
    body {
        margin:0; padding:0; font:normal 12px/16px Arial, Helvetica, sans-serif;
    }
    img {
        border:0px;
    }
    h1, h2, h3, h4, h5, h6, span, p, a, ol, li, ul {
        margin:0px;
        padding:0px;
    }
    .error{color: red;font-size:13px;}

    .login_toppart{height:200px;border-bottom: #fff 3px solid;}

    .login_toppart h1{  font-size:30px; color:<?php echo AppConfig::BRAND_COLOR; ?>; padding:22px 0 0 99px;text-align: center;}
    .login_text{font-size:13px; color:#959595;}
    input{border: 1px <?php echo AppConfig::BRAND_COLOR; ?> solid;padding: 5px;color: <?php echo AppConfig::BRAND_COLOR; ?>;}


    a {color:#0096DC;}

    #wrapper {
        width:100%; margin:0 auto; background:#fff;
    }
    .menu {
        background:<?php echo AppConfig::BRAND_COLOR; ?>; color:#fff; padding:5px 7px;margin-left: 200px;
        margin-top: 38px;
    }
    .menu a {
        color:#fff; text-decoration:none; line-height:27px; font:bold 14px Arial, Helvetica, sans-serif; padding:0 5px; line-height:28px;
    }
    #report{
        padding: 10px;background:<?php echo AppConfig::BRAND_COLOR; ?>; color:#fff;
    }
    #form_control{background: #959595; padding: 10px;}
    /*Style Pageing*/
    .tableSelector{background: #EFEFEF; }
    .tableSelector td{ font-size:13px; font-weight:bold; padding: 8px 10px;}
    .tableSelector td label{ font-size:13px; font-weight:bold; margin-right:10px;}
    .tableSelector .txtfield{ border:#d2d2d2 1px solid; border-radius:4px; -moz-border-radius:4px; padding:5px 8px;}

    .button{color:#ffffff; background-color:<?php echo AppConfig::BRAND_COLOR; ?>; padding:5px; font-weight:bold; font-size:13px; border:none; border-radius:4px; -moz-border-radius:4px;}

    .gridtable{ background-color:#dfdfdf;}
    .gridtable td{ color:#000; background-color:#FFF;}
    .gridtable tr.alt td{ color:#000; background-color:#f3f3f3;}
    .gridtable tr:hover td,.gridtable tr.alt:hover td{ color:#000; background-color:#cccccc;}
    .gridtable .heading{ color:#ffffff; background-color:<?php echo AppConfig::BRAND_COLOR; ?>; font-size:13px; font-weight:bold;}
    .gridtable thead tr th {background-image: url(./img/bg.gif);
                            background-repeat: no-repeat;
                            background-position: center right;
                            cursor: pointer;padding-right: 20px;}
</style>