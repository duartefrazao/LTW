<?php
    include_once('../includes/session.php');
    include_once('../database/db_channel.php');
    include_once('../actions/action_verify_input.php');


    $permission = true;
    $posts = array();

    $channel= test_input($_POST['channel']);

    if(isset($_POST['username'])){
        $posts = getPostsFromChannel($_SESSION['username'], PHP_INT_MAX,$channel);
    }
    else{
        $posts = getPostsFromChannel(null, PHP_INT_MAX,$channel);
    }

    $channel2 = getChannel($channel);
    $_SESSION['posts'] = $posts;
    $_SESSION['channel'] = $channel2;
    
    header('Location: ../pages/channel.php');
?>