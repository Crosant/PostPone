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

// Get current page
if(isset($_GET['page'])) {
    
    $page_name = $_GET['page'];

}
else {
    
    // Set standard page
    $page_name = $config->get('std_page');
    
}

// ID of the current page
$page_id = page::name2id($page_name);

if($page_id === false) {
    // TODO: make a nicer 404 page
    error(ERR_NOT_FOUND, "Failed to find page '".$page_name."'.", __LINE__, __FILE__);
}

// Create the page object
$page = new page($page_id) 
    or error(ERR_UNEXP, "Failed to initialize the page.", __LINE__, __FILE__);

// Check permissions

/*if(!permissions::has_multiple_perms($user->id, $page->perms)) {
    error(ERR_PERMS, "You do not have the sufficient permissions to view this page:\n", __LINE__, __FILE__);
}*/
?>
