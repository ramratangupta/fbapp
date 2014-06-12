<?php

require_once './includes.php';

if (!isset($_SESSION['UserAdmin'])) {
    header("Location: index.php");
    exit;
}

$user = $_SESSION['UserAdmin']['username'];
$pass = $_SESSION['UserAdmin']['password'];
if (empty($user) || empty($pass)) {
    header("Location: index.php");
    exit;
}

$startdate = $_GET['start'];
$enddate = $_GET['end'];

$Use_Title = 1;

$fromDate = explode(" ", $startdate);
$toDate = explode(" ", $enddate);


$file_type = "vnd.ms-excel";
$file_ending = ".xls";
$title = AppConfig::appName;
$temp = str_replace(" ", "_", ucfirst($title));

if ($fromDate['0'] == $toDate['0']) {
    $downloadDate = "Records of {$_REQUEST['option']} on" . $fromDate['0'];
    $downloadtitle = "Records of {$temp}_{$_REQUEST['option']}" . $fromDate['0'] . "_" . time();
} else {
    $downloadDate = "Records of {$_REQUEST['option']} on" . $fromDate['0'] . " to " . $toDate['0'];
    $downloadtitle = "Records of {$temp}_{$_REQUEST['option']} on" . $fromDate['0'] . "_to_" . $toDate['0'] . "_" . time();
}

$downloadtitle = str_replace("'", "", $downloadtitle);


header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Type: application/$file_type");
header("Content-Disposition: attachment; filename=" . $downloadtitle . "." . $file_ending);
if ($Use_Title == 1) {
    echo("$title");
    echo ("$downloadDate\n\n");
}
$dbObj = new Admin();

$sep = "\t"; //tabbed character

if (isset($_REQUEST['option'])) {
    switch ($_REQUEST['option']) {
        case 'user':
            $coulmnData = array(
                'social_user_id' => 'Social Id',
                'user_name' => 'Name',
                'email_id' => 'Email',
                'user_location' => 'Location',
                'is_active' => 'Status',
                'sex' => 'Sex',
                'user_type' => 'Login Type(F->Facebook,M->Microsite)',
            );

            $result = $dbObj->getExcalList(AppConfig::DB_PREFIX.'_users', 'created_on', 'user_id', $coulmnData, $startdate, $enddate);
            break;
    }
}


if ($result != false) {
    $total = $dbObj->dbNumRows($result); //count the number of rowsmysql_num_rows($result);//
//start of printing column names as names of MySQL fields

    for ($i = 0; $i < mysql_num_fields($result); $i++) {
        echo mysql_field_name($result, $i) . "\t"; // this function will print all field name in excel sheet
    }
    print("\n");

//end of printing column names

    while ($row = mysql_fetch_array($result)) {

        $schema_insert = "";

        for ($j = 0; $j < mysql_num_fields($result); $j++) {
            if ($j != 2) {
                if (!isset($row[$j]))
                    $schema_insert .= "NULL" . $sep;
                elseif ($row[$j] != "")
                    $schema_insert .= "$row[$j]" . $sep;
                else
                    $schema_insert .= "" . $sep;
            }else {
                if (!isset($row[$j]))
                    $schema_insert .= "NULL" . $sep;
                elseif ($row[$j] != "") {
                    $schema_insert .= "$row[$j]" . $sep;
                } else
                    $schema_insert .= "" . $sep;
            }
        }

        $schema_insert = str_replace($sep . "$", "", $schema_insert);
        //following fix suggested by Josue (thanks, Josue!)
        //this corrects output in excel when table fields contain \n or \r
        //these two characters are now replaced with a space
        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        $schema_insert .= "\t";
        print(trim($schema_insert));
        print "\n";
        //}
    }
}

$dbObj->dbClose();
?>