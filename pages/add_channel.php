<?php
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_channel.php");
    include_once("../database/db_user.php");
    include_once("../database/db_channel.php");
    include_once("../includes/session.php");
    include_once("utilities.php");
    include_once("../actions/action_store_token.php");

    if(!isset($_SESSION['username']) || $_SESSION['csrf'] != $_GET['csrf'])
        die(header('Location: posts.php'));

    draw_header_global($_SESSION['username']);

    includeScript("file_upload_button");
    includeScript("search_system");

    drawAddChannel();

    draw_footer();

    storeToken();
?>