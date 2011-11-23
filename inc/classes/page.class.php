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
    
}
?>
