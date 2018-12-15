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
    include_once("../actions/action_store_token.php");


    $user =null;

    if(isset($_SESSION['username'])){
        $user = $_SESSION['username'];
    }

    $channel = $_GET['channel'];
    $channelInfo = getChannel($channel);
    $channelPosts = getPostsFromChannel($_SESSION['username'],PHP_INT_MAX,$channel);

    draw_header_global($user);

    includeScript("vote_system");
    includeScript("posts_scroll"); 
    includeScript("search_system"); 

    drawChannelPage($channelInfo, $channelPosts);
    
    draw_footer();

    storeToken();
?>