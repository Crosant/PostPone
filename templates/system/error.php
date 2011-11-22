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

// Checking error vars/array
if(!isset($error_data)) {
    
    // Setting default values
    $error_data = Array();
    $error_data['type'] = UNEXP_ERR;
    $error_data['message'] = "Unexpected error.";
    $error_data['line'] = null;
    $error_data['file'] = null;
    
}

// Type (const) => title
switch ($error_data['type']) {
    case UNEXP_ERR:
        $error_data['title'] = "Unexpected error";
        break;
    case MYSQL_ERR:
        $error_data['title'] = "MySQL error";
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

?>
<html>
<?php
        require 'header.php';
?>
    <!---------- Body start ---------->
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
                    <p>
                        Error occured in <strong><?=nl2br($error_data['file'], true)?></strong><br />
                        on line <strong><?=nl2br($error_data['line'], true)?></strong>.
                    </p>
                    <p>
                        <a href="javascript:history.back();" >&laquo; back</a>
                    </p>
                </div>
            </div>
        </div>
    </body>
    <!---------- Body end ---------->
</html>