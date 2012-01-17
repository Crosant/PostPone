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
 * @author SkyIrc development team <skyirc@skyirc.net>
 * @copyright Copyright (c) SkyIrc
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @package PostPone
 */

function error($type, $message, $line = null, $file = null) {
    
    $error_data = Array();
    
    $error_data['type'] = $type;
    $error_data['message'] = $message;
    $error_data['line'] = $line;
    $error_data['file'] = $file;
    
    include ROOT_PATH."/templates/system/error.php";
    
    exit;
    
}

/**#@-*/
?>
