<?php 

    include_once('../includes/database.php');

    function getPosts(){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT POST.* , USER.username FROM POST JOIN USER ON POST.author = USER.id');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getPostById($id){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT POST.* , USER.username FROM POST JOIN USER ON POST.author = USER.id where POST.id = ?');
        $stmt->execute(array($id));
        return $stmt->fetch();
    }

    function vote($id,$type){
        $db=Database::instance()->db();
        $stmt=$db->prepare('UPDATE POST SET votes=votes + ? WHERE ?=id');
        $stmt->execute(array($type,$id));
    }
    

?>