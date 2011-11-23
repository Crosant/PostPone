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
<html>
    <head>
        
        <!-- Meta -->
<?php
        $template->print_meta(8);
?>
        <!-- CSS and JS -->
<?php
        $template->print_includes(8);
?>
        
        <title><?php echo $config['meta']['title']?></title>
        
    </head>
    <body>
        
    </body>
</html>