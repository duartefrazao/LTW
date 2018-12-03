<?php 
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_posts.php");
    include_once("../templates/tpl_comment.php");
    include_once("../database/db_post.php");
    include_once("../database/db_comments.php");
    include_once("../includes/session.php");

    if (!isset($_GET['id']))
        header('Location: posts.php');

    $post = getPostById($_GET['id'],$_SESSION['username']);

    $comments = getCommentsByPostId($_GET['id'],$_SESSION['id']);
    draw_header($_SESSION['username']);
    includeScript("vote_system");
    includeScript("comment_system");
    draw_post($post, $comments);
    draw_footer();
?>