<?php
     include_once('../includes/session.php');
     include_once('../database/db_post.php');
     include_once('../actions/action_verify_input.php');

    $search = test_input($_POST['search']);

    $user = isset($_SESSION['username']) ? $_SESSION['username'] : null;

    $posts = getSimilarPosts($user,$search);

    //IMAGES EXTENSIONS

    if(isset($_SESSION['id']))
        $id=$_SESSION['id'];
    else 
        $id = null;
    $extensions = array();
    $extensionsUser = array();
    foreach($posts as $post)
    {
        $ext=array_map("pathinfo",glob('../images/posts/originals/' . $post['id'] . '.*'));
        $ext2=array_map("pathinfo",glob('../images/users/originals/' . $post['author'] . '.*'));
        if(count($ext) == 0 )
        {
            $ext = null;
        }
        if(count($ext2) == 0 )
        {
            $ext2 = null;
        }
        array_push($extensions,$ext[0]['extension']);
        array_push($extensionsUser,$ext2[0]['extension']);
    }

    $response = array('result' => true, 'data' => $posts , 'id' => $id,'extension'=>$extensions,'extensionUser'=>$extensionsUser);

    echo json_encode($response);
?>