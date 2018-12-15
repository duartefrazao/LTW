<?php
    include_once('../includes/session.php');
    include_once('../database/db_post.php');
    include_once('../actions/action_add_image.php');
    include_once('../actions/action_verify_input.php');

    if(!isset($_SESSION['username']) || $_SESSION['csrf'] != $_GET['csrf']){
        die(header('Location: ../pages/posts.php'));
    }

    $title = test_input($_POST['title']);
    $text = test_input($_POST['text']);
    $channel = test_input($_POST['channel']);
    $imageDescription = test_input($_POST['description']);


    addNewPost($title, $text, $_SESSION['id'], $channel);
    createImageResource(getLastPostId(), 'posts', $imageDescription);
    header('Location: ../pages/posts.php');
?>