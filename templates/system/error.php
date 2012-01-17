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

// Checking error vars/array
if(!isset($error_data)) {
    
    // Setting default values
    $error_data = Array();
    $error_data['type'] = ERR_UNEXP;
    $error_data['message'] = "Unexpected error.";
    $error_data['line'] = null;
    $error_data['file'] = null;
    
}

// Type (const) => title
switch ($error_data['type']) {
    case ERR_UNEXP:
        $error_data['title'] = "Unexpected error";
        break;
    case ERR_MYSQL:
        $error_data['title'] = "MySQL error";
        break;
    case ERR_PERMS:
        $error_data['title'] = "Insufficient Permissions (403)";
        break;
    case ERR_NOT_FOUND:
        $error_data['title'] = "Page not found (404)";
        break;
    
    // If none specified, set unexpected
    default:
        $error_data['title'] = "Unexpected error";
        break;
}

// Checking the message
if(empty($error_data['message'])) {
    $error_data['message'] = "Unexpected error.";
}


// Checking the file
if(empty($error_data['line'])) {
    $error_data['file'] = null;
}
// Append filename to the title
else {
    $error_data['title'] .= " in ".$error_data['file'];
}


// Checking the line
if(empty($error_data['line']) || !is_numeric($error_data['line'])) {
    $error_data['line'] = null;
}
// Append line to the title
else {
    $error_data['title'] .= " on line ".$error_data['line'];
}

// Declare the 'occurance in/on' text
// TODO cleanup?
$occurance = "";
if(!empty($error_data['line']) || !empty($error_data['file'])) {
    $occurance .= "Error occured";
    
    if(!empty($error_data['file'])) {
        $occurance .= " in <strong>".$error_data['file']."</strong>";
        if(!empty($error_data['line'])) {
            $occurance .= "<br /> on line <strong>".$error_data['line']."</strong>";
        }
    }
 
    $occurance .= ".";
    
}

// Title
$title = $error_data['title'];


?>
<!DOCTYPE html>
<html>
<?php
        require 'header.php';
?>
    
    <!--### Body start ###-->
    <body>
        <div class="error_wrapper_abs">
            <div class="error_wrapper">
                <div class="error_title">
                    
                    <?=htmlentities($error_data['title'])?>
                    
                </div>
                <div class="error_message">
                    <p>
                        
                        <?=nl2br($error_data['message'], true)?>
                        
                    </p>
<?php if(!empty($occurance)) {
    ?>
                    <p>
                        
                        <?=$occurance?>
                        
                    </p>
<?php
} 
?>
                    <p>
                        <a href="javascript:history.back();" >&laquo; back</a>
                    </p>
                </div>
            </div>
        </div>
    </body>
    <!--### Body end ###-->
</html>
