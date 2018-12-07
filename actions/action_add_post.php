<?php
    include_once('../includes/session.php');
    include_once('../database/db_post.php');
    include_once('../actions/action_add_image.php');

    if(!isset($_SESSION['username'])){
        die(header('Location: ../pages/login.php'));
    }

    addNewPost($_POST['title'], $_POST['text'], $_SESSION['id']);

    createImageResource(getLastPostId(), 'posts', $_POST['title']);
    header('Location: ../pages/posts.php');
?>