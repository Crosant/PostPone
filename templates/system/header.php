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

?>
    <!--### Header start ###-->
    <head>
        
        <!-- Meta tags -->
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name = "generator" content = "PostPone <?=VERSION?>" />
        
        <!-- Stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?=ROOT_URL?>/templates/system/system.css" />
        
        <title><?=$title?></title>
        
    </head>
    <!--### Header end ###-->
