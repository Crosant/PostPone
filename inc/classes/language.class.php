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
class language {
    
    /**
     * Language name
     * @var string
     */
    public $name;
    
    /**
     * Author of this language
     * @var string
     */
    public $author;
    
    /**
     * Copyright for this language
     * @var string
     */
    public $copyright;
    
    /**
     * License
     * @var string
     */
    public $license;
    
    /**
     * Short locale (e.g. en_UK)
     * @var string
     */
    public $locale;
    
    /**
     * Array containing all data
     * @var array
     */
    private $array;
    
    
    public function __construct($locale) {
        
        // Check for file existance
        if(!file_exists(ROOT_PATH."/locales/".$locale.".yml")) {
            return false;
        }
        
        // Read the information
        $array = Spyc::YAMLLoad(ROOT_PATH."/locales/".$locale.".yml");
        $this->author = $array['info']['author'];
        // Errors?
        if($array === false) {
            return false;
        }
        
        // Save the info
        $this->author = $array['info']['author'];
        $this->name = $array['info']['name'];
        $this->copyright = $array['info']['copyright'];
        $this->license = $array['info']['license'];
        $this->locale = $locale;
        
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
        $tmp = $this->array[$this->locale];
        
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
