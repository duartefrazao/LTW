<?php
    include_once "../templates/tpl_common.php";
    include_once "../templates/tpl_posts.php";
    include_once "../database/db_post.php";
    include_once "../includes/session.php";
    /*
    $posts;
    if (!isset($_SESSION['username'])) {
        $posts = getPostsLogged($_SESSION['username']);
        draw_header($_SESSION['username']);
        draw_posts_logged($posts);
    } else {
        $posts = getPostsGuest();
        draw_header($_SESSION['username']);
        draw_posts_guest($posts);
    }
    */
    $posts = getPostsGuest();
    print_r($posts);
    draw_header($_SESSION['username']);
    draw_posts_guest($posts);
    draw_footer();

?>