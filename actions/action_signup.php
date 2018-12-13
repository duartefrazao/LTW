<?php

    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../database/db_upload.php');
    include_once('../actions/action_add_image.php');
    include_once('../actions/action_verify_input.php');


    $username= $_POST['username'];
    $password=$_POST['password'];
    $mail=$_POST['mail'];
    $description=$_POST['description'];
    $imageTitle = $_POST['title'];

    $message =null;

    print_r($username);
    if(!verifyString($username)){
        $message=array('type'=>'error_username','content'=>'Characters <>*/\'\" are not allowed');
    }else if(!verifyString($password)){
        $message=array('type'=>'error_password','content'=>'Characters <>*/\'\" are not allowed');
    }else if(!verifyString($mail)){
        $message=array('type'=>'error_mail','content'=>'Insert a valid mail');
    }else if(!verifyString($description)){
        $message=array('type'=>'error_description','content'=>'Characters <>*/\'\" are not allowed');
    }else if(!verifyString($imageTitle)){
        $message=array('type'=>'error_imageTitle','content'=>'Characters <>*/\'\" are not allowed');
    }else{
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
    }

    echo json_encode($message);
 
?>

