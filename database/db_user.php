<?php
    include_once('../includes/database.php');

    function checkUserPassword($username){
        $db = Database::instance()->db();
        $stmt = $db->prepare('Select * from user where username=?');
        $stmt->execute(array($username));
        return $stmt->fetch();
    }

    function insertUser($username,$password,$mail,$description,$creationDate){
        $options=['cost'=>12,];
        $db= Database::instance()->db();
        $stmt = $db->prepare('Insert into user values(?,?, ?, ?, ?, ?)');
        $pass = password_hash($password,PASSWORD_DEFAULT,$options);
        $stmt->execute(array(NULL,$username,$pass,$mail,$description,$creationDate));
    }
?>