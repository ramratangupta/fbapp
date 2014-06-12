<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.min.css" />
<?php require_once 'css/Style.css.php'; ?>
<script type="text/javascript" src="jsDatePick.jquery.min.1.3.js"></script>
<?php clsMain::include_online_jquery(); ?>
<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script src="js/jquery.tablesorter.min.js" type="text/javascript"></script>

<script type="text/javascript">
    //aqua,armygreen,bananasplit,beige,deepblue,greenish,lightgreen,ocean_blue,orange,peppermint,pink,purple,torqoise
    window.onload = function() {
        new JsDatePick({
            useMode: 2,
            target: "dateStart",
            dateFormat: "%Y-%m-%d",
            minDate: Date(2013, 07, 12),
            limitToToday: true, cellColorScheme: 'torqoise'
        });
        new JsDatePick({
            useMode: 2,
            target: "EndDate",
            dateFormat: "%Y-%m-%d",
            limitToToday: true, cellColorScheme: 'torqoise'
        });
    };

    $(document).ready(function() {

        $(".gridtable").find("tr:even").addClass("alt");
        $(".gridtable").tablesorter();
        $(".iframe").fancybox({
            'width': '70%',
            'height': '90%',
            'autoScale': false,
            'transitionIn': 'none',
            'transitionOut': 'none',
            'type': 'iframe'
        });
    });
</script>
