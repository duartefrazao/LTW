<?php
    include_once('../includes/session.php');
    include_once('../database/db_user.php');

    
    if(!isset($_SESSION['username'])){
        header('Location: posts.php');
    }
    $username= $_SESSION['username'];
    $info = getUserInfo($username);
    $image_exists=false;

    $ext=array_map("pathinfo",glob('../images/users/thumb_medium/' . $info['id'] . '.*'));
    if(count($ext) != 0 && file_exists('../images/users/thumb_medium/' . $info['id'] .'.'.$ext[0]['extension']))
    {
        $image_exists=true;
    }
    if(count($ext) != 0)
        $response = array('info' => $info,'image'=>$image_exists ,'extension' =>$ext[0]['extension']);
    else
        $response = array('info' => $info,'image'=>$image_exists ,'extension' =>null);

    echo json_encode($response);


?>