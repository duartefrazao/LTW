<?php
    include_once('../includes/session.php');
    include_once('../database/db_post.php');
    include_once('../actions/action_verify_input.php');

    $permission = true;
    $posts = array();

    $offset = test_input($_POST['offset']);

    $criteria = test_input($_POST['criteria']);

    $name = test_input($_POST['name']);

    

    if($name !="null")
    {
        if(isset($_SESSION['username'])){
            $posts = getPostsOfUser($name ,$_SESSION['username'], $offset, $criteria);
        }
        else{
            $posts = getPostsOfUser($name ,null,  $offset, $criteria);
        }
    }
    else
    {
        if(isset($_SESSION['username'])){
            $posts = getPosts($_SESSION['username'], $offset, $criteria);
        }
        else{
            $posts = getPosts(null,  $offset, $criteria);
        }
    }
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
    $response = array('result' => $permission, 'data' => $posts , 'id' => $id,'extension'=>$extensions,'extensionUser'=>$extensionsUser);

    echo json_encode($response);
?>