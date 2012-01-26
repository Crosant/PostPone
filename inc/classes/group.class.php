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
class group {
    
    /**
     * Group ID
     * @var int
     */
    public $id;
    
    /**
     * Displayname of the group
     * @var string
     */
    public $name;
    
    /**
     * List of Permissions
     * @var array
     */
    public $perms;
    
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
     * Creates new group object
     * @param int $group Group ID
     * @return bool
     */
    public function  __construct($group) {

        // Normal group
        if($group != self::$config->get("user.guest_group")) {
            if(!self::group_exists($group)) {
                return false;
            }

            $query = "SELECT * FROM ".self::$config->get("mysql.prefix")."groups WHERE group_id = ".self::$db->encode($group);

            if(!$res = self::$db->query($query)) {
                return false;
            }

            if(!$data = mysql_fetch_object($res)) {
                return false;
            }

            $this->id = $data->group_id;
            $this->name = $data->group_name;
            $this->perms = explode(",", $data->group_perms);

            return true;
        }
        // Guest
        else {
            
            global $language;
            
            $this->id = self::$config->get("user.guest_group");
            $this->name = self::$language->get("user.guest");
            $this->perms = array();
            
        }
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
     * Does the group exist?
     * @param int $user Group ID
     */
    public static function group_exists($group) {
        
        $query = "SELECT * FROM ".self::$config->get("mysql.prefix")."groups WHERE group_id = ".self::$db->escape($group);
        
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
