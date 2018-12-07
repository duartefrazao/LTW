<?php

    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../database/db_upload.php');
    include_once('../actions/action_add_image.php');

    $username= $_POST['username'];
    $password=$_POST['password'];
    $mail=$_POST['mail'];
    $description=$_POST['description'];
    $imageTitle = $_POST['title'];

    $creationDate=time();

     try{
        insertUser($username,$password,$mail,$description,$creationDate);
        createImageResource(getUserId($username)['id'], 'users', $imageTitle);
        $_SESSION['username']=$username;
        $_SESSION['id']=checkUserPassword($username)['id'];
        header('Location: ../pages/posts.php');
    }catch(PDOException $e){
        header('Location: ../pages/signup.php');
    }
 
?>

