<?php 

    include_once('../includes/database.php');

    function getPosts(){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT ENTITY.* , USER.username FROM ENTITY JOIN USER ON ENTITY.author = USER.id AND ENTITY.parentEntity is NULL');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getPostById($id){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT ENTITY.* , USER.username FROM ENTITY JOIN USER ON ENTITY.author = USER.id where ENTITY.id = ? AND ENTITY.parentEntity is NULL');
        $stmt->execute(array($id));
        return $stmt->fetch();
    }

    function vote($id,$type){
        $db=Database::instance()->db();
        $stmt=$db->prepare('UPDATE ENTITY SET votes=votes + ? WHERE ?=id');
        $stmt->execute(array($type,$id));
    }
    

?>