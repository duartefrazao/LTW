<?php 

    include_once('../includes/database.php');


    function getCommentsByPostId($id){
        $db = Database::instance()->db();
        $stmt = $db->prepare('
            SELECT comment.*, user.username,entry.* 
            FROM comment NATURAL JOIN entry JOIN user 
            on entry.author = user.id 
            WHERE post = ?');
        $stmt->execute(array($id));
        return $stmt->fetchAll();
    }

?>