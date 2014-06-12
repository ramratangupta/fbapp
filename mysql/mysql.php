<?php

if (!strcasecmp(basename($_SERVER['SCRIPT_NAME']), basename(__FILE__)))
    die('Sanjay Singh!');

class mysql {

    var $connection;
    protected $_path = 'errorlog/';

    public function write($type, $message) {
        $filename = date("m_Y_") . $type . ".txt";
        $output = date('Y-m-d H:i:s') . ' ' . ucfirst($type) . ': ' . $message . "\n";
        return file_put_contents($this->_path . $filename, $output, FILE_APPEND);
    }

    protected function dbConnect() {

        try {
            $this->connection = mysql_pconnect(AppConfig::DB_HOST, AppConfig::DB_USER, AppConfig::DB_PASS);
            mysql_select_db(AppConfig::DB_NAME, $this->connection);
            mysql_query("SET NAMES 'UTF8'", $this->connection);
        } catch (Exception $e) {
            $this->write('Error', $e->getMessage());
            return false;
        }
        return $this->connection;
    }

    function dbClose() { // close connection
        try {
            if ($this->connection) {
                mysql_close($this->connection);
                $this->conn = false;
            }
        } catch (Exception $e) {

            $this->write('Error', $e->getMessage());
        }
    }

    function dbQuery($s) { //database query
        $result = mysql_query($s, $this->connection);
        if ($result)
            return $result;
        else
            return mysql_error();
    }

    function dbFetchArray($result) {


        $result = mysql_fetch_array($result);

        return $result;
    }

    function dbFetchRow($q) { //row fetching
        try {

            $result = mysql_fetch_row($q);
        } catch (Exception $e) {

            $this->write('Error', $e->getMessage());
            $result = false;
        }


        return $result;
    }

    function dbNumRows($result) {

        $result = mysql_num_rows($result);
        return $result;
    }

    function dbInsertId() {

        return mysql_insert_id();
    }

    function dbFetchAssoc($result) {
        try {

            $result = mysql_fetch_assoc($result);
        } catch (Exception $e) {

            $this->write('Error', $e->getMessage());
            $result = false;
        }

        return $result;
    }

    /*     * *****  This function will return all field  name ****** */

    function dbFieldName($result, $i) {
        try {
            $result = mysql_field_name($result, $i);
        } catch (Exception $e) {
            $this->write('Error', $e->getMessage());
            $result = false;
        }
        return $result;
    }

    function dbError() { //database error message
        return mysql_error();
    }

    function dbFreeResult($result) {
        return mysql_free_result($result);
    }

    public function sanitizeForSQL($str) {

        try {
            $str = htmlspecialchars(stripslashes($str));
            $str = str_ireplace("script", "blocked", $str);

            $str = $this->sanitize($str);
            if (function_exists("mysql_real_escape_string")) {
                $ret_str = mysql_real_escape_string($str, $this->connection);
            } else {
                $ret_str = addslashes($str);
            }
        } catch (Exception $e) {

            $this->write($type, $e->getMessage());
            $result = false;
        }

        return $ret_str;
    }

    public function StripSlash($str) {
        if (get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        return $str;
    }

    public function sanitize($str, $remove_nl = true) {
        $str = $this->StripSlash($str);

        if ($remove_nl) {
            $injections = array('/(\n+)/i',
                '/(\r+)/i',
                '/(\t+)/i',
                '/(%0A+)/i',
                '/(%0D+)/i',
                '/(%08+)/i',
                '/(%09+)/i'
            );
            $str = preg_replace($injections, '', $str);
        }

        return $str;
    }

    public function createErrorLog($userId, $visitType) {
        $sqlLog = "Insert into " . AppConfig::DB_PREFIX . "_users_logs (fk_UserID,user_ip,visit_type) values 
                (" . $userId . ",'" . $_SERVER['REMOTE_ADDR'] . "','" . $visitType . "')";

        $this->dbQuery($sqlLog);
        return;
    }

}
