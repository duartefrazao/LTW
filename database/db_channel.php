<?php

include_once '../includes/database.php';

function insertNewChannel($title, $description)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare('INSERT INTO CHANNEL VALUES(NULL, ?, ?)');
    $stmt->execute(array($title, $description));
}

function getLastChannelId()
{
    $db = Database::instance()->db();
    return $db->lastInsertId();
}

function getPostsFromChannel($username, $offset, $channel)
{
    if ($username !== null) {
        return getPostsFromChannelLogged($username, $offset, 5, $channel);
    } else {
        return getPostsFromChannelGuest($offset, 5, $channel);
    }

}
function getChannel($channelId)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT *
                            FROM CHANNEL WHERE CHANNEL.id = ?');
    $stmt->execute(array($channelId));
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

function getPostsFromChannelGuest($offset, $numOfElements, $channel)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT ENTITY.* , USER.username
                            FROM ENTITY JOIN USER JOIN CHANNEL ON ENTITY.author = USER.id
                            AND ENTITY.channel=CHANNEL.id
                            AND ENTITY.parentEntity is NULL
                            WHERE ENTITY.id < ? AND CHANNEL.id=? ORDER BY ENTITY.id DESC LIMIT ?');
    $stmt->execute(array($offset, $channel, $numOfElements));
    return $stmt->fetchAll();
}

function getPostsFromChannelLogged($username, $offset, $numOfElements, $channel)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare(
        'SELECT A1.*, A2.up as up FROM
           (SELECT ENTITY.* , USER.username
            FROM ENTITY JOIN USER JOIN CHANNEL
                ON ENTITY.author = USER.id AND ENTITY.channel=CHANNEL.id
                AND ENTITY.parentEntity is NULL
                WHERE CHANNEL.id=?) as A1
        LEFT JOIN
            (SELECT VOTE.* FROM VOTE JOIN USER
                ON USER.username = ?
                AND VOTE.user = USER.id) as A2
        ON A2.entity = A1.id
        WHERE A1.id < ? ORDER BY  A1.id DESC LIMIT ?');

    $stmt->execute(array($channel, $username, $offset, $numOfElements));
    return $stmt->fetchAll();
}
