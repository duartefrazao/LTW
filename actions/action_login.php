<?php
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../database/db_user.php');
    include_once('../actions/action_verify_input.php');

    $permission = true;
    $message = array();

    $username= test_input($_POST['username']);
    $password= test_input($_POST['password']);

    $user=checkUserPassword($username);

    if( $user!== false && password_verify($password,$user['password'])){
        $_SESSION['username']= $username;
        $_SESSION['id'] = $user['id'];
        $message = array('type' => true, 'content' => 'Logged in successfully!');
    }else{
        $message = array('type' => false, 'content' => 'Invalid username and/or password!');

    }

    echo json_encode($message);
?>