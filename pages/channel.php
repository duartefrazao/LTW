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


    $user = isset($_SESSION['username']) ? $_SESSION['username'] : null;

    $channel = $_GET['channel'];
    $channelInfo = getChannel($channel);
    draw_header_global($user);
    

    includeScript("vote_system");
    includeScript("posts_scroll"); 
    includeScript("search_system"); 

    drawChannelPage($channelInfo);
    
    draw_footer();

    storeToken();
?>