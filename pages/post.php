<?php 
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_posts.php");
    include_once("../templates/tpl_comment.php");
    include_once("../database/db_post.php");
    include_once("../database/db_comments.php");
    include_once("../includes/session.php");

    if (!isset($_GET['id']))
        header('Location: posts.php');

    $post = getPostById($_GET['id']);

    $comments = getCommentsByPostId($_GET['id']);

    draw_header($_SESSION['username']);
    draw_post($post);
    draw_comments($comments);
    draw_footer(); 
?>