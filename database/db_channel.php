<?php
include_once("../actions/utils.php");
include_once('../includes/database.php');

function insertNewChannel($title, $description)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare('INSERT INTO CHANNEL VALUES(NULL, ?, ?)');
    $stmt->execute(array($title, $description));

    return $db->lastInsertId();
}

function getLastChannelId()
{
    $db = Database::instance()->db();
    return $db->lastInsertId();
}


function getChannel($channelId)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT *
                            FROM CHANNEL WHERE CHANNEL.id = ?');
    $stmt->execute(array($channelId));
    return $stmt->fetch();
}

function getChannelByName($channel)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT *
                            FROM CHANNEL WHERE title = ?');
    $stmt->execute(array($channel));
    return $stmt->fetch();
}

function getChannelWithUserInfo($channelId,$user){
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM (SELECT * FROM CHANNEL WHERE CHANNEL.id = ? ) as C 
                          LEFT JOIN 
                         (SELECT * FROM SUBSCRIPTION WHERE SUBSCRIPTION.user=?) as S
                          ON C.id=S.channel');
    $stmt->execute(array($channelId,$user));
    return $stmt->fetch();
}

function getChannels()
{
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT * FROM CHANNEL');
    $stmt->execute();
    return $stmt->fetchAll();
}

function getSimilarChannelsAndUsers($subs)
{
    $param = "%{$subs}%";
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT title  FROM CHANNEL WHERE title LIKE ? LIMIT 4');
    $stmt->execute(array($param));
    $channels = $stmt->fetchAll();

    $stmt = $db->prepare('SELECT username  FROM USER WHERE username LIKE ? LIMIT 4');
    $stmt->execute(array($param));
    $users = $stmt->fetchAll();
    $res = ['channels'=>$channels,'users'=>$users];

    return $res;
}

function getSimilarChannels($subs){

    $param = "%{$subs}%";
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT *  FROM CHANNEL WHERE title LIKE ? LIMIT 4');
    $stmt->execute(array($param));
    $res =  $stmt->fetchAll();

    return $res;
}

function getPostsFromChannel($username, $offset, $criteria, $channel)
{
    if ($username !== null) {
        return getPostsFromChannelLogged($username, $offset, 5, $criteria, $channel);
    } else {
        return getPostsFromChannelGuest($offset, 5,  $criteria, $channel);
    }
}

function getPostsFromChannelLogged($username,$offset, $numOfElements, $criteria, $channel ){

    $terms = explode('-', $criteria);

    $order = $terms[0];

    $timeOffset = 'all';

    if(isset($terms[1]))
        $timeOffset = getTimeOffset($terms[1]);

    switch($order){
        case 'mostrecent':
            return getChannelPostsLogged_id($username, $offset, $numOfElements, $channel);
        case 'mostvoted':
            return getChannelPostsLogged_votes($username, $offset, $numOfElements, $timeOffset, $channel);
        case 'mostcommented':
            return getChannelPostsLogged_comments($username, $offset, $numOfElements, $timeOffset, $channel);
        default:
            return getChannelPostsLogged_id($username, $offset, $numOfElements,$channel);
    }

}


function getPostsFromChannelGuest( $offset, $numOfElements, $criteria, $channel){

    $terms = explode('-', $criteria);

    $order = $terms[0];

    $timeOffset = 'all';

    if(isset($terms[1]))
        $timeOffset = getTimeOffset($terms[1]);

    switch($order){
        case 'mostrecent':
            return getChannelPostsGuest_id($offset, $numOfElements, $channel);
        case 'mostvoted':
            return getChannelPostsGuest_votes( $offset, $numOfElements, $timeOffset, $channel);
        case 'mostcommented':
            return getChannelPostsGuest_comments($offset, $numOfElements, $timeOffset, $channel);
        default:
            return getChannelPostsGuest_id($offset, $numOfElements, $channel);
    }
}



    //============== ID ORDERING =====================
    function getChannelPostsGuest_id($offset, $numOfElements,  $channel){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT ENTITY.* , USER.username, CHANNEL.title as channelTitle
                            FROM ENTITY 
                            JOIN USER ON ENTITY.author = USER.id 
                            JOIN CHANNEL ON ENTITY.channel = CHANNEL.id
                            WHERE ENTITY.parentEntity is NULL 
                            AND ENTITY.id < ?  AND CHANNEL.id=? ORDER BY ENTITY.id DESC LIMIT ?');
        $stmt->execute(array($offset, $channel, $numOfElements));
        return $stmt->fetchAll();
    }
    
    function getChannelPostsLogged_id($username, $offset, $numOfElements, $channel){
        $db = Database::instance()->db();
        $stmt = $db->prepare(
        'SELECT A1.*, A2.up as up FROM 
           (SELECT ENTITY.* , USER.username, CHANNEL.title as channelTitle
            FROM ENTITY 
            JOIN USER ON ENTITY.author = USER.id
            JOIN CHANNEL on CHANNEL.id = ENTITY.channel
            WHERE ENTITY.parentEntity is NULL
            AND CHANNEL.id=?) as A1
        LEFT JOIN 
            (SELECT VOTE.* FROM VOTE JOIN USER 
                ON USER.username = ?
                AND VOTE.user = USER.id) as A2
        ON A2.entity = A1.id
        WHERE A1.id < ? ORDER BY  A1.id DESC LIMIT ?');

        $stmt->execute(array($channel, $username,$offset, $numOfElements));
        return $stmt->fetchAll();
    }
    //============== VOTE ORDERING ===================

    function getChannelPostsGuest_votes( $offset, $numOfElements, $timeOffset, $channel){

        $db = Database::instance()->db();
        $stmt = $db->prepare(
            'SELECT ENTITY.* , USER.username, CHANNEL.title as channelTitle
            FROM ENTITY 
            JOIN USER ON ENTITY.author = USER.id 
            JOIN CHANNEL ON ENTITY.channel = CHANNEL.id
            WHERE ENTITY.parentEntity is NULL 
            AND (? - ? < ENTITY.creationDate) AND
            ENTITY.votes <= ?  AND CHANNEL.id=? ORDER BY ENTITY.votes DESC LIMIT ?');
        $stmt->execute(array(time(), $timeOffset,$offset, $channel, $numOfElements));

        return $stmt->fetchAll();
    }
    
    function getChannelPostsLogged_votes($username,  $offset, $numOfElements, $timeOffset, $channel){
        $db = Database::instance()->db();

        $stmt = $db->prepare(
        'SELECT A1.*, A2.up as up FROM 
           (SELECT ENTITY.* , USER.username, CHANNEL.title as channelTitle
            FROM ENTITY 
            JOIN USER ON ENTITY.author = USER.id
            JOIN CHANNEL on CHANNEL.id = ENTITY.channel
            WHERE ENTITY.parentEntity is NULL
            AND CHANNEL.id=?) as A1
        LEFT JOIN 
            (SELECT VOTE.* FROM VOTE JOIN USER 
                ON USER.username = ?
                AND VOTE.user = USER.id) as A2
        ON A2.entity = A1.id
        WHERE ? - ? < A1.creationDate  AND
        A1.votes <= ? ORDER BY  A1.votes DESC LIMIT ?');

        $stmt->execute(array($channel, $username, time(), $timeOffset,  $offset, $numOfElements));
        return $stmt->fetchAll();
    }

    //============== Comment ORDERING ===================

    function getChannelPostsGuest_comments($offset, $numOfElements, $timeOffset,  $channel){

        $db = Database::instance()->db();
        $stmt = $db->prepare(
            'SELECT ENTITY.* , USER.username, CHANNEL.title as channelTitle
            FROM ENTITY 
            JOIN USER ON ENTITY.author = USER.id 
            JOIN CHANNEL ON ENTITY.channel = CHANNEL.id
            WHERE ENTITY.parentEntity is NULL 
            AND (? - ? < ENTITY.creationDate) AND
            ENTITY.numComments <= ? AND CHANNEL.id=? ORDER BY ENTITY.numComments DESC LIMIT ?');
        $stmt->execute(array(time(), $timeOffset, $offset, $channel,  $numOfElements));

        return $stmt->fetchAll();
    }
    
    function getChannelPostsLogged_comments($username,$offset, $numOfElements, $timeOffset, $channel){
        $db = Database::instance()->db();

        $stmt = $db->prepare(
        'SELECT A1.*, A2.up as up FROM 
           (SELECT ENTITY.* , USER.username, CHANNEL.title as channelTitle
            FROM ENTITY 
            JOIN USER ON ENTITY.author = USER.id
            JOIN CHANNEL on CHANNEL.id = ENTITY.channel
            WHERE ENTITY.parentEntity is NULL
            AND CHANNEL.id=?) as A1
        LEFT JOIN 
            (SELECT VOTE.* FROM VOTE JOIN USER 
                ON USER.username = ?
                AND VOTE.user = USER.id) as A2
        ON A2.entity = A1.id
        WHERE ? - ? < A1.creationDate AND
        A1.numComments <= ? ORDER BY  A1.numComments DESC LIMIT ?');

        $stmt->execute(array($channel, $username, time(), $timeOffset, $offset, $numOfElements));
        return $stmt->fetchAll();
    }
