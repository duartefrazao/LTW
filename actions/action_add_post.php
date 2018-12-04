<?php
    include_once('../includes/session.php');
    include_once('../database/db_post.php');
    if(!isset($_SESSION['username'])){
        header('Location: ../pages/login.php');
    }


    addNewPost($_POST['title'], $_POST['text'], $_SESSION['id']);
    header('Location: ../pages/posts.php');
?>