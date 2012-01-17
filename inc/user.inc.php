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

// Define user to be ID 0, which is guest
// TODO: get the real ID

$user = new stdClass();

$user->id = 0;
?>
