<?php
    include_once('../includes/session.php');
    include_once('../database/db_channel.php');
    include_once('../actions/action_add_image.php');
    include_once('../database/db_upload.php');
    include_once('../actions/action_verify_input.php');

    if(!isset($_SESSION['username'])){
        die(header('Location: ../pages/posts.php'));
    }

    $title = test_input($_POST['title']);
    $description = test_input($_POST['description']);

    insertNewChannel($title, $description);

    createImageResource(getLastChannelId(), 'channels', $title);

    header('Location: ../pages/posts.php');
?>