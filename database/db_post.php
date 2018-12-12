<?php 

    include_once('../includes/database.php');

    function getPosts($username, $offset, $criteria){

        if($username !==NULL)
            return getPostsLogged($username, $offset,6, $criteria);
        else 
            return getPostsGuest( $offset, 6, $criteria);

    }

    function getPostsOfUser($username , $user, $offset, $criteria){

        if($user !==NULL)
            return getPostsLoggedOfUser($username , $user, $offset,6, $criteria);
        else 
            return getPostsGuestOfUSer($username, $offset, 6, $criteria);

    }

    function getPostsLogged($username,$offset, $numOfElements, $criteria){

        $terms = explode('-', $criteria);

        $order = $terms[0];

        $timeOffset = 'all';

        if(isset($terms[1]))
            $timeOffset = getTimeOffset($terms[1]);

        switch($order){
            case 'mostrecent':
                return getPostsLogged_id($username, $offset, $numOfElements);
            case 'mostvoted':
                return getPostsLogged_votes($username, $offset, $numOfElements, $timeOffset);
            case 'mostcommented':
                return getPostsLogged_comments($username, $offset, $numOfElements, $timeOffset);
            default:
                return getPostsLogged_id($username, $offset, $numOfElements);
        }

    }

    function getPostsLoggedOfUser($username,$user,$offset, $numOfElements, $criteria){

        $terms = explode('-', $criteria);

        $order = $terms[0];

        $timeOffset = 'all';

        if(isset($terms[1]))
            $timeOffset = getTimeOffset($terms[1]);

        switch($order){
            case 'mostrecent':
                return getPostByUser_id($username,$user, $offset, $numOfElements);
            case 'mostvoted':
                return getPostByUser_votes($username,$user, $offset, $numOfElements, $timeOffset);
            case 'mostcommented':
                return getPostByUser_comments($username,$user, $offset, $numOfElements, $timeOffset);
            default:
                return getPostByUser_id($username,$user, $offset, $numOfElements);
        }

    }

    function getPostsGuest( $offset, $numOfElements, $criteria){

        $terms = explode('-', $criteria);

        $order = $terms[0];

        $timeOffset = 'all';

        if(isset($terms[1]))
            $timeOffset = getTimeOffset($terms[1]);

        switch($order){
            case 'mostrecent':
                return getPostsGuest_id($offset, $numOfElements);
            case 'mostvoted':
                return getPostsGuest_votes( $offset, $numOfElements, $timeOffset);
            case 'mostcommented':
                return getPostsGuest_comments($offset, $numOfElements, $timeOffset);
            default:
                return getPostsGuest_id($offset, $numOfElements);
        }
    }

    function getPostsGuestOfUSer($username, $offset, $numOfElements, $criteria){

        $terms = explode('-', $criteria);

        $order = $terms[0];

        $timeOffset = 'all';

        if(isset($terms[1]))
            $timeOffset = getTimeOffset($terms[1]);

        switch($order){
            case 'mostrecent':
                return getPostByUserGuest_id($username, $offset, $numOfElements);
            case 'mostvoted':
                return getPostByUserGuest_votes($username, $offset, $numOfElements, $timeOffset);
            case 'mostcommented':
                return getPostByUserGuest_comments($username, $offset, $numOfElements, $timeOffset);
            default:
                return getPostByUserGuest_id($username, $offset, $numOfElements);
        }
    }


    function getTimeOffset($time){
        switch ($time) {
            case 'day':
                return 86400;
            case 'month':
                return 2628000;
            case 'week':
                return 604800;
            case 'year':
                return 31556952; 
            default:
                return 86400;
        }
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
        return $stmt->execute(array($title, $content, $author, time(),$channel));
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
    

    //============== ID ORDERING =====================
    function getPostsGuest_id($offset, $numOfElements){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT ENTITY.* , USER.username 
                            FROM ENTITY JOIN USER ON ENTITY.author = USER.id 
                            AND ENTITY.parentEntity is NULL 
                            WHERE ENTITY.id < ? ORDER BY ENTITY.id DESC LIMIT ?');
        $stmt->execute(array($offset, $numOfElements));
        return $stmt->fetchAll();
    }

    function getPostByUserGuest_id($username,$offset, $numOfElements){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT ENTITY.* , USER.username 
                            FROM ENTITY JOIN USER ON ENTITY.author = USER.id 
                            AND ENTITY.parentEntity is NULL 
                            WHERE USER.username = ? AND ENTITY.id < ? ORDER BY ENTITY.id DESC LIMIT ?');
        $stmt->execute(array($username,$offset, $numOfElements));
        return $stmt->fetchAll();
    }
    
    function getPostsLogged_id($username, $offset, $numOfElements){
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

    function getPostByUser_id($username,$user, $offset, $numOfElements){
        $db = Database::instance()->db();
        $stmt = $db->prepare(
            'SELECT Distinct A1.*, A2.up FROM 
                (SELECT ENTITY.* , USER.username 
                FROM ENTITY JOIN USER
                ON ENTITY.author = USER.id where USER.username = ? AND ENTITY.parentEntity is NULL) as A1
            LEFT JOIN 
                (SELECT VOTE.* FROM
                VOTE JOIN USER 
                ON VOTE.user = USER.id AND USER.username = ?) as A2
            ON A2.entity=A1.id
            WHERE A1.id < ? ORDER BY  A1.id DESC LIMIT ?');
        $stmt->execute(array($username,$user,$offset, $numOfElements));
        return $stmt->fetchAll();
    }
    //============== VOTE ORDERING ===================

    function getPostsGuest_votes( $offset, $numOfElements, $timeOffset){

        $db = Database::instance()->db();
        $stmt = $db->prepare(
            'SELECT ENTITY.* , USER.username
            FROM ENTITY JOIN USER ON ENTITY.author = USER.id 
            WHERE ENTITY.parentEntity is NULL 
            AND (? - ? < ENTITY.creationDate) AND
            ENTITY.votes <= ? ORDER BY ENTITY.votes DESC LIMIT ?');
        $stmt->execute(array(time(), $timeOffset,$offset, $numOfElements));

        return $stmt->fetchAll();
    }

    function getPostByUserGuest_votes($username,$offset, $numOfElements, $timeOffset){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT ENTITY.* , USER.username 
                            FROM ENTITY JOIN USER ON ENTITY.author = USER.id 
                            AND ENTITY.parentEntity is NULL 
                            WHERE USER.username = ? AND (? - ? < ENTITY.creationDate) AND ENTITY.id < ? 
                            ORDER BY ENTITY.votes ASC LIMIT ?');
        $stmt->execute(array($username,time(), $timeOffset,$offset, $numOfElements));
        return $stmt->fetchAll();
    }
    
    function getPostsLogged_votes($username,  $offset, $numOfElements, $timeOffset){
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
        WHERE ? - ? < A1.creationDate  AND
        A1.votes <= ? ORDER BY  A1.votes DESC LIMIT ?');

        $stmt->execute(array($username, time(), $timeOffset,  $offset, $numOfElements));
        return $stmt->fetchAll();
    }

    function getPostByUser_votes($username,$user, $offset, $numOfElements, $timeOffset){
        $db = Database::instance()->db();
        $stmt = $db->prepare(
            'SELECT Distinct A1.*, A2.up FROM 
                (SELECT ENTITY.* , USER.username 
                FROM ENTITY JOIN USER
                ON ENTITY.author = USER.id where USER.username = ? AND ENTITY.parentEntity is NULL) as A1
            LEFT JOIN 
                (SELECT VOTE.* FROM
                VOTE JOIN USER 
                ON VOTE.user = USER.id AND USER.username = ?) as A2
            ON A2.entity=A1.id
            WHERE ? - ? < A1.creationDate AND A1.votes <= ? ORDER BY  A1.votes DESC LIMIT ?');
        $stmt->execute(array($username,$user, time(), $timeOffset,  $offset, $numOfElements));
        return $stmt->fetchAll();
    }

    //============== Comment ORDERING ===================

    function getPostsGuest_comments($offset, $numOfElements, $timeOffset){

        $db = Database::instance()->db();
        $stmt = $db->prepare(
            'SELECT ENTITY.* , USER.username
            FROM ENTITY JOIN USER ON ENTITY.author = USER.id 
            WHERE ENTITY.parentEntity is NULL 
            AND (? - ? < ENTITY.creationDate) AND
            ENTITY.numComments <= ? ORDER BY ENTITY.numComments DESC LIMIT ?');
        $stmt->execute(array(time(), $timeOffset, $offset, $numOfElements));

        return $stmt->fetchAll();
    }
    
    function getPostByUserGuest_comments($username,$offset, $numOfElements){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT ENTITY.* , USER.username 
                            FROM ENTITY JOIN USER ON ENTITY.author = USER.id 
                            AND ENTITY.parentEntity is NULL 
                            WHERE USER.username = ? AND (? - ? < ENTITY.creationDate) AND ENTITY.id < ? 
                            ORDER BY ENTITY.numComments DESC LIMIT ?');
        $stmt->execute(array($username,time(), $timeOffset,$offset, $numOfElements));
        return $stmt->fetchAll();
    }
    
    function getPostsLogged_comments($username,$offset, $numOfElements, $timeOffset){
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
        WHERE ? - ? < A1.creationDate AND
        A1.numComments <= ? ORDER BY  A1.numComments DESC LIMIT ?');

        $stmt->execute(array($username, time(), $timeOffset, $offset, $numOfElements));
        return $stmt->fetchAll();
    }

    function getPostByUser_comments($username,$user,$offset, $numOfElements, $timeOffset){
        $db = Database::instance()->db();
        $stmt = $db->prepare(
            'SELECT Distinct A1.*, A2.up FROM 
                (SELECT ENTITY.* , USER.username 
                FROM ENTITY JOIN USER
                ON ENTITY.author = USER.id where USER.username = ? AND ENTITY.parentEntity is NULL) as A1
            LEFT JOIN 
                (SELECT VOTE.* 
                FROM VOTE JOIN USER 
                ON USER.username = ? AND VOTE.user = USER.id) as A2
            ON A2.entity=A1.id
            WHERE ? - ? < A1.creationDate AND  A1.numComments <= ? ORDER BY  A1.numComments DESC LIMIT ?');
        $stmt->execute(array($username,$user, time(), $timeOffset,  $offset, $numOfElements));
        return $stmt->fetchAll();
    }

?>