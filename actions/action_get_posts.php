<?php
    include_once('../includes/session.php');
    include_once('../database/db_post.php');


    $permission = true;
    $posts = array();

    $offset = getCreationDate($_POST['lastId']);


    if(isset($_POST['username'])){
        $posts = getPosts($_SESSION['username'], array_values($offset)[0]);
    }
    else{
        $posts = getPosts(null, array_values($offset)[0]);
    }
    
    $response = array('result' => $permission, 'data' => $posts);

    echo json_encode($response);
?>