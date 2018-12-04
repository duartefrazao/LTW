<?php
    include_once('../includes/session.php');
    include_once('../database/db_comments.php');

    $permission = true;
    $comments = array();
    
    if(!isset($_SESSION['username'])){
        $permission = false;
    }else{

    $content = $_POST['text'];
    $parent_id = $_POST['parent_id'];
    addComment($parent_id, $_SESSION['id'], $content);
    $comments = getCommentsAfterId($parent_id, $_POST['comment_id']);
    }

    $response = array('result' => $permission, 'data' => $comments);

    echo json_encode($response);
?>