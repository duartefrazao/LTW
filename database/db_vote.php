<?php 

    include_once('../includes/database.php');


    function vote($id,$username){
        $db=Database::instance()->db();
        $stmt=$db->prepare('UPDATE ENTITY SET votes=votes + ? WHERE ?=id');
        $stmt->execute(array($type,$id));
    }

    function voted($entityid,$username){
        $db=Database::instance()->db();
        $stmt=$db->prepare('SELECT VOTE.up FROM ENTITY, USER, VOTE WHERE USER.username=? AND VOTE.user=USER.id AND VOTE.entity=?');
        $stmt->execute(array($username,$entityid));
        $answer = $stmt->fetch();
        return $answer['up'];
    }
    

?>