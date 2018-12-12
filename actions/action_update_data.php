<?php
    include_once('../includes/session.php');
    include_once('../database/db_user.php');

    if(isset($_SESSION['username']))
    {
        $logoff = false;
        $info = getUserInfo($_SESSION['username']);

        $id = $_POST['id'];
        
        $username = $_POST['username'];
        if($info['username'] != $username)
        {
            updateUsername($id,$username);
            $logoff = true;
        }
        $description = $_POST['description'];
        if($info['description'] != $description)
        {
            updateDescription($id,$description);
        }
        $mail = $_POST['mail'];
        if($info['mail'] != $mail)
        {
            updateMail($id,$mail);
        }
        $pass = $_POST['pass'];
        if($pass != '')
        {
            updatePassword($id,$pass);
        }
        if($logoff == true)
            session_destroy();
    }

    header('Location: ../pages/posts.php');
?>