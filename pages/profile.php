<?php
    
    
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_posts.php");
    include_once("../templates/tpl_user.php");
    include_once("../database/db_post.php");
    include_once("../database/db_user.php");
    include_once("../includes/session.php");
    include_once("../actions/action_store_token.php");
    
    $criteria = 'mostrecent'; 
    $user =null;
    $username = $_GET['user'];

    if(!isset($username))
        header('Location: posts.php');

    if(isset($_SESSION['username']))
        $user = $_SESSION['username'];
    
    $posts = getPostsOfUser($username,$user, PHP_INT_MAX, $criteria);
    
    $info = getUserInfo($username);


    draw_header($user);
    includeScript("vote_system");
    includeScript("posts_scroll"); 
    includeScript("search_system");
    includeScript("settings");
    draw_profile($username,$info,$posts);
    draw_footer(); 

    storeToken();
?>