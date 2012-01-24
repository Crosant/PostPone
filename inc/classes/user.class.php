<?php

/**
 * @author SkyIrc development team <skyirc@skyirc.net>
 * @copyright Copyright (c) SkyIrc
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @package PostPone
 */

// Restrict access
if(!defined("IN_POSTPONE")) {
    die("Do not open files seperately!");
}

/**
 * @author SkyIrc development team <skyirc@skyirc.net>
 * @copyright Copyright (c) SkyIrc
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @package PostPone
 */
class user {
    
    /**
     * User ID
     * @var int
     */
    public $id;
    
    /**
     * Username
     * @var string 
     */
    public $name;
    
    /**
     * Group ID
     * @var int 
     */
    public $group;
    
    /**
     * List of permissions
     * @var array
     */
    public $perms;
    
    /**
     * Mail adress of this user
     * @var string
     */
    public $mail;
    
    /**
     * Last login of this user
     * @var int
     */
    public $last_login;
    
    /**
     * Registration time of this user
     * @var int
     */
    public $reg_time;
    
    /**
     * MySQL Object reference
     * @var object
     */
    private static $db;
    
    /**
     * PostPone Config reference
     * @var array
     */
    private static $config;
    
    /**
     * PostPone language reference
     * @var array
     */
    private static $language;
    
    /**
     * Create the user depending on the ID
     * @param int $id User ID
     */
    public function __construct($id) {

        // Normal user
        if($id != 0) {
            if(!self::user_exists($id)) {
                return false;
            }

            // Fetch info and save it
            $query = "SELECT * FROM ".self::$config->get("mysql.prefix")."users WHERE user_id = ".self::$db->escape($id);

            if(!$res = self::$db->query($query)) {
                return false;
            }

            if(!$data = mysql_fetch_object($res)) {
                return false;
            }

            $this->group = $data->user_group;
            $this->id = $data->user_id;
            $this->name = $data->user_name;
            $this->perms = explode(",", $data->user_perms);
            $this->last_login = $data->user_lastlogin_time;
            $this->reg_time = $data->user_reg_time;

        }
        // Guest
        else {

            global $language;

            $this->group = self::$config->get("user.guest_group");
            $this->id = 0;
            $this->name = self::$language->get("user.guest");
            $this->perms = array();
            $this->last_login = time();
            $this->reg_time = time();

        }

        return true;
        
    }




    /**
     * Init the static vars
     * @param object $db Database connection object
     * @param array $config PostPone configuration object 
     * @param object $language PostPone language object
     */
    public static function init(&$db, &$config, &$language) {
        
        // Create static references
        self::$config =& $config;
        self::$db =& $db;
        self::$language = $language;
        
    }
    
    /**
     * Get the group of the user
     * @param int $user 
     */
    public static function user_to_group($user) {
        
        if(!self::user_exists($user)) {
            return false;
        }
        
        $query = "SELECT * FROM ".self::$config->get("mysql.prefix")."users WHERE user_id = ".self::$db->escape($user);
        
        if(!$res = self::$db->query($query)) {
            return false;
        }
        
        if(!$data = mysql_fetch_object($res)) {
            return false;
        }
        
        return $data->user_group;
        
    }
    
    /**
     * Does the user exist?
     * @param int $user User ID
     */
    public static function user_exists($user) {
        
        $query = "SELECT * FROM ".self::$config->get("mysql.prefix")."users WHERE user_id = ".self::$db->escape($user);
        
        if(!$res = self::$db->query($query)) {
            return false;
        }
        
        if(self::$db->num_rows($res) != 1) {
            return false;
        }
        
        return true;
        
    }

    /**
     * Checks the password
     * @param string $password
     * @param int $user
     * @return bool
     */
    public static function check_password($password, $user) {

        if(!self::user_exists($user)) {
            return false;
        }

        // Get the password and the salt
        $query = "SELECT * FROM ".self::$config->get("mysql.prefix")."users WHERE user_id = ".self::$db->escape($user);

        if(!$res = self::$db->query($query)) {
            return false;
        }

        if(!$data = mysql_fetch_object($res)) {
            return false;
        }

        // Password (as stored in the db): md5(md5(%password%).%salt%)

        if(!md5(md5($password).$data->user_salt) != $data->user_password) {
            return false;
        }
        else {
            return true;
        }
    }

    /**
     * Generates a random alphanumeric string
     * @param int $length
     * @return string
     */
    public static function rand_str($length) {

        $pool = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789";

        $return = "";

        for ($i = 1; $i <= $length; $i++) {
            $zufall = substr(str_shuffle($pool), 0, 1);
            $return .= $zufall;
        }
        return $return;

    }

    /**
     * Generates salt and hashed password
     * @param string $password unencrypted password
     * @return object $return->salt and $return->password
     */
    public static function make_pass($password) {

        $salt = md5(self::rand_str(128));
        $password = md5(md5($password).$salt);

        // Save salt and password in an obj
        $return = new stdClass();

        $return->salt = $salt;
        $return->password = $password;

        return $return;

    }




    /*********************
     * SESSION FUNCTIONS *
     *********************/

    /**
     * Checks, if the user is logged in
     * @return int|bool 0: not logged in, -1: session expired, int != 0: user id; false: error
     */
    public static function sess_check() {

        // Check for cookies
        if(!isset($_COOKIE[self::$config->get("session.cookie_prefix")."session"])) {
            return 0;
        }

        // Save the key
        $key = $_COOKIE[self::$config->get("session.cookie_prefix")."session"];

        // Check for any db entries
        $query = "SELECT * FROM ".self::$config->get("mysql.prefix")."sessions WHERE sess_key = '".self::$db->escape($key)."'";

        if(!$res = self::$db->query($query)) {
            return false;
        }

        if(self::$db->num_rows($res) != 1) {

            // Error, delete the session entries and cookie and return false
            $query = "DELETE FROM ".self::$config->get("mysql.prefix")."sessions WHERE sess_key = '".self::$db->escape($key)."'";

            if(!self::$db->query($query)) {
                return false;
            }

            delcookie(self::$config->get("session.cookie_prefix")."session");

            return 0;
        }

        // Store session data
        if(!$data = mysql_fetch_object($res)) {
            return false;
        }

        // Session expired?
        if($data->sess_expire < time()) {

            // Delete the session entries and cookie and return false
            $query = "DELETE FROM ".self::$config->get("mysql.prefix")."sessions WHERE sess_id = ".self::$db->escape($data->sess_id);

            if(!self::$db->query($query)) {
                return false;
            }

            delcookie(self::$config->get("session.cookie_prefix")."session");

            return -1;

        }

        // Renew session and return the user id
        if(!self::sess_renew($data->sess_id, $data->sess_long))
            return false;

        return $data->sess_user;


    }


    /**
     * Extends the session
     * @param int $id Session ID
     * @param int $long 1|0, long session?
     * @return bool
     */
    public static function sess_renew($id, $long = 0) {

        $query = "UPDATE ".self::$config->get("mysql.prefix")."sessions SET sess_expire = ";

        if($long == 1) {
            $query .= self::$db->escape(time()+self::$config->get("session.sess_long_duration"));
        }
        else {
            $query .= self::$db->escape(time()+self::$config->get("session.sess_duration"));
        }

        $query .= " WHERE sess_id = ".self::$db->escape($id);

        if(!self::$db->query($query)) {
            return false;
        }
        return true;

    }
    

    public static function sess_start($user, $long = 0) {
        
        // Check for user's existance
        if(!self::user_exists($user)) {
            return false;
        }
        
        // Generate the key
        $key = self::rand_str(64);
        
        // Expiration time/date
        $expire = $long == 0 ? time() + self::$config->get("session.sess_duration") : time() + self::$config->get("session.sess_long_duration");
        
        // Insert into DB
        $query = "INSERT INTO ".self::$config->get("mysql.prefix")."sessions (`sess_key`, `sess_user`, `sess_expire`, `sess_long`)
            VALUES ('".self::$db->escape($key)."', ".self::$db->escape($user).", ".self::$db->escape($expire).", ".self::$db->escape($long).")";
        
        if(!self::$db->query($query)) {
            return false;
        }
        
        setcookie(self::$config->get("session.cookie_prefix")."session", $key, 0, self::$config->get("session.cookie_path"), self::$config->get("session.cookie_domain"));
        
    }
    
}
?>