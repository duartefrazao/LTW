<?php
    include_once('../includes/session.php');
    include_once('../database/db_post.php');


    $permission = true;
    $posts = array();

    $offset = $_POST['lastId'];


    if(isset($_POST['username'])){
        $posts = getPosts($_SESSION['username'], $offset);
    }
    else{
        $posts = getPosts(null, $offset);
    }
    
    $response = array('result' => $permission, 'data' => $posts);

    echo json_encode($response);
?>