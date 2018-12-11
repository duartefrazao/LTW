<?php
    
    
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_posts.php");
    include_once("../templates/tpl_user.php");
    include_once("../database/db_post.php");
    include_once("../database/db_user.php");
    include_once("../includes/session.php");
    $criteria = 'mostrecent'; 
    $user =null;
    $username = $_GET['user'];

    if(isset($_SESSION['username'])){
        $user = $_SESSION['username'];
        $posts = getPostsOfUser($username,$_SESSION['username'], PHP_INT_MAX, $criteria);
    }
    else
    {
        $posts = getPostsOfUser($username,null,  PHP_INT_MAX, $criteria);
    }
    $info = getUserInfo($username);



    includeScript("vote_system");
    includeScript("posts_scroll"); 
    draw_header($user);
    draw_profile($username,$info,$posts);
    draw_footer(); 
?>