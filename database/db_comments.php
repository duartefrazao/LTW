<?php 

    include_once('../includes/database.php');


    function getCommentsByPostId($id){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT ENTITY.*, user.username FROM ENTITY JOIN user on ENTITY.author = user.id WHERE ENTITY.parentEntity = ?');
        $stmt->execute(array($id));
        return $stmt->fetchAll();
    }

    function addComment($parent_id, $user_id, $content){
        $db = Database::instance()->db();
        $stmt = $db->prepare('INSERT INTO entity VALUES(NULL, ?, NULL, ?, 0, ?, 0, ?)');
        $stmt->execute(array($content, $user_id, time(), $parent_id));
        incNumberOfComments($parent_id);
    }


    function incNumberOfComments($parent_id){
        $db = Database::instance()->db();
        $stmt=$db->prepare('UPDATE ENTITY SET numComments = numComments + 1 WHERE id = ? ');
        $stmt->execute(array($parent_id)); 
     }

    function getCommentsAfterId($parent_id, $comment_id){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT ENTITY.*, user.username FROM ENTITY JOIN user on ENTITY.author = user.id WHERE ENTITY.parentEntity = ? AND ENTITY.id > ?');
        $stmt->execute(array($parent_id, $comment_id));
        return $stmt->fetchAll();
    }

?>