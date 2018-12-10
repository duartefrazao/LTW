<?php
    
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_posts.php");
    include_once("../templates/tpl_user.php");
    include_once("../database/db_post.php");
    include_once("../database/db_user.php");
    include_once("../includes/session.php");

    $user = $_GET['user'];
    $posts = getPostByUser($user);
    $info = getUserInfo($user);

    includeScript("vote_system");
    includeScript("posts_scroll"); 
    draw_header($_SESSION['username']);
    draw_profile($user,$info,$posts);
    draw_footer(); 
?>