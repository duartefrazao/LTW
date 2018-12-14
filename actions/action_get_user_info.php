<?php
    include_once('../includes/session.php');
    include_once('../database/db_user.php');

    
    if(!isset($_SESSION['username'])){
        header('Location: posts.php');
    }
    $username= $_SESSION['username'];
    $info = getUserInfo($username);



    $response = array('info' => $info);
    echo json_encode($response);


?>