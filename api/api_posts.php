<?php

    include_once("../includes/session.php");
    include_once("../database/db_post.php");
    include_once("../database/db_user.php");


    $user = null;
    $criteria = 'mostrecent'; 

    if(isset($_SESSION['username']))
        $user = $_SESSION['username'];

    $method = $_SERVER['REQUEST_METHOD'];

    $response = array();

    switch($method){
        case ("PUT"):
            if(isset($_SESSION['username'])){
                $title= $_GET["title"];
                $content = $_GET["content"];
                $channel = $_GET["channel"];
                $author = $_SESSION['id'];
                if(addNewPost($title, $content,$author,$channel)==true)
                    $response['code'] = 200;
                else 
                    $response['code'] = 500;
            }
            break;
        case ('GET'):
           $posts = getPosts($user, PHP_INT_MAX,  $criteria);
           
           if($posts != null)
                $response['code'] = 200;
            else 
                $response['code'] = 404;

           $response['posts'] = $posts;
           break;
        default:
            $response['code'] = 404;
    }

    echo json_encode($response);

?>