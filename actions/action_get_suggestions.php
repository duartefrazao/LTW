<?php

    include_once('../database/db_channel.php');
    include_once('../actions/action_verify_input.php');

    $suggestions = null;

    if(isset($_POST['search']) && $_POST['search'] != ""){
        $name= test_input($_POST['search']);
        $suggestions = getSimilarChannelsAndUsers($name);
    }
    echo json_encode($suggestions);
?>