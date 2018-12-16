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


    function getUser($id){
        $db= Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM USER WHERE id = ?');
        $stmt->execute(array($id));
        return $stmt->fetch();
    }

    function updateUser($id,$changes){

        if($changes['username'] != NULL)
            updateUsername($id,$changes['username']);

        if($changes['password'] != NULL)
            updatePassword($id,$changes['password']);

        if($changes['mail'] != NULL)
            updateMail($id,$changes['mail']);

        if($changes['description'] != NULL)
            updateDescription($id,$changes['description']);
        
    }
    
    function updateUsername($id,$username){
        $db= Database::instance()->db();
        $stmt = $db->prepare('UPDATE USER 
            SET username = ?
            WHERE id = ?');
        $stmt->execute(array($username,$id));
    }

    function updateMail($id,$mail){
        $db= Database::instance()->db();
        $stmt = $db->prepare('UPDATE USER 
            SET mail = ?
            WHERE id = ?');
        $stmt->execute(array($mail,$id));
    }

    function updateDescription($id,$description){
        $db= Database::instance()->db();
        $stmt = $db->prepare('UPDATE USER 
            SET description = ?
            WHERE id = ?');
        $stmt->execute(array($description,$id));
    }

    function updatePassword($id,$password){
        $options=['cost'=>12,];
        $password = password_hash($password,PASSWORD_DEFAULT,$options);

        $db= Database::instance()->db();
        $stmt = $db->prepare('UPDATE USER 
            SET password = ?
            WHERE id = ?');
        $stmt->execute(array($password,$id));
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
            Select USER.mail,USER.description,USER.creationDate,USER.id,USER.username
            From USER 
            Where USER.username = ?
        ');
        $stmt->execute(array($username));
        return $stmt->fetch();
    }

    function getUserInfoById($id){
        $db= Database::instance()->db();
        $stmt = $db->prepare('
            Select USER.mail,USER.description,USER.creationDate,USER.id,USER.username
            From USER 
            Where USER.id = ?
        ');
        $stmt->execute(array($id));
        return $stmt->fetch();
    }

?>