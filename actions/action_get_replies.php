<?php
    include_once('../includes/session.php');
    include_once('../database/db_comments.php');

    $permission = true;
    $comments = array();
    
    if(!isset($_SESSION['username'])){
        $permission = false;
    }else{

    $parent_id = $_POST['parent_id'];
    $comments = getChildComments($parent_id);
    }

    $response = array('result' => $permission, 'data' => $comments);

    echo json_encode($response);
?>