<?php 

    include_once('../includes/database.php');


    function getUserCommentsByPostId($id,$user_id, $offset){
        $db = Database::instance()->db();
        $stmt = $db->prepare(
            'SELECT A1.*, A2.up as up FROM 
                (SELECT ENTITY.* , USER.username 
                    FROM ENTITY JOIN USER
                    ON ENTITY.author = USER.id where ENTITY.parentEntity = ?) as A1
            LEFT JOIN 
                (SELECT VOTE.* FROM
                VOTE JOIN USER 
                ON USER.id = ? 
                AND VOTE.user = USER.id) as A2
            ON A2.entity=A1.id
            WHERE A1.id < ? ORDER BY A1.id DESC LIMIT 2');
        $stmt->execute(array($id,$user_id, $offset));
        return $stmt->fetchAll();
    }

    function getCommentsByPostId($id, $offset){
        $db = Database::instance()->db();
        $stmt = $db->prepare(
            'SELECT ENTITY.* , USER.username 
            FROM ENTITY JOIN USER ON ENTITY.author = USER.id
            WHERE ENTITY.parentEntity = ? AND
            Entity.id < ? ORDER BY Entity.id DESC LIMIT 2');
        $stmt->execute(array($id, $offset));
        return $stmt->fetchAll();
    }

    function getLastCommentId(){
        $db=Database::instance()->db();
        return $db->lastInsertId();
    }

    function addComment($parent_id, $user_id, $content){

        $db = Database::instance()->db();

        $stmt = $db->prepare('SELECT channel FROM ENTITY WHERE id=?');
        $stmt->execute(array($parent_id));
        $channel = $stmt->fetch()['channel'];

        $stmt = $db->prepare('INSERT INTO entity VALUES(NULL, ?, NULL, ?, 0, ?, 0,?, ?)');
        $stmt->execute(array($content, $user_id, time(),$channel, $parent_id));
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