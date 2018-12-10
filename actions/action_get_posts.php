<?php
    include_once('../includes/session.php');
    include_once('../database/db_post.php');


    $permission = true;
    $posts = array();

    $lastId = $_POST['lastId'];

    $offset = $_POST['offset'];

    $criteria = $_POST['criteria'];

    if(isset($_POST['username'])){
        $posts = getPosts($_SESSION['username'], $lastId, $offset, $criteria);
    }
    else{
        $posts = getPosts(null, $lastId, $offset, $criteria);
    }
    
    $response = array('result' => $permission, 'data' => $posts);

    echo json_encode($response);
?>