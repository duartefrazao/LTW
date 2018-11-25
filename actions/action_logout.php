<?php
    include_once("../includes/session.php");
    
    session_destroy();

    header('Location: ../pages/posts.php');
?>