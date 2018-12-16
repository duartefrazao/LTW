<?php
include_once('../includes/session.php');
include_once('../database/db_comments.php');
include_once('../actions/action_verify_input.php');

$permission = true;
$comments = array();

if (!isset($_SESSION['username']) ||  $_SESSION['csrf'] != $_POST['csrf']) {
    $permission = false;
} else {

    $content = test_input($_POST['text']);
    $parent_id = test_input($_POST['parent_id']);
    $last_id = test_input($_POST['comment_id']);
    $post_id = test_input($_POST['post_id']);
    
    addComment($parent_id, $_SESSION['id'], $content);
    
    //user did not open the replies so we don't know which was the
    //last (most recent) reply to that comment
    if($last_id === "-1"){
        $last_id = intval(getLastCommentId()) + 1;

        $comments = getUserCommentsByPostId($parent_id, $_SESSION['id'], $last_id);
        $comments = array_reverse($comments);
    }else{
    
        $comments = getCommentsAfterId($parent_id, $last_id);
    }

    if($post_id !== $parent_id)
        incNumberOfComments($post_id);
    
}

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