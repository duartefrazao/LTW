<?php 
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_posts.php");
    include_once("../database/db_post.php");
    include_once("../database/db_user.php");
    include_once("../database/db_upload.php");
    include_once("../includes/session.php");
    include_once("utilities.php");

    $criteria = 'mostrecent'; 
    $user = null;

    if(isset($_SESSION['username']))    
        $user = $_SESSION['username'];
        $posts = getPosts($user, PHP_INT_MAX,  $criteria);

    draw_header($user);
    
    $images = getAllImages();

    includeScript("posts_scroll");
    includeScript("vote_system");
    includeScript("search_system");

    draw_ordering();

    draw_posts($posts);
    
    draw_footer();
?>