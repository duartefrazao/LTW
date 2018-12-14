<?php
    include_once('../includes/session.php');
    include_once('../database/db_comments.php');
    include_once('../actions/action_verify_input.php');

    $permission = true;
    $comments = array();
    
/*     if(!isset($_SESSION['username'])){
        $permission = false;
    }else{ */


        $parent_id = test_input($_POST['parent_id']);
        $last_id = test_input($_POST['last_id']);

        if(isset($_SESSION['id']))
            $comments = getUserCommentsByPostId($parent_id, $_SESSION['id'], $last_id);
        else
            $comments = getCommentsByPostId($parent_id, $last_id);

/*     } */

    $response = array('result' => $permission, 'data' => $comments);

    echo json_encode($response);
?>