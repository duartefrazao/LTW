<?php
    include_once('../includes/session.php');
    include_once('../database/db_post.php');


    $permission = true;
    $posts = array();

    $offset = $_POST['offset'];

    $criteria = $_POST['criteria'];

    if(isset($_POST['username'])){
        $posts = getPosts($_SESSION['username'], $offset, $criteria);
    }
    else{
        $posts = getPosts(null,  $offset, $criteria);
    }
    
    $response = array('result' => $permission, 'data' => $posts);

    echo json_encode($response);
?>