<?php 
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_posts.php");
    include_once("../database/db_post.php");
    include_once("../database/db_user.php");
    include_once("../includes/session.php");
    include_once("utilities.php");

    $posts = getPosts($_SESSION['username']);
    draw_header_global($_SESSION['username']);
    includeScript("vote_system");
    draw_posts($posts);
    draw_footer();
?>