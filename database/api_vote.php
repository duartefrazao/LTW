<?php
    include_once("../includes/session.php");
    include_once("db_vote.php");

    $type = $_POST['voteType'];
    $entityID = $_POST['entityID'];

    vote($entityID,$type);
?>