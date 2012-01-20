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
     * Create the user depending on the ID
     * @param int $id User ID
     */
    public function __construct($id) {
        
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
        
        return true;
        
    }
    
    /**
     * Init the static vars
     * @param object $db Database connection object
     * @param array $config PostPone configuration object 
     */
    public static function init(&$db, &$config) {
        
        // Create static references
        self::$config =& $config;
        self::$db =& $db;
        
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
    
}
?>
