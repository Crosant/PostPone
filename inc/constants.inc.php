<?php

/**
 * @author SkyIrc development team <skyirc@skyirc.net>
 * @copyright Copyright (c) SkyIrc
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @package PostPone
 */

// Restrict access
if(!IN_POSTPONE) {
    die("Do not open files seperately!");
}

/**#@+
 * Error type constants 
 */

/**
 * Unexpected error
 */
define("UNEXP_ERR", 1);

/**
 * MySQL error
 */
define("MYSQL_ERR", 2);

/**#@-*/
?>
