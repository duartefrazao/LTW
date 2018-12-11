<?php
    include_once('../includes/session.php');
    include_once('../database/db_post.php');


    $permission = true;
    $posts = array();

    $offset = $_POST['offset'];

    $criteria = $_POST['criteria'];



    if($_POST['name']!="null")
    {
        if(isset($_SESSION['username'])){
            $posts = getPostsOfUser($_POST['name'],$_SESSION['username'], $offset, $criteria);
        }
        else{
            $posts = getPostsOfUser($_POST['name'],null,  $offset, $criteria);
        }
    }
    else
    {
        if(isset($_SESSION['username'])){
            $posts = getPosts($_SESSION['username'], $offset, $criteria);
        }
        else{
            $posts = getPosts(null,  $offset, $criteria);
        }
    }
    
    $response = array('result' => $permission, 'data' => $posts);

    echo json_encode($response);
?>