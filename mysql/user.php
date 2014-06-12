<?php

if (!strcasecmp(basename($_SERVER['SCRIPT_NAME']), basename(__FILE__)))
    die('Sanjay Singh!');

final class User extends mysql {

    private $_tableName = '';

    public function __construct() {
        $this->_tableName = AppConfig::DB_PREFIX . "_users";
        $this->dbConnect();
    }

    public function save($data) {

        if (!$this->isExistBySocialID($data['social_user_id'])) {


            $sql = "INSERT INTO " . $this->_tableName . " (sex,social_user_id, user_name, email_id,user_location, is_active, created_on,user_type)
		        VALUES ('" . $data['sex'] . "','" . $this->sanitizeForSQL($data['social_user_id']) . "', 
                            '" . $this->sanitizeForSQL($data['user_name']) . "',
                                '" . $this->sanitizeForSQL($data['email_id']) . "','" . $this->sanitizeForSQL($data['user_location']) . "',
                                    'Y', '" . clsMain::GetCurrentDateTime() . "','" . $data['user_type'] . "')";
            $this->dbQuery($sql);
            return $this->getUserBySocailID($data['social_user_id']);
        }
        return $this->getUserBySocailID($data['social_user_id']);
    }

    public function getUserBySocailID($socailID) {
        $sql = "select * from " . $this->_tableName . " where is_active='Y' and social_user_id ='" . $socailID . "'";
        $result = $this->dbQuery($sql);

        if (mysql_num_rows($result) > 0) {
            return $this->dbFetchAssoc($result);
        }
        return false;
    }

    public function createUserLog() {
        $sqlLog = "Insert into " . AppConfig::DB_PREFIX . "_users_logs (user_type,fk_user_id,user_ip,created_on) values 
                ('" . $_SESSION['User']['user_type'] . "'," . $_SESSION['User']['user_id'] . ",'" . $_SERVER['REMOTE_ADDR'] . "',
                    '" . clsMain::GetCurrentDateTime() . "')";

        $this->dbQuery($sqlLog);
        return;
    }

    public function isExistBySocialID($socialID) {
        $sql = "select social_user_id from " . $this->_tableName . " where social_user_id ='" . $socialID . "'";

        $result = $this->dbQuery($sql);

        if (mysql_num_rows($result) > 0) {
            return true;
        }
        return false;
    }

    public function getUniqueId() {
        $pass = '';
        $allowed_characters = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 0);
        for ($i = 1; $i <= 12; $i++) {
            $pass .= $allowed_characters[rand(0, count($allowed_characters) - 1)];
        }
        return $pass;
    }

    /**
     * save the facebook friends FB ids in database
     * @param type $post $_POST array
     * @return type
     */
    public function saveInvitesData($post) {
        if (isset($_SESSION['User']['social_user_id'])) {
            $social_user_id = $_SESSION['User']['social_user_id'];
        } else {
            $social_user_id = 0;
        }
        $sqlLog = "insert into " . AppConfig::DB_PREFIX . "_users_invites (social_user_id,freind_fb_id,created_on) values ";

        foreach ($post['tofriends'] as $frndfbid) {
            $sqlLog.="('" . $social_user_id . "','" . $this->sanitizeForSQL($frndfbid) . "',
                '" . clsMain::GetCurrentDateTime() . "'),";
        }

        $this->dbQuery(substr($sqlLog, 0, -1));
        return;
    }

}
