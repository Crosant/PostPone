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
        
        <!-- Favicon -->
        <link rel="shortcut icon" type="<?php echo $template->config("fav_mime"); ?>" href="<?php echo ROOT_URL."/".$template->config("favicon"); ?>" />
        
        <title><?php echo $config->get('meta.title'); ?> | <?php echo $page->title; ?></title>
        
    </head>
    <body>

        <!-- Start wrapper -->
        <div id="wrapper">
            <!-- Start navigation -->
<?php
            nav::output($page->id);
?>
            
            <!-- End navigation -->
            
            
            <!-- Start logo -->
            <div id="logo"></div>
            <!-- End logo -->

            
            <!-- Start conent -->
            <div id="content">


<?php
                // Include content
                if($page->type == PAGE_FILE) {
                    include(ROOT_PATH."/pages/".$page->file);
                }
                else {
                    echo $page->text;
                }
?>


            </div>
            <!-- End content -->
            
            
            <!-- Start footer -->
            <div id="footer-wrapper">
                <div id="footer">
                    <a href="/impressum/">Impressum</a>
                </div>
            </div>
            <!-- End footer -->
        </div>
        <!-- End wrapper -->
    </body>
</html>