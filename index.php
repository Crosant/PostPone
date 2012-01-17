<?php

/**
 * @author SkyIrc development team <skyirc@skyirc.net>
 * @copyright Copyright (c) SkyIrc
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @package PostPone
 */

// Debug?
if(isset($_GET['debug'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1); 
}

// Save time of beginning of page loading
$start_time = microtime(true);

/*
 * Defines
 */

// Define for denying call of seperate files
define("IN_POSTPONE", true);


// Current version of PostPone
define("VERSION", "0.1-dev");



// Absolute path
$root_path = $_SERVER['DOCUMENT_ROOT'];

define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT']);

// Root URL
$root_url = 'http';
    if (!empty($_SERVER["HTTPS"])) {
        $root_url .= "s";
    }
    $root_url .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $root_url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
    } 
    else {
        $root_url .= $_SERVER["SERVER_NAME"];
    }
define("ROOT_URL", $root_url);

// Require file for including all includes
require_once ROOT_PATH."/inc/common.inc.php";



// Include template
require($template->get_main_file());

?>
