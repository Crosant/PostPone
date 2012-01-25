<?php

/**
 * @author SkyIrc development team <skyirc@skyirc.net>
 * @copyright Copyright (c) SkyIrc
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @package PostPone
 */

?>
<!DOCTYPE html>
<html>
    <head>
        
        <!-- Meta information -->
<?php
        $template->print_meta(8);
?>
        
        <!-- Stylesheet and JavaScript -->
<?php
        $template->print_includes(8);
?>   
        
        <title><?php echo $config->get('meta.title'); ?> | <?php echo $page->title; ?></title>
        
    </head>
    <body>
       <!--
        <div id="wrapper">
            
            <div id="content">
<?php
            if($page->type == PAGE_FILE) {
                include(ROOT_PATH."/pages/".$page->file);
            }
            else {
                echo $page->text;
            }
?>
                
            </div>
            <div class="clear">
            </div>
            <div id="footer-container">
                <div id="footer">
                    I am a footer!
                </div>
            </div>
        </div>-->


        <div id="wrapper">
            <div id="logo"></div>

            <br />
            <div id="content">

                <!-- ### Start Content ### -->

<?php
                // Include content
                if($page->type == PAGE_FILE) {
                    include(ROOT_PATH."/pages/".$page->file);
                }
                else {
                    echo $page->text;
                }
?>

                <!-- ### End Content ### -->


            </div>
            <div id="clear">
            </div>
            <div id="footer-container">
                <div id="footer">
                    <a href="/impressum/">Impressum</a>
                </div>
            </div>
        </div>
    </body>
</html>