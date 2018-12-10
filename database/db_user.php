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

    function getSimilarUsers($subs){
        $param = "%{$subs}%";
        $db= Database::instance()->db();
        $stmt = $db->prepare('
            Select id,username
            From USER 
            Where username LIKE ? LIMIT 3
        ');
        $stmt->execute(array($param));
        return $stmt->fetchAll();
    }

    function getUserId($username){
        $db= Database::instance()->db();
        $stmt = $db->prepare('
            Select USER.id 
            From USER 
            Where USER.username = ?
        ');
        $stmt->execute(array($username));
        return $stmt->fetch();
    }

    function getUserInfo($username){
        $db= Database::instance()->db();
        $stmt = $db->prepare('
            Select USER.mail,USER.description,USER.creationDate
            From USER 
            Where USER.username = ?
        ');
        $stmt->execute(array($username));
        return $stmt->fetch();
    }
?>