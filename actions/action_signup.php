<?php

    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    

    $username= $_POST['username'];
    $password=$_POST['password'];
    $mail=$_POST['mail'];
    $description=$_POST['description'];
    $creationDate=time();


    
     try{
        insertUser($username,$password,$mail,$description,$creationDate);
        $_SESSION['username']=$username;
        header('Location: ../pages/posts.php');
    }catch(PDOException $e){
        header('Location: ../pages/signup.php');
    }
 
?>