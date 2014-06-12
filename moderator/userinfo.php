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
    header('Location:downloadexcel.php?option=user&start=' . $startdate . '&end=' . $enddate);
}

$dbobj = new Admin();
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
//$tablename,$datecolumName,$oderbyColumnName,$startdate, $enddate, $limit = 0, $count = 30
$rows = $dbobj->getTableData(DB_PREFIX.'_users','created_on','user_id desc',$startdate, $enddate, $p * 30);
$userCount = $dbobj->getUserCount(DB_PREFIX.'_users','created_on','user_id',$startdate, $enddate);
$dataHTML = '';
$pagingHTML = '';
if ($rows != false) {
    $dataHTML = '<thead><tr>
                <th>Serial No.</th>
                <th>User Name</th>
                <th>User Image</th>
                 <th>Email</th>
                <th>User City</th>
                <th>Gender</th>
                <th>Login Type</th>
                <th>User Creation Date</th>
                 <th>User Login Logs</th>
              
             </tr></thead><tbody>';
   
    $login =  array('F' => 'Facebook', 'M' => 'Microsite','W'=>'Mobile/Tablet');
    $sex = array('F' => 'Female', 'M' => 'Male');
    while ($row = $dbobj->dbFetchArray($rows)) {
       
        $dataHTML.='
    <tr>
        <td>' . ++$i . '</td>
        <td><a href="https://www.facebook.com/' . $row['social_user_id'] . '" target="_blank">' . $row['user_name'] . '</a></td>
        <td><img src="https://graph.facebook.com/' . $row['social_user_id'] . '/picture" /></td>
        <td>' . $row['email_id'] . '</td>
        <td>' . $row['user_location'] . '</td>
        <td>' .$sex[$row['sex']] . '</td>
        <td>' .$login[$row['user_type']] . '</td>
        <td>' . clsMain::formatedDate_TimeIndian($row['created_on']) . '</td>
         <td><a href="viewuserlog.php?startdate=' . $startdate . '&enddate=' . $enddate . '&name=' . $row['user_name'] . '&userid=' . $row['user_id'] . '" class="iframe">View User Login History</a></td>

    </tr>';
    }
     $dataHTML.='</tbody>';
}
else
    $pagingHTML = '<h3>No records found.</h3>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>User Information</title>
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
                    echo '<a href = "'.$_SERVER['PHP_SELF'].'?start=' . $startdate . '&end=' . $enddate . '&p=' . ($p - 1) . '">Prev</a>';

                if (mysql_num_rows($rows) >= 30)
                    echo ' | <a href = "'.$_SERVER['PHP_SELF'].'?start=' . $startdate . '&end=' . $enddate . '&p=' . ($p + 1) . '">Next</a>';
            }
            ?>
        </div>

    </body>
</html>
<?php $dbobj->dbClose(); ?>