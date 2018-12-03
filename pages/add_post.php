<?php
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_posts.php");
    include_once("../database/db_post.php");
    include_once("../database/db_user.php");
    include_once("../includes/session.php");
    include_once("utilities.php");

    draw_header_global($_SESSION['username']);

    draw_add_post();

    draw_footer();
?>