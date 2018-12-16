<?php 
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_search.php");
    include_once("../templates/tpl_posts.php");
    include_once("../database/db_post.php");
    include_once("../database/db_user.php");
    include_once("../database/db_upload.php");
    include_once("../database/db_channel.php");
    include_once("../includes/session.php");
    include_once('../actions/action_verify_input.php');
    include_once("utilities.php");
    include_once("../actions/action_store_token.php");
    

    $search= test_input($_POST['search']);
    $user =null;

    if(isset($_SESSION['username'])){
        $user = $_SESSION['username'];
    }

    $posts = getSimilarPosts($user,$search);
    $channels = getSimilarChannels($search);
    $users = getSimilarUsers($search);
    draw_header_global($user);
   

    includeScript("vote_system"); 
    includeScript("search_system");
    draw_search_results($channels,$users,$posts);
    
    draw_footer();

    storeToken();
?>