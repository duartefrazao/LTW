<?php 
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_posts.php");
    include_once("../database/db_post.php");
    include_once("../database/db_user.php");
    include_once("../database/db_upload.php");
    include_once("../includes/session.php");
    include_once("../actions/action_store_token.php");
    include_once("utilities.php");

    $user=isset($_SESSION['id'])?$_SESSION['id']:NULL;
    $page = "subs";
    
    draw_header_global($user);

    includeScript("posts_scroll");
    includeScript("vote_system");
    includeScript("search_system");

    draw_ordering();

    storePageLocation($page);

    draw_posts();

    draw_add_button();
    
    draw_footer();

    removePageLocation("subs");
    storeToken();
?>