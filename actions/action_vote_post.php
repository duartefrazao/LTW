<?php
    include_once("../includes/session.php");
    include_once("../database/db_vote.php");

    $permission = true;
    $entities = array();

    if(!isset($_SESSION['username'])){
        $permission = false;
    }else{
        $type = $_POST['voteType'];
        $entityID = $_POST['entityID'];
        
        vote($entityID,$type,$_SESSION['id']);
        $entities = getVoteUser($entityID,$_SESSION['id']);
    }

    $response = array('result' => $permission, 'data' => $entities);

    echo json_encode($response);
    
?>