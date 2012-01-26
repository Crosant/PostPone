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
require_once ROOT_PATH.'/inc/constants.inc.php';

// Functions
require_once ROOT_PATH.'/inc/functions.inc.php';

// YAML parse class
require_once ROOT_PATH.'/inc/classes/spyc.class.php';

// Configuration
require_once ROOT_PATH.'/inc/classes/config.class.php';
require_once ROOT_PATH.'/inc/config.inc.php';

// MySQL class
require_once ROOT_PATH.'/inc/classes/mysql.class.php';
require_once ROOT_PATH.'/inc/mysql.inc.php';

// Template
require_once ROOT_PATH.'/inc/classes/template.class.php';
require_once ROOT_PATH.'/inc/template.inc.php';

// Navigation
require_once ROOT_PATH.'/inc/classes/nav.class.php';

// Permissions class
require_once ROOT_PATH.'/inc/classes/permissions.class.php';
permissions::init($db, $config);

// Page generation
require_once ROOT_PATH.'/inc/classes/page.class.php';
require_once ROOT_PATH.'/inc/page.inc.php';

// Language parser
require_once ROOT_PATH.'/inc/classes/language.class.php';
require_once ROOT_PATH.'/inc/language.inc.php';

// User and group
require_once ROOT_PATH.'/inc/classes/user.class.php';
require_once ROOT_PATH.'/inc/classes/group.class.php';
require_once ROOT_PATH.'/inc/user.inc.php';


?>
