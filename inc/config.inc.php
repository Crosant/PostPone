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

// Read the config file
$config = Spyc::YAMLLoad(ROOT_PATH."inc/config.yml");

// Error?
if($config === false) {
    die("Error while reading the configuration file.");
}

?>
