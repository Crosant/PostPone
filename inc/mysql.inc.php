<?php

/**
 * @author SkyIrc development team <skyirc@skyirc.net>
 * @copyright Copyright (c) SkyIrc
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @package PostPone
 */

// Restrict access
if(!IN_POSTPONE) {
    die("Do not open files seperately!");
}

// MySQL object
$db = new mysql();

// Connect to the MySQL Database
$db->connect($config['mysql']['server'], $config['mysql']['user'], $config['mysql']['password'])
        or error(MYSQL_ERR, "Failed connecting to the database:\n".$db->getLastError(), __LINE__, __FILE__);

// Select the database
$db->selectDb($config['mysql']['database'])
        or error(MYSQL_ERR, "Failed selecting the database:\n".$db->getLastError(), __LINE__, __FILE__);
 
// Set the charset to UTF-8
$db->setCharset("utf8")
        or error(MYSQL_ERR, "Failed setting the charset to UTF-8:\n".$db->getLastError(), __LINE__, __FILE__);
        
?>