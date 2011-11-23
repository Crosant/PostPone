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

/**#@+
 * Error type constants 
 */

/**
 * Unexpected error
 */
define("ERR_UNEXP", 1);

/**
 * MySQL error
 */
define("ERR_MYSQL", 2);

/**#@-*/

/**#@+
 * Page type constants
 */

/**
 * File
 */
define("PAGE_FILE", 1);

/**
 * Database
 */
define("PAGE_DB", 2);

/**#@-*/
?>
