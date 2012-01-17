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
class page {
    
    /**
     * Short Name of the page
     * @var string
     */
    public $name;
    
    /**
     * Full title of the page
     * @var string
     */
    public $title;
    
    /**
     * Type of the page (see page constants)
     * @var int
     */
    public $type;
    
    /**
     * List of the permissions needed to display the page
     * @var array
     */
    public $perms;
    
    /**
     * File to be included
     * @var string
     */
    public $file;
    
    /**
     * Text to be shown, if type == PAGE_DB
     * @var string
     */
    public $text;
    
    
    /**
     * Fetching information about the current page ($id)
     * @global array $config
     * @global object $db
     * @param int $id ID of the current page
     * @return bool 
     */
    public function __construct($id) {
        
        global $config, $db;
        
        // Get information
        $query = "SELECT * FROM ".$config['mysql']['prefix']."pages WHERE `page_id` = ".$db->escape($id);
        
        if(!$result = $db->query($query)) {
            return false;
        }
        
        if($db->num_rows() != 1) {
            return false;
        }
        
        $data = mysql_fetch_object($result);
        
        $this->name = $data->page_name;
        $this->title = $data->page_title;
        $this->perms = $data->page_perms;
        $this->type = $data->page_type;
        if($this->type == PAGE_FILE) {
            $this->file = $data->page_file;
        }
        else {
            $this->text = $data->page_text;
        }
        
        return true;
        
    }
    
    /**
     *
     * @global array $config
     * @global object $db
     * @param string $name Short name of the page
     * @return int|bool ID if success, false if not
     */
    static function name2id($name) {
        
        global $config, $db;
        
        $query = "SELECT * FROM ".$config['mysql']['prefix']."pages WHERE page_name = '".$db->escape($name)."'";
        
        if(!$result = $db->query($query)) {
            return false;
        }
        
        if($db->num_rows() != 1) {
            return false;
        }
        
        $data = mysql_fetch_object($result);
        
        return $data->page_id;
        
    }
    
}
?>
