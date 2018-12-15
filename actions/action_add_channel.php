<?php
    include_once('../includes/session.php');
    include_once('../database/db_channel.php');
    include_once('../actions/action_add_image.php');
    include_once('../database/db_upload.php');
    include_once('../actions/action_verify_input.php');

    if(!isset($_SESSION['username']) || $_SESSION['csrf'] != $_GET['csrf']){
        die(header('Location: ../pages/posts.php'));
    }

    $title = test_input($_POST['title']);
    $description = test_input($_POST['description']);
    $imageDescription = test_input($_POST['imageDescription']);

    insertNewChannel($title, $description);

    createImageResource(getLastChannelId(), 'channels', $imageDescription);

    header('Location: ../pages/posts.php');
?>