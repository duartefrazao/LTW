<?php 

    include_once('../includes/database.php');

    function getPosts($username){
        if($username !==NULL)
            return getPostsLogged($username);
        else 
            return getPostsGuest();

    }
    function getPostsGuest(){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT ENTITY.* , USER.username FROM ENTITY JOIN USER ON ENTITY.author = USER.id AND ENTITY.parentEntity is NULL');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getPostsLogged($username){
        $db = Database::instance()->db();
        $stmt = $db->prepare(
        'SELECT A1.*, A2.up FROM 
           (SELECT ENTITY.* , USER.username
            FROM ENTITY JOIN USER  
                ON ENTITY.author = USER.id 
                AND ENTITY.parentEntity is NULL) as A1
        LEFT JOIN 
            (SELECT VOTE.* FROM VOTE JOIN USER 
                ON USER.username = ?
                AND VOTE.user = USER.id) as A2
        ON A2.entity = A1.id');

        $stmt->execute(array($username));
        return $stmt->fetchAll();
    }

    function getPostById($id){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT ENTITY.* , USER.username FROM ENTITY JOIN USER ON ENTITY.author = USER.id where ENTITY.id = ? AND ENTITY.parentEntity is NULL');
        $stmt->execute(array($id));
        return $stmt->fetch();
    }

    

?>