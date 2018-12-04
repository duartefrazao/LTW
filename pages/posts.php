<?php 
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_posts.php");
    include_once("../database/db_post.php");
    include_once("../database/db_user.php");
    include_once("../includes/session.php");
    include_once("utilities.php");

    if(isset($_SESSION['username']))
    {
        $posts = getPosts($_SESSION['username'], time());
        draw_header_global($_SESSION['username']);
    }
    else
    {
        $posts = getPosts(null, time());
        draw_header_global(null);
    }

    includeScript("vote_system");

    draw_posts($posts);
    
    draw_footer();
?>