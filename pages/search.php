<?php 
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_search.php");
    include_once("../templates/tpl_posts.php");
    include_once("../database/db_post.php");
    include_once("../database/db_user.php");
    include_once("../database/db_upload.php");
    include_once("../database/db_channel.php");
    include_once("../includes/session.php");
    include_once("utilities.php");

    $search=$_POST['search'];
    $user =null;

    if(isset($_SESSION['username'])){
        $user = $_SESSION['username'];
    }

    $posts = getSimilarPosts($user,$search);
    $channels = getSimilarChannels($search);
    $users = getSimilarUsers($search);
    
    draw_header_global($_SESSION['username']);
   

    $images = getAllImages();

    includeScript("vote_system");
    includeScript("posts_scroll"); 
    draw_channels_search($channels);
    draw_users_search($users);
    draw_posts_search($posts);
    
    draw_footer();
?>