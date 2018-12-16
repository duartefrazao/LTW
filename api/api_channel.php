<?php

    include_once("../includes/session.php");
    include_once("../database/db_channel.php");



    if(isset($_SESSION['username']))
        $user = $_SESSION['username'];

    $method = $_SERVER['REQUEST_METHOD'];

    $response=null;
    $code = 404;

    switch($method){
        case ("PUT"):
            if(isset($_SESSION['username'])){
                if(isset($_GET['title']) && isset($_GET['description'])){
                    $title= $_GET["title"];
                    $description= $_GET["description"];
                    if(insertNewChannel($title,$description) !=NULL)
                     $code = 200;
                }
            }
            break;
        case ('GET'):
            if(isset($_GET['title']))
            {
                $title = $_GET['title'];
                $channel = getChannelByName($title);
                
                if($channel != null){
                    $response = $channel;
                    $code = 200;
                }
            }

           break;
        default:
    }

    echo json_encode($response);
        
    http_response_code($code);

?>