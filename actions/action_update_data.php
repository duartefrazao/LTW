<?php
    include_once('../includes/session.php');
    include_once('../database/db_user.php');
    include_once('../actions/action_verify_input.php');
    include_once('../actions/action_add_image.php');

    if(isset($_SESSION['username']))
    {
        $logoff = false;
        $info = getUserInfo($_SESSION['username']);

        $id = test_input($_POST['id']);
        
        $username = test_input($_POST['username']);
        if($info['username'] != $username)
        {
            updateUsername($id,$username);
            $logoff = true;
        }
        $description = test_input($_POST['description']);
        if($info['description'] != $description)
        {
            updateDescription($id,$description);
        }
        $mail = test_input($_POST['mail']);
        if($info['mail'] != $mail)
        {
            updateMail($id,$mail);
        }
        $pass = test_input($_POST['pass']);
        if($pass != '')
        {
            updatePassword($id,$pass);
        }
        updateImageResource($id,'users',$description);
        if($logoff == true)
            session_destroy();
    }

    header('Location: ../pages/posts.php');
?>