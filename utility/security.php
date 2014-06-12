<?php

if (!strcasecmp(basename($_SERVER['SCRIPT_NAME']), basename(__FILE__)))
    die('Error');

class security {
    /*
     * Encrypt
     * use - 
     * $id => value to be encrypted , type-int,string
     * Secure::custEncrypt($id);
     */

    static function custEncrypt($data_input = null) {
        $key = AppConfig::PASSWORD_SALT;
        $td = mcrypt_module_open('cast-256', '', 'ecb', '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $encrypted_data = mcrypt_generic($td, $data_input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $encoded_64 = clsMain::urlsafe_b64encode($encrypted_data);
        $encoded_64 = str_replace("==", "", $encoded_64);
        return trim($encoded_64);
    }

    /*
     * Decrypt
     * use - 
     * $id => encrypted value in url
     * Secure::custDecrypt($id)
     */

    static function custDecrypt($encoded_64 = null) {
        $decoded_64 = clsMain::urlsafe_b64decode($encoded_64);
        $key = AppConfig::PASSWORD_SALT; // same as you used to encrypt 
        $td = mcrypt_module_open('cast-256', '', 'ecb', '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $decrypted_data = mdecrypt_generic($td, $decoded_64);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return trim($decrypted_data);
    }

    /*
     * for url safe string
     */

    private static function urlsafe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', '.'), $data);
        return $data;
    }

    private static function urlsafe_b64decode($string) {
        $data = str_replace(array('-', '_', '.'), array('+', '/', '='), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

}
