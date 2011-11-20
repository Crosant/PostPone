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

// Read the config file
$config = Spyc::YAMLLoad("config.yml");

// Error?
if($config === false) {
    die("Error while reading the configuration file.");
}

// Debug
print_r($config);
?>
