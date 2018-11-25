<?php 
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_posts.php");
    include_once("../database/db_post.php");
    include_once("../includes/session.php");

    $posts = getPosts();
    draw_header($_SESSION['username']);
    draw_posts($posts);
    draw_footer();
?>