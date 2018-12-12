<?php
    
    include_once("../includes/session.php");
    include_once("../templates/tpl_common.php");
    include_once("../database/db_user.php");



    if(isset($_SESSION['username'])){
        $user = $_SESSION['username'];
    }
    else
    {
        header('Location: pages/posts.php');
    }


    draw_simple_header();

?>