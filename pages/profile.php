<?php
    
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_posts.php");
    include_once("../database/db_post.php");
    include_once("../includes/session.php");


    if(isset($_SESSION['username']))
    {
        $user = $_SESSION['username'];
        draw_header($user);
        $posts = getPostByUser($user);
        draw_posts($posts);
    }
    else
    {
        header('Location: posts.php');
    }
    
?>