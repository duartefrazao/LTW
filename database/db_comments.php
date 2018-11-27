<?php 

    include_once('../includes/database.php');


    function getCommentsByPostId($id){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT ENTITY.*, user.username FROM ENTITY JOIN user on ENTITY.author = user.id WHERE ENTITY.parentEntity = ?');
        $stmt->execute(array($id));
        return $stmt->fetchAll();
    }

?>