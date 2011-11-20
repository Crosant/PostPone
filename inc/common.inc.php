<?php

/**
 * @author SkyIrc development team
 * @copyright Copyright (c) SkyIrc
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

// Restrict access
if(!IN_POSTPONE) {
    die("Do not open files seperately!");
}

// YAML parse class
require_once ROOT_PATH.'inc/classes/spyc.class.php';

// Configuration
require_once ROOT_PATH.'inc/config.inc.php';

// MySQL class
require_once ROOT_PATH.'inc/classes/mysql.class.php';
require_once ROOT_PATH.'inc/mysql.inc.php';


?>
