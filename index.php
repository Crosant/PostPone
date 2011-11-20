<?php

/**
 * @author SkyIrc development team
 * @copyright Copyright (c) SkyIrc
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 */

// Debug?
if(isset($_GET['debug'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1); 
}

// Save time of beginning of page loading
$start_time = microtime(true);

// Define for denying call of seperate files
define("IN_POSTPONE", true);

// Require file for including all includes
require_once "inc/common.inc.php";


?>