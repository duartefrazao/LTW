<?php
    include_once("../includes/session.php");
    include_once("../database/db_subscribe.php");
    include_once('../actions/action_verify_input.php');

    $permission = true;
    $entities = array();

    if(!isset($_SESSION['username']) || $_SESSION['csrf'] != $_POST['csrf']){
        $permission = false;
    }else{
        $alreadySubscribed= test_input($_POST['alreadySubscribed']);
        $channel= test_input($_POST['channel']);
        $userId = $_SESSION['id'];

        subscribe($channel,$userId,$alreadySubscribed);

        $result = getSubscriptionUser($channel,$userId);
    }

    $response = array('result' => $permission, 'data' => $result);

    echo json_encode($response);
    
?>