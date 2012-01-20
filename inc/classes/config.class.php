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
class config {

    /**
     * Array containing all data
     * @var array
     */
    private $array;
    
    
    public function __construct() {
        
        // Check for file existance
        if(!file_exists(ROOT_PATH."/inc/config.yml")) {
            return false;
        }
        
        // Read the information
        $array = Spyc::YAMLLoad(ROOT_PATH."/inc/config.yml");
        
        // Errors?
        if($array === false) {
            return false;
        }
        
        // Save data
        $this->array = $array;
        
    }
    
    /**
     * Outputs the content of $var ($var style: )
     * @param string $var
     */
    public function get($var) {
        
        if(!is_string($var)) {
            return false;
        }
        
        // Explode
        $var_arr = explode(".", $var);
        
        // temporary array
        $tmp = $this->array;
        
        // Try to get the string, recurse deeper and deeper ...
        foreach($var_arr as $cur) {
            
            if(isset($tmp[$cur])) {
                $tmp = $tmp[$cur];
            }
            else {
                $tmp = null;
                break;
            }
        }
        
        if(!is_string($tmp) || empty($tmp) || is_null($tmp)) {
            return $var;
        }
        
        return $tmp;
        
    }
    
}
?>
