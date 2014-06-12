<?php

require_once './includes.php';

class Admin extends mysql {

    public $_table = "";

    public function __construct() {
        $this->dbConnect();
        $this->_table = AppConfig::DB_PREFIX . "_admin";
    }

    public function login($username, $userpass) {
        $sql = "select id,username,password from " . $this->_table . " where username = '" . $this->sanitizeForSQL($username) . "' and password = '" . $this->sanitizeForSQL($userpass) . "' and is_active = 'Y' and user_type ='A'";
        $result = $this->dbQuery($sql);

        if (mysql_num_rows($result) > 0) {
            return $this->dbFetchArray($result);
        }
        return false;
//return $result;
    }

    public function getTableData($tablename, $datecolumName, $oderbyColumnName, $startdate = 0, $enddate = 0, $limit = 0, $count = 30) {
        $start = mysql_real_escape_string(trim($startdate));
        $end = mysql_real_escape_string(trim($enddate));
        $sql = "select *  from " . $tablename . " where 
            {$datecolumName} BETWEEN '" . $start . " 00:00:00' AND '" . $end . " 23:59:59' ORDER BY {$oderbyColumnName}  limit " . $limit . "," . $count;
        $result = $this->dbQuery($sql);

        if (mysql_num_rows($result) > 0) {
            return $result;
        }
        return false;
    }

    public function getExcalList($tablename, $datecolumName, $oderbyColumnName, $Columnheader, $startdate, $enddate) {
        $colms = '';
        foreach ($Columnheader as $key => $value) {
            $colms.=$key . " '{$value}', ";
        }
        $start = mysql_real_escape_string(trim($startdate));
        $end = mysql_real_escape_string(trim($enddate));

        $sql = "select {$colms} {$datecolumName} 'Date' from    " . $tablename . " where {$datecolumName} 
            BETWEEN '" . $start . " 00:00:00' AND '" . $end . " 23:59:59' ORDER BY {$oderbyColumnName} desc";

        $result = $this->dbQuery($sql);

        if (mysql_num_rows($result) > 0) {
            return $result;
        }
        return false;
    }

    public function getUserCount($tablename, $datecolumName, $countbyColumnName, $startdate, $enddate) {
        // $userCount = array('fbcount' => 0, 'miccrositecount' => 0, 'total' => 0, 'accept_count' => 0, 'not_accept_count' => 0);
        $start = mysql_real_escape_string(trim($startdate));
        $end = mysql_real_escape_string(trim($enddate));

        $sql = "select count($countbyColumnName) usercount from   {$tablename} where {$datecolumName} BETWEEN '" . $start . " 00:00:00' AND '" . $end . " 23:59:59' ";

        $result = $this->dbQuery($sql);
        $row = mysql_fetch_array($result);
        $userCount = $row['usercount'];

        return $userCount;
    }

    public function getUserLogList($startdate, $enddate, $id) {
        $start = mysql_real_escape_string(trim($startdate));
        $end = mysql_real_escape_string(trim($enddate));

        $sql = "SELECT *  FROM " . AppConfig::DB_PREFIX . "_users_logs where fk_user_id=" . $id . "
            and created_on  BETWEEN '" . $start . " 00:00:00' AND '" . $end . " 23:59:59' ORDER BY users_logs_id desc";

        $result = $this->dbQuery($sql);

        if (mysql_num_rows($result) > 0) {
            return $result;
        }
        return false;
    }

}
