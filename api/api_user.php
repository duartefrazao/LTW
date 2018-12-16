<?php

    include_once("../includes/session.php");
    include_once("../database/db_channel.php");



    if(isset($_SESSION['username']))
        $user = $_SESSION['username'];

    $method = $_SERVER['REQUEST_METHOD'];

    $response=null;
    $code = 404;

    switch($method){
        case ('GET'):
            if(isset($_GET['username']))
            {
                $user = getUserInfo($_GET['username']);
                if($user != null){
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