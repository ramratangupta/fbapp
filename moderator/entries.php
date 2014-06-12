<?php
session_start();
require_once('../includes/define.php');
require_once '../includes/config.php';
require_once('../utility/clsMain.php');
require_once('../mysql/mysql.php');
require_once('admin.php');
if (!isset($_SESSION['UserAdmin'])) {
    header("Location: index.php");
    exit;
}
if (isset($_REQUEST['excal'])) {
    $startdate = $_REQUEST['date1'];
    $enddate = $_REQUEST['date2'];
    header('Location:downloadexcel.php?option=vanish_postcard&start=' . $startdate . '&end=' . $enddate);
}

$dbobj = new Admin();
if (isset($_REQUEST['action'])) {
    mysql_query("update vanish_entries set isactive='" . $_REQUEST['action'] . "' where entry_id=" . $_REQUEST['id']);
}
$i = 0;
$p = 0; //Page
$startdate = PROJECT_START_DATE;
$enddate = clsMain::GetCurrentDate();
if (isset($_GET['p'])) {
    $p = $_GET['p'];
    $i = $p * 30;
}
if (isset($_GET['start']) && isset($_GET['end'])) {
    $startdate = $_GET['start'];
    $enddate = $_GET['end'];
}
if (isset($_REQUEST['date1'], $_REQUEST['date2'])) {
    $startdate = $_REQUEST['date1'];
    $enddate = $_REQUEST['date2'];
}
$start = mysql_real_escape_string(trim($startdate));
$end = mysql_real_escape_string(trim($enddate));
$sql = "SELECT e.*,count(v.vote_id) vote_count  "
        . "FROM `vanish_entries` e left join vanish_entries_vote v on e.entry_id = v.entry_id "
        . "where e.isfinal='Y'  and e.created_on BETWEEN '" . $start . " 00:00:00' AND '" . $end . " 23:59:59' group by e.entry_id order by entry_id desc limit " . ($p * 30) . ",30";
$rows = $dbobj->dbQuery($sql);

$sql = "SELECT count(*)total_entry FROM `vanish_entries` where isfinal='Y' and created_on BETWEEN '" . $start . " 00:00:00' AND '" . $end . " 23:59:59'";

$rs = mysql_query($sql);
if ($rs) {
    $count = mysql_fetch_assoc($rs);
    $userCount = $count['total_entry'];
} else {
    $userCount = 0;
}
$dataHTML = '';
$pagingHTML = '';
$actions = array("Y"=>"Deactivate","N"=>"Activate");
if ($rows != false) {
    $dataHTML = '<thead><tr>
                <th>Serial No.</th>
                <th>User Pic</th>
                <th>Mom Pic</th>
                <th>Mom Name</th>
                 <th>Mom Said</th>
                <th>Template</th>
                <th>Address</th>
                <th>Vote Count</th>
                <th>Date</th>
                 <th>Post Card</th>
               <th>Action</th>
             </tr></thead><tbody>';
    while ($row = $dbobj->dbFetchArray($rows)) {
        $action = ($row['isactive'] == "Y") ? "N" : "Y";
        
        $dataHTML.='
    <tr>
        <td>' . ++$i . '</td>
       
        <td><img height="59" src="../useruploads/' . $row['template_id'] . '/' . $row['userpic'] . '"/></td>
        <td><img height="59" src="../useruploads/' . $row['template_id'] . '/' . $row['mompic'] . '"/></td>
        <td>' . $row['momname'] . '</td> <td>' . $row['momsaid'] . '</td> <td>' . $row['template_id'] . '</td>
       <td>' . $row['address'] . '</td>  <td>' . $row['vote_count'] . '</td>
        <td>' . clsMain::formatedDate_TimeIndian($row['created_on']) . '</td>
         <td><a href="../useruploads/final/' . $row['videothumb'] . '" class="iframe"><img height="59" src="../useruploads/thumb/' . $row['videothumb'] . '"/></a></td>
           <td><a href="' . $_SERVER['PHP_SELF'] . '?action=' . $action . '&id=' . $row['entry_id'] . '">'.$actions[$row['isactive']].'</a></td>
    </tr>';
    }
    $dataHTML.='</tbody>';
} else
    $pagingHTML = '<h3>No records found.</h3>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Vanish Entries</title>
        <?php require_once 'cssheader.php'; ?>
    </head>
    <body>
        <?php include_once("header.php"); ?>
        <div id="wrapper">
            <div id="report">
                Total Number of Users Between <?php
                echo clsMain::formatedateIndian($startdate) . " 
                    || " . clsMain::formatedateIndian($enddate) . " : " . $userCount;
                ?>
            </div>
            <div id="form_control">
                <form>
                    From <input type="text" id="dateStart" value="<?php echo $startdate; ?>" style="width: 185px" name="date1" readonly="readonly" /> 
                    To <input type="text" id="EndDate" value="<?php echo $enddate; ?>" style="width: 185px" name="date2"  readonly="readonly"/> 
                    <input type="submit" name="submit" value="submit" class="button" />
                    <?php
                    if ($rows != false)
                        echo '<input type="submit" name="excal" value="Download To Excel" class="button" />&nbsp;';
                    ?>

                </form>
            </div>

            <table border="0" cellpadding="4" cellspacing="1" class="gridtable" width="100%">
                <?php echo $dataHTML; ?>
            </table>
            <?php
            if (isset($pagingHTML))
                echo $pagingHTML;
            if ($rows != false) {
                if ($p > 0)
                    echo '<a href = "' . $_SERVER['PHP_SELF'] . '?start=' . $startdate . '&end=' . $enddate . '&p=' . ($p - 1) . '">Prev</a>';

                if (mysql_num_rows($rows) >= 30)
                    echo ' | <a href = "' . $_SERVER['PHP_SELF'] . '?start=' . $startdate . '&end=' . $enddate . '&p=' . ($p + 1) . '">Next</a>';
            }
            ?>
        </div>

    </body>
</html>
<?php $dbobj->dbClose(); ?>