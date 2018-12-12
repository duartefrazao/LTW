<?php

    include_once("../includes/session.php");
    include_once("../database/db_post.php");
    include_once("../database/db_user.php");


    $user = null;
    $criteria = 'mostrecent'; 

    if(isset($_SESSION['username']))
        $user = $_SESSION['username'];

    $method = $_SERVER['REQUEST_METHOD'];

    $response=null;
    $code = 404;

    switch($method){
        case ("PUT"):
            if(isset($_SESSION['username'])){
                $title= $_GET["title"];
                $content = $_GET["content"];
                $channel = $_GET["channel"];
                $author = $_SESSION['id'];
                if(addNewPost($title, $content,$author,$channel)==true)
                    $code = 200;
            }
            break;
        case ('GET'):
           $posts = getPosts($user, PHP_INT_MAX,  $criteria);
           
           if($posts != null){
                $response = $posts;
                $code = 200;
           }

           break;
        default:
    }

    if($response !=null)
        echo json_encode($response);
        
    http_response_code($code);

?>