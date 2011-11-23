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
class permissions {
    
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
     * Checks if the permission node $node exists
     * @param string $node The node to check for existance
     * @return boolean
     */
    public static function node_exists($node) {
        
        // $node not a string?
        if(!is_string($node)) {
            return 0;
        }
        
        // query
        $query = "SELECT * FROM ".self::$config['mysql']['prefix']."permissions WHERE `perm_node` = '".self::$db->escape($node)."' LIMIT 1";
        
        $res = self::$db->query($query);
        
        if($res === false) {
            return 0;
        }
        
        // Does not exist
        if(mysql_num_rows($res) != 1) {
            return false;
        }
        else {
            // Does exist
            return true;
        }
       
    }
    
    /**
     * Checks both user and groups permissions for the permission node
     * @param int $user User ID
     * @param string $node Permission node
     * @return boolean Does the user/group has the permission?
     */
    public static function has_perm($user, $node) {
        
        // Check params
        if(!is_numeric($user)) {
            return 0;
        }
        
        if(!is_string($node)) {
            return 0;
        }
        
        // Check if the node exists
        if(!self::node_exists($node)) {
            return 0;
        }
        
        // First user permissions, user perms come before group perms
        if(self::has_perm_user($user, $node) == true) {
            return true;
        }
        else {
            
            // Else check the group perms first
            if(self::has_perm_group(user::user_to_group($user), $node) == true) {
                return true;
            }
            else {
                return false;
            }
            
        }
        
    }
    
    /**
     * Checks if $user has the permission node or not
     * @param int $user User ID
     * @param string $node Permission node
     * @return boolean true if user has the perm node, false if not or error
     */
    public static function has_perm_user($user, $node) {
        
        // Check params
        if(!is_numeric($user)) {
            return 0;
        }
        
        if(!is_string($node)) {
            return 0;
        }
        
        // Check if the node exists
        if(!self::node_exists($node)) {
            return 0;
        }
        
        // Get the permissions of the user
        $query = "SELECT * FROM ".self::$config['mysql']['prefix']."user WHERE `user_id` = ".self::$db->escape($user)." LIMIT 1";
        
        $res = self::$db->query($query);
        
        if($res === false) {
            return 0;
        }
        
        // User does not exist
        if(mysql_num_rows($res) != 1) {
            return 0;
        }
        
        // Explode the permission string
        $data = mysql_fetch_object($res);
        
        $perm_arr = explode(",", $data->user_perms);
        
        // Negated node in there?
        if(in_array("-".$node, $perm_arr)) {
            return false;
        }
        else {
            
            // Not-negated node in there?
            if(in_array($node, $perm_arr)) {
                return true;
            }
            // Not in there at all?
            else {
                return false;
            }
            
        }
        
    }
    
    /**
     * Checks if $group has the permission node or not
     * @param int $user Group ID
     * @param string $node Permission node
     * @return boolean true if the group has the perm node, false if not or error
     */
    public static function has_perm_group($group, $node) {
        
        // Check params
        if(!is_numeric($group)) {
            return 0;
        }
        
        if(!is_string($node)) {
            return 0;
        }
        
        // Check if the node exists
        if(!self::node_exists($node)) {
            return 0;
        }
        
        // Get the permissions of the group
        $query = "SELECT * FROM ".self::$config['mysql']['prefix']."group WHERE `group_id` = ".self::$db->escape($group)." LIMIT 1";
        
        $res = self::$db->query($query);
        
        if($res === false) {
            return 0;
        }
        
        // Group does not exist
        if(mysql_num_rows($res) != 1) {
            return 0;
        }
        
        // Explode the permission string
        $data = mysql_fetch_object($res);
        
        $perm_arr = explode(",", $data->group_perms);
        
        // Negated node in there?
        if(in_array("-".$node, $perm_arr)) {
            return false;
        }
        else {
            
            // Not-negated node in there?
            if(in_array($node, $perm_arr)) {
                return true;
            }
            // Not in there at all?
            else {
                return false;
            }
            
        }
        
    }
    
    
}
?>
