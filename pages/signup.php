<?php
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_auth.php');

    includeScript("verify_input"); 

    draw_simple_header();
    draw_signup();
    draw_footer();
?>