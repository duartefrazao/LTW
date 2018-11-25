<?php
    include_once('../database/db_post.php');
    include_once('../includes/session.php');

    if($_SESSION['username'] === NULL){
        header('Location: ../pages/login.php');
    }

    $id=$_GET['id'];
    $type=$_GET['type'];

    if(abs($type) !=1)
        return;

    vote($id,$type);

    header("Location: ../pages/posts.php");

?>