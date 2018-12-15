<?php
    include_once('../includes/session.php');
    include_once('../database/db_post.php');
    include_once('../actions/action_add_image.php');
    include_once('../actions/action_verify_input.php');

    if(!isset($_SESSION['username'])){
        die(header('Location: ../pages/posts.php'));
    }

    $title = test_input($_POST['title']);
    $text = test_input($_POST['text']);
    $channel = test_input($_POST['channel']);


    addNewPost($title, $text, $_SESSION['id'], $channel);
    createImageResource(getLastPostId(), 'posts', $title);
    header('Location: ../pages/posts.php');
?>