<?php
    include_once('../includes/session.php');
    include_once('../database/db_comments.php');


    if(!isset($_SESSION['username'])){
        header('Location: ../pages/login.php');
    }

    $content = $_POST['text'];
    $parent_id = $_POST['parent_id'];
    addComment($parent_id, $_SESSION['id'], $content);

    $comments = getCommentsAfterId($parent_id, $_POST['comment_id']);

    echo json_encode($comments);
?>