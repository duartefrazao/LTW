<?php

include_once '../includes/database.php';

function vote($id, $type, $userId)
{

    $db = Database::instance()->db();
    $stmt = $db->prepare(
        'SELECT up from VOTE WHERE entity=? AND user=?');
    $stmt->execute(array($id, $userId));

    $oldType = $stmt->fetch();
    if ($oldType != null) {
        $stmt = $db->prepare(
            'DELETE FROM VOTE WHERE entity=? AND user=?');
        $stmt->execute(array($id, $userId));
    } else {
        $stmt = $db->prepare('INSERT INTO VOTE VALUES(?,?,?)');
        $stmt->execute(array($id, $userId, $type));
    }

/*         $stmt=$db->prepare('SELECT changes() as c FROM VOTE');
$stmt->execute(array());
$res = $stmt->fetch()['c']; */

}

function removeVote($id, $userId)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare(
        'DELETE FROM VOTE WHERE entity=? AND user=?');
    $stmt->execute(array($id, $userId));
}

function voted($entityid, $username)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare('SELECT VOTE.up FROM ENTITY, USER, VOTE WHERE USER.username=? AND VOTE.user=USER.id AND VOTE.entity=?');
    $stmt->execute(array($username, $entityid));
    $answer = $stmt->fetch();
    return $answer['up'];
}

function getAllVotes()
{
    $db = Database::instance()->db();
    $stmt = $db->prepare(
        'SELECT * FROM VOTE');
    $stmt->execute();
    return $stmt->fetchAll();
}

function getVoteUser($entityid, $userid)
{
    $db = Database::instance()->db();
    $stmt = $db->prepare(
        'SELECT ENTITY.*,VOTE.* 
        FROM ENTITY LEFT JOIN VOTE  
        ON ENTITY.id=VOTE.entity WHERE user = ? AND id=?');
        
    $stmt->execute(array($userid, $entityid));
    $res = $stmt->fetch();
    

    if(!empty($res)) 
        return $res;
    else{
        $stmt = $db->prepare('SELECT * FROM ENTITY WHERE id=?');
            
        $stmt->execute(array($entityid));
        return $stmt->fetch();
    }
        
}

function getVotes()
{
    $db = Database::instance()->db();
    $stmt = $db->prepare(
        'SELECT * FROM VOTE');
    $stmt->execute();
    return $stmt->fetchAll();
}
