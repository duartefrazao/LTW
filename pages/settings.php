<?php
    
    include_once("../includes/session.php");
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_user.php");
    include_once("../database/db_user.php");



    if(isset($_SESSION['username'])){
        $user = $_SESSION['username'];
    }
    else
    {
        header('Location: posts.php');
    }

    $info = getUserInfo($user);


    draw_simple_header();
    draw_settings($user,$info);
    draw_footer(); 

?>