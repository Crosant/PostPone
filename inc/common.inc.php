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

// Include constants and functions to be able to output errors here
// Constants
require_once ROOT_PATH.'inc/constants.inc.php';

// Functions
require_once ROOT_PATH.'inc/functions.inc.php';

// YAML parse class
require_once ROOT_PATH.'inc/classes/spyc.class.php';

// Configuration
require_once ROOT_PATH.'inc/config.inc.php';

// MySQL class
require_once ROOT_PATH.'inc/classes/mysql.class.php';
require_once ROOT_PATH.'inc/mysql.inc.php';

// Template
require_once ROOT_PATH.'inc/classes/template.class.php';
require_once ROOT_PATH.'inc/template.inc.php';


?>
