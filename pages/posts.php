<?php 
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_posts.php");
    include_once("../database/db_post.php");

    $posts = getPosts();

    draw_header(null);
    draw_posts($posts);
    draw_footer();
?>