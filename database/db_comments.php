<?php 

    include_once('../includes/database.php');


    function getCommentsByPostId($id,$user_id){
        $db = Database::instance()->db();
        $stmt = $db->prepare(
            'SELECT A1.*, A2.up FROM 
                (SELECT ENTITY.* , USER.username 
                    FROM ENTITY JOIN USER
                    ON ENTITY.author = USER.id where ENTITY.parentEntity = ?) as A1
            LEFT JOIN 
                (SELECT VOTE.* FROM
                VOTE JOIN USER 
                ON USER.id = ? 
                AND VOTE.user = USER.id) as A2
            ON A2.entity=A1.id');
        $stmt->execute(array($id,$user_id));
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