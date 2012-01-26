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

// Init static vars
user::init($db, $config, $language);
group::init($db, $config, $language);

$uid = user::sess_check();

// Check for login
if($uid <= 0) {

    // Normal user
    $user = new user($uid);
    $group = new group($user->group);

}
else {
    // Guest
    $user = new user(0);
    $group = new group($config->get("user.guest_group"));
}
?>
