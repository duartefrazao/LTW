<?php
    
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_posts.php");
    include_once("../templates/tpl_user.php");
    include_once("../database/db_post.php");
    include_once("../database/db_user.php");
    include_once("../includes/session.php");

    $user =null;

    if(isset($_SESSION['username'])){
        $user = $_SESSION['username'];
    }

    $username = $_GET['user'];
    $posts = getPostByUser($username);
    $info = getUserInfo($username);



    includeScript("vote_system");
    includeScript("posts_scroll"); 
    draw_header($user);
    draw_profile($username,$info,$posts);
    draw_footer(); 
?>