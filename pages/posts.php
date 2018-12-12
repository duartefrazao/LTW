<?php 
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_posts.php");
    include_once("../database/db_post.php");
    include_once("../database/db_user.php");
    include_once("../database/db_upload.php");
    include_once("../includes/session.php");
    include_once("utilities.php");

    $criteria = 'mostrecent'; 


    if(isset($_SESSION['username']))
    {
        $posts = getPosts($_SESSION['username'], PHP_INT_MAX,  $criteria);
        draw_header_global($_SESSION['username']);
    }
    else
    {
        $posts = getPosts(null, PHP_INT_MAX, $criteria);
        draw_header_global(null);
    }

    $images = getAllImages();

    includeScript("vote_system");
    includeScript("posts_scroll");
    includeScript("search_system");

    draw_search();

    draw_ordering();

    draw_posts($posts);
    
    draw_footer();
?>