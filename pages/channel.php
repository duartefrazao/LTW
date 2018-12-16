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
    $userId = null;
    $channel = $_GET['channel'];

    if(isset($_SESSION['username'])){
        $user = $_SESSION['username'];
        $userId = $_SESSION['id'];
        $channelInfo = getChannelWithUserInfo($channel,$userId);
    }else
        $channelInfo = getChannel($channel);

    $channelPosts = getPostsFromChannel($user,PHP_INT_MAX,'-mostrecent',$channel);
    draw_header_global($user);
    
    storeChannelInfo($channel,$userId);
    includeScript("vote_system");
    includeScript("posts_scroll"); 
    includeScript("search_system"); 
    includeScript("channel");

    drawChannelPage($channelInfo,$channelPosts);
    
    draw_footer(); 

    storeToken();
?>