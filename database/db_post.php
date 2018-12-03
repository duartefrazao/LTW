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

    function getPostById($id,$username){
        $db = Database::instance()->db();
        $stmt = $db->prepare(
            'SELECT A1.*, A2.up FROM 
                (SELECT ENTITY.* , USER.username 
                FROM ENTITY JOIN USER
                ON ENTITY.author = USER.id where ENTITY.id = ? AND ENTITY.parentEntity is NULL) as A1
            LEFT JOIN 
                (SELECT VOTE.* FROM
                 VOTE JOIN USER 
                 ON USER.username = ? 
                 AND VOTE.user = USER.id) as A2
            ON A2.entity=A1.id');
        $stmt->execute(array($id,$username));
        return $stmt->fetch();
    }

    function getNumVotes($id){
        $db=Database::instace()->db();
        $stmt = $d->prepare('SELECT votes FROM ENTITY WHERE ENTITY.id = ?');
        $stmt->execute(array($id));
        return $stmt->fetch();
    }

    function getVoteUserInfo($id,$userId){
        $db=Database::instace()->db();
        $stmt = $d->prepare(
            'SELECT * from
                (SELECT * FROM ENTITY JOIN USER ON ENTITY.id = ?) as A1
            LEFT JOIN 
                (SELECT * FROM VOTE WHERE user=?) as A2
            ON A2.entity=A1.ENTITY.id 
            AND A2.user = A1.USER.id');
        $stmt->execute(array($id,$userId));
        return $stmt->fetch();
    }
    

?>