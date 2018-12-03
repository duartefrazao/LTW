<?php
    include_once("../includes/session.php");
    include_once("../database/db_vote.php");

    if(!isset($_SESSION['id']))
        header("Location: ../pages/login.php");

    $type = $_POST['voteType'];
    $entityID = $_POST['entityID'];
    
    vote($entityID,$type,$_SESSION['id']);
    $info = getVoteUser($entityID,$_SESSION['id']);
    
    echo json_encode($info); 
?>