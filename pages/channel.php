<?php 
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_posts.php");
    include_once("../templates/tpl_channel.php");
    include_once("../database/db_post.php");
    include_once("../database/db_user.php");
    include_once("../database/db_upload.php");
    include_once("../includes/session.php");
    include_once("utilities.php");

    $posts = $_SESSION['posts'];
    $channel = $_SESSION['channel'];
    if(isset($_SESSION['username']))
    {
        draw_header_global($_SESSION['username']);
    }
    else
    {
        draw_header_global(null);
    }

    $images = getAllImages();

    includeScript("vote_system");
    includeScript("posts_scroll");  
    drawChannelInfo($channel);
    draw_posts($posts);
    
    draw_footer();
?>