<?php
    include_once('../includes/database.php');

    function checkUserPassword($username,$password){
        $db = Database::instance()->db();
        $stmt = $db->prepare('Select * from user where username=? and password=?');
        $stmt->execute(array($username,sha1($password)));
        return $stmt->fetch()?true:false;
    }

    function insertUser($username,$password,$mail,$description,$creationDate){

        $db= Database::instance()->db();
        $stmt = $db->prepare('Insert into user values(?,?, ?, ?, ?, ?)');
        $stmt->execute(array(NULL,$username,sha1($password),$mail,$description,$creationDate));

    }

?>