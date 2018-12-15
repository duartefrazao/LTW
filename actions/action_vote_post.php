<?php
    include_once("../includes/session.php");
    include_once("../database/db_vote.php");
    include_once('../actions/action_verify_input.php');

    $permission = true;
    $entities = array();

    if(!isset($_SESSION['username']) || $_SESSION['csrf'] != $_POST['csrf']){
        $permission = false;
    }else{
        $type = test_input($_POST['voteType']);
        $entityID = test_input($_POST['entityID']);
        
        vote($entityID,$type,$_SESSION['id']);
        $entities = getVoteUser($entityID,$_SESSION['id']);
    }

    $response = array('result' => $permission, 'data' => $entities);

    echo json_encode($response);
    
?>