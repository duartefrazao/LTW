<?php
    include_once('../includes/session.php');
    include_once('../database/db_post.php');

    $offset = getCreationDate($_POST['lastId']);

    $posts = getPosts($_SESSION['username'], array_values($offset)[0]);
    
    echo json_encode($posts);
?>