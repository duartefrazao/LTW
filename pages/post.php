<?php 
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_posts.php");
    include_once("../templates/tpl_comment.php");
    include_once("../database/db_post.php");
    include_once("../database/db_comments.php");
    include_once("../includes/session.php");
    include_once("utilities.php");
    include_once("../actions/action_store_token.php");
    
    if (!isset($_GET['id']))
        header('Location: posts.php'); 

    $user=isset($_SESSION['id'])?$_SESSION['id']:NULL;

    $post = getPostById($_GET['id'],$user);
    draw_header_global($user); 
    includeScript("vote_system");
    includeScript("comment_system"); 
    draw_post($post);
    draw_footer();

    storeToken();
?>