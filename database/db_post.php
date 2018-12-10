<?php 

    include_once('../includes/database.php');

    function getPosts($username, $offset){
        if($username !==NULL)
            return getPostsLogged($username, $offset,5);
        else 
            return getPostsGuest($offset, 5);

    }


    function getLastPostId(){
        $db=Database::instance()->db();
        return $db->lastInsertId();
    }


    function getCreationDate($id){
        $db=Database::instance()->db();
        $stmt = $db->prepare('SELECT creationDate FROM ENTITY WHERE ENTITY.id = ?');
        $stmt->execute(array($id));
        return $stmt->fetch();
    }

    function getSimilarPosts($user,$subs){
        $param = "%{$subs}%";
        $db = Database::instance()->db();
        $stmt = $db->prepare(
        'SELECT A1.*, A2.up FROM 
           (SELECT ENTITY.* , USER.username
            FROM ENTITY JOIN USER  
                ON ENTITY.author = USER.id 
                AND ENTITY.parentEntity is NULL
                WHERE ENTITY.title LIKE ?) as A1
        LEFT JOIN 
            (SELECT VOTE.* FROM VOTE JOIN USER 
                ON USER.username = ?
                AND VOTE.user = USER.id) as A2
        ON A2.entity = A1.id
        ORDER BY  A1.id DESC LIMIT 3');
        $stmt->execute(array($param,$user));
        return $stmt->fetchAll();
    }

    function addNewPost($title, $content, $author,$channel){
        $db = Database::instance()->db();
        $stmt = $db->prepare('INSERT INTO ENTITY VALUES (NULL, ?, ?, ?, 0, ?, 0,?, NULL)');
        $stmt->execute(array($title, $content, $author, time(),$channel));
    }

    function getPostsGuest($offset, $numOfElements){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT ENTITY.* , USER.username 
                            FROM ENTITY JOIN USER ON ENTITY.author = USER.id 
                            AND ENTITY.parentEntity is NULL 
                            WHERE ENTITY.id < ? ORDER BY ENTITY.id DESC LIMIT ?');
        $stmt->execute(array($offset, $numOfElements));
        return $stmt->fetchAll();
    }
    
    function getPostsLogged($username, $offset, $numOfElements){
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
        ON A2.entity = A1.id
        WHERE A1.id < ? ORDER BY  A1.id DESC LIMIT ?');

        $stmt->execute(array($username,$offset, $numOfElements));
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

    function getPostByUser($username){
        $db = Database::instance()->db();
        $stmt = $db->prepare(
            'SELECT Distinct A1.*, A2.up FROM 
                (SELECT ENTITY.* , USER.username 
                FROM ENTITY JOIN USER
                ON ENTITY.author = USER.id where USER.username = ? AND ENTITY.parentEntity is NULL) as A1
            LEFT JOIN 
                (SELECT VOTE.* FROM
                VOTE JOIN USER 
                ON VOTE.user = USER.id) as A2
            ON A2.entity=A1.id');
        $stmt->execute(array($username));
        return $stmt->fetchAll();
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