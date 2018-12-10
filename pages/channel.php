<?php 
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_posts.php");
    include_once("../templates/tpl_channel.php");
    include_once("../database/db_post.php");
    include_once("../database/db_user.php");
    include_once("../database/db_upload.php");
    include_once("../database/db_channel.php");
    include_once("../includes/session.php");
    include_once("utilities.php");


    $user =null;

    if(isset($_SESSION['username'])){
        $user = $_SESSION['username'];
    }

    $channel = $_GET['channel'];
    $channelInfo = getChannel($channel);
    $channelPosts = getPostsFromChannel($_SESSION['username'],PHP_INT_MAX,$channel);

    includeScript("vote_system");
    includeScript("posts_scroll");  

    draw_header_global($user);
    drawChannelInfo($channelInfo);
    draw_posts($channelPosts);
    
    draw_footer();
?>