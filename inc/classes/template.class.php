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
class template {
    
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
    
    /**#@+
     * Template configuration
     */
    
    /**
     * Short name of the template
     * @var string
     */
    public $name;
    
    /**
     * Full title of the template
     * @var string
     */
    public $title;
    
    /**
     * Author(s) of the template
     * @var string
     */
    public $author;
    
    /**
     * Copyright
     * @var string
     */
    public $copyright;
    
    /**
     * License the template is published under
     * @var string
     */
    public $license;
    
    /**
     * The main template file to be included
     * @var string
     */
    private $main_file;
    
    /**
     * List of CSS files to be included
     * @var array
     */
    private $css_files = Array();
    
    /**
     * List of JS files to be included
     * @var array
     */
    private $js_files = Array();
    
    /**
     * Complete template.yml
     * @var array
     */
    private $tpl_config;
    
    /**#@-*/
    
    /**
     * Read-in the config file and save values
     * @param string $name Short name of the template/name of the template directory
     * @return boolean Success reading the config? 
     */
    public function __construct($name) {
        
        // Read the configuration file
        if(!$tpl_config = Spyc::YAMLLoad(ROOT_PATH."/templates/".$name."/template.yml"))
                return false;
        
        $this->tpl_config = $tpl_config;
        
        // Set the variables
        $this->name = $tpl_config['name'];
        $this->title = $tpl_config['title'];
        $this->author = $tpl_config['author'];
        $this->copyright = $tpl_config['copyright'];
        $this->license = $tpl_config['license'];
        
        $this->main_file = $tpl_config['main_file'];
        
        $this->css_files = explode(",", $tpl_config['css_files']);
        $this->js_files = explode(",", $tpl_config['js_files']);
        
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
     * Outputs the html code for including the css and js files
     * @param int $indent Indent to be added at the start of each line
     */
    public function print_includes($indent_num = 0) {
        
        $return = "";
        $indent = "";
        
        // Generate an indent string
        for($i = 0; $i < $indent_num; $i++) 
            $indent .= ' ';
        
        // CSS files
        if(!empty($this->css_files)) {
            
            foreach($this->css_files as $file) {

                $return .= $indent."<link rel=\"stylesheet\" type=\"text/css\" href=\"".ROOT_URL."/templates/".$this->name."/".$file."\" />\n";

            }
            
            $return .= $indent."\n";
            
        }
        
        // JS files
        if(!empty($this->js_files)) {
            
            foreach($this->js_files as $file) {
                
                $return .= $indent."<script type=\"text/javascript\" src=\"".ROOT_URL."/templates/".$this->name."/".$file."\"></script>\n";
                
            }
            
            $return .= $indent."\n";
            
        }
        
        echo $return;
        
    }
    
    /**
     * Output the meta tags specified in the configuration file
     * @param int $indent Indent to be added at the start of each line
     */
    public function print_meta($indent_num = 0) {
        
        $return = "";
        $indent = "";
        
        // Generate an indent string
        for($i = 0; $i < $indent_num; $i++) 
            $indent .= ' ';
        
        // Charset
        $return .= $indent."<meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\">\n";
        
        // Author
        $return .= $indent."<meta name=\"author\" content=\"".self::$config->get('meta.author')."\" />\n";
        
        // Keywords
        $return .= $indent."<meta name=\"keywords\" content=\"".self::$config->get('meta.keywords')."\" />\n";
        
        // Description
        $return .= $indent."<meta name=\"description\" content=\"".self::$config->get('meta.description')."\" />\n";
        
        // Genarator
        $return .= $indent."<meta name=\"generator\" content=\"PostPone ".VERSION."\" />\n";
        
        // Information about the design
        $return .= $indent."<meta name=\"designer\" content=\"".$this->title." by ".$this->author."; ".$this->copyright."\" />\n";
        
        $return .= $indent."\n";
        
        echo $return;
        
    }
    
    /**
     * Return the path of the main template file.
     * @return string Absolute path to the main file.
     */
    public function get_main_file() {
                
        return ROOT_PATH."/templates/".$this->name."/".$this->main_file;
        
    }
    
    /**
     * Outputs user defined configs in the template.yml
     * @param string $var
     */
    public function config($var) {
        
        if(!is_string($var)) {
            return false;
        }
        
        // Explode
        $var_arr = explode(".", $var);
        
        // temporary array
        $tmp = $this->tpl_config;
        
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
