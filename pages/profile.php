<?php
    
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_posts.php");
    include_once("../templates/tpl_user.php");
    include_once("../database/db_post.php");
    include_once("../database/db_user.php");
    include_once("../includes/session.php");


    if(isset($_SESSION['username']))
    {
        $user = $_SESSION['username'];
        draw_header($user);
        ?>
        <section class = "user_page">
        <?php
        $info = getUserInfo($user);
        draw_user_info($info);
        $posts = getPostByUser($user);
        draw_posts($posts);
        ?>
        </section>
        <?php
    }
    else
    {
        header('Location: posts.php');
    }
    
?>