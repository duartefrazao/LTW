<?php
    include_once('../includes/session.php');
    include_once('../database/db_user.php');

    
    if(!isset($_SESSION['username'])){
        header('Location: posts.php');
    }
    $username= $_SESSION['username'];
    $info = getUserInfo($username);
    $image_exists=false;

    if(file_exists('../images/users/thumb_medium/' . $info['id'] .'.jpg'))
    {
        $image_exists=true;
    }

    $response = array('info' => $info,'image'=>$image_exists);
    echo json_encode($response);


?>