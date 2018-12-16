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

    
    $extensionsUser = array();
    foreach($comments as $comment)
    {
        $ext=array_map("pathinfo",glob('../images/users/originals/' . $comment['author'] . '.*'));
        if(count($ext) == 0 )
        {
            $ext = null;
        }
        array_push($extensionsUser,$ext[0]['extension']);
    }

    $response = array('result' => $permission, 'data' => $comments, 'extensions' => $extensionsUser);

    echo json_encode($response);
?>