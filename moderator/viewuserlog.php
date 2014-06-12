<?php
session_start();
require_once('../includes/config.php');
require_once('../utility/writeLog.php');
require_once('../utility/clsMain.php');
require_once('../mysql/mysql.php');
require_once('admin.php');
if (!isset($_SESSION['UserAdmin'])) {
    header("Location: index.php");
    exit;
}
$dbobj = new Admin();
$logsstr = "";
$name = "";
$date = "";
if (isset($_REQUEST['startdate'], $_REQUEST['enddate'], $_REQUEST['name'], $_REQUEST['userid'])) {
    $name = $_REQUEST['name'];
    $date = clsMain::formatedateIndian($_REQUEST['startdate']) . " || " . clsMain::formatedateIndian($_REQUEST['enddate']);

    $rows = $dbobj->getUserLogList($_REQUEST['startdate'], $_REQUEST['enddate'], $_REQUEST['userid']);
    $i = 0;
    $visitType = array('M' => 'Microsite', 'F' => 'Facebook','W'=>'Mobile/Tablet');
    if ($rows != false) {
        while ($row = $dbobj->dbFetchArray($rows)) {
            $logsstr.='<tr>
                        <td>' . ++$i . '</td>
                        <td>' . $row['user_ip'] . '</td> 
                            <td>' . $visitType[$row['user_type']] . '</td> 
                        <td colspan="2">' . clsMain::formatedDate_TimeIndian($row['created_on']) . '</td>
                       </tr>';
        }
    }
    $name.=" | Total Log Count is : " . $i;
}
?>
<link rel="stylesheet" type="text/css" media="all" href="css/Style.css" />
<script type="text/javascript" src="../js/jquery.min.js"></script>
<table border="0" cellpadding="4" cellspacing="1" class="gridtable" width="100%" style="font-size: 12px;font-family:arial;">
    <tr>
        <td>User Name</td>
        <td><?php echo $name; ?></td>
        <td>User's Logs between</td>
        <td><?php echo $date; ?></td>

    </tr>
    <tr>
        <th>S. No.</th>
        <th>User IP</th>
         <th>Entry Type</th>
        <th>Visit Date</th>
    </tr>
    <?php echo $logsstr; ?>

</table>
<script type="text/javascript">
    $(document).ready(function (){
        $(".gridtable").find("tr:even").addClass("alt");
    });
</script>