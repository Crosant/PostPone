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

class nav {
    
    /**
     * Prints the navigation (HTML)
     * @global object $config
     * @global object $db
     * @param int $cur_page Current page ID
     * @return void
     */
    public static function output($cur_page) {
        
        global $config, $db;
        
        // Fetch information
        $query = "SELECT * FROM ".$config->get("mysql.prefix")."nav ORDER BY nav_id ASC";
        
        if(!$res = $db->query($query)) {
            return false;
        }
        // TODO: clean up the HTML output
        echo "
<nav>\n
    <ul>\n";
        
        // Count entries
        $nav_num = mysql_num_rows($res);
        
        
        // Control variable
        $i = 0;
        
        while($line = mysql_fetch_array($res)) {
            
            $classes = "";
            
            switch($line['nav_type']) {
                
                case NAV_INTERNAL:
                    
                    if($i == 0) {
                        $classes .= "first ";
                    }
                    
                    if($i == $nav_num - 1) {
                        $classes .= "last ";
                    }
                    
                    if($line['nav_page'] == $cur_page) {
                        // Page is currently shown, set as active
                        $classes .= "active ";
                    }
                    
                    // Make the link
                    $link = SUBDIR.page::id2name($line['nav_page']);
                    
                    break;
                
                case NAV_EXTERNAL:
                    
                    if($i == 0) {
                        $classes .= "first ";
                    }
                    
                    if($i == $nav_num - 1) {
                        $classes .= "last ";
                    }
                    
                    // Make the link
                    $link = $line['nav_link'];
                    
                    break;
                
            }
            
            // Remove last space
            $classes = trim($classes);
            
            // Output
            echo "
        <li";
            if(!empty($classes))
                echo " class=\"$classes\"";
            echo ">\n
            <a href=\"$link\">".$line['nav_title']."</a>\n
        </li>\n
";
            
            $i++;
            
        }
        
        echo "
    </ul>\n
</nav>\n
<br class=\"clear\" />\n";
        
    }
    
}
?>