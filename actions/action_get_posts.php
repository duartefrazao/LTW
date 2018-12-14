<?php
    include_once('../includes/session.php');
    include_once('../database/db_post.php');
    include_once('../actions/action_verify_input.php');

    $permission = true;
    $posts = array();

    $offset = test_input($_POST['offset']);

    $criteria = test_input($_POST['criteria']);

    $name = test_input($_POST['name']);



    if($name !="null")
    {
        if(isset($_SESSION['username'])){
            $posts = getPostsOfUser($name ,$_SESSION['username'], $offset, $criteria);
        }
        else{
            $posts = getPostsOfUser($name ,null,  $offset, $criteria);
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
    if(isset($_SESSION['id']))
        $id=$_SESSION['id'];
    else 
        $id = null;
    $response = array('result' => $permission, 'data' => $posts , 'id' => $id);

    echo json_encode($response);
?>