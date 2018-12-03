<?php
    include_once('../includes/session.php');
    include_once('../database/db_post.php');

    $posts = getPosts($_SESSION['username'], $_POST['offset']);
    
    echo json_encode($posts);
?>