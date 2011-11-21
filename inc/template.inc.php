<?php

/**
 * @author SkyIrc development team <skyirc@skyirc.net>
 * @copyright Copyright (c) SkyIrc
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @package PostPone
 */

// Declare the template object
$template = new Smarty();

// Configure the object
$template->left_delimiter = "{";
$template->right_delimiter = "}";

$template->template_dir = ROOT_DIR."templates";
$template->compile_dir = ROOT_DIR."templates/compiled";
$template->config_dir = ROOT_DIR."templates/config";
$template->cache_dir = ROOT_DIR."templates/cache";

$template->caching = false;

$template->debugging = false;

/**#@+
 * 
 * Template functions
 * 
 * @author SkyIrc development team <skyirc@skyirc.net>
 * @copyright Copyright (c) SkyIrc
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @package PostPone
 */


function error($message, $file = NULL, $line = NULL, $data = Array()) {
    
    // TODO Add error output
    
}

?>
