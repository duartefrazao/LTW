<?php

    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../database/db_upload.php');
    include_once('../actions/action_add_image.php');
    include_once('../actions/action_verify_input.php');


    $username = $_POST['username'];
    $password = $_POST['password'];
    $mail = $_POST['mail'];
    $description= $_POST['description'];
    $imageTitle = isset($_POST['title']) ? $_POST['title'] : NULL;

    $message = array('type' => true, 'content' => 'Signed up successfully');


    if(!verifyString($username)){
        $message=array('type'=>'error_username','content'=>'Characters <>*/\'\" are not allowed');
    }else if(!verifyString($password)){
        $message=array('type'=>'error_password','content'=>'Characters <>*/\'\" are not allowed');
    }else if(!verifyEmail($mail)){
        $message=array('type'=>'error_mail','content'=>'Insert a valid mail');
    }else if(!verifyString($description)){
        $message=array('type'=>'error_description','content'=>'Characters <>*/\'\" are not allowed');
    }else if(!verifyString($imageTitle)){
        $message=array('type'=>'error_imageTitle','content'=>'Characters <>*/\'\" are not allowed');
    }else{
        $creationDate=time();

        try{
           insertUser($username,$password,$mail,$description,$creationDate);
           
           $id = intval(getUserId($username)['id']);

           createImageResource($id, 'users', $imageTitle);

           $_SESSION['username']=$username;

           $_SESSION['id'] = $id;

       }catch(PDOException $e){
            $message=array('type'=>'error_username','content'=>'Username already taken, please choose another one!');
       }
    }

    echo json_encode($message);
 
?>

