<?php
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../database/db_user.php');
    include_once('../actions/action_verify_input.php');

    $permission = true;
    $comments = array();

    $username=$_POST['username'];
    $password=$_POST['password'];

    $user=checkUserPassword($username);
    if( $user!== false && password_verify($password,$user['password'])){
        $_SESSION['username']= $username;
        $_SESSION['id'] = $user['id'];
        header('Location: ../pages/posts.php');
    }else{
        header('Location: ../pages/login.php');
    }
?>