<?php
    include_once('../includes/session.php');
    include_once('../database/db_comments.php');
    include_once('../actions/action_verify_input.php');

    $permission = true;
    $comments = array();
    
    if(!isset($_SESSION['username'])){
        $permission = false;
    }else{

    $content = test_input($_POST['text']);
    $parent_id = test_input($_POST['parent_id']);
    addComment($parent_id, $_SESSION['id'], $content);
    }

    $response = array('result' => $permission, 'data' => $comments);

    echo json_encode($response);
?>