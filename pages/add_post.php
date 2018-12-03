<?php
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_posts.php");
    include_once("../database/db_post.php");
    include_once("../database/db_user.php");
    include_once("../includes/session.php");

    if (isset($_SESSION['username']))
    {
        draw_header($_SESSION['username']);
    }
    else
    {
        draw_header(null);
    }

    draw_add_post();

    draw_footer();
?>