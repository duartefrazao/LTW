<?php

include_once '../includes/database.php';

    function subscribe($channel,$userId,$alreadySubscribed){
        $db = Database::instance()->db();
        $stmt = $db->prepare(
            'SELECT user from SUBSCRIPTION WHERE channel=? AND user=?');
        $stmt->execute(array($channel, $userId));
        
        $subscription = $stmt->fetch();

        if ($subscription != null) {
            $stmt = $db->prepare(
                'DELETE FROM SUBSCRIPTION WHERE channel=? AND user=?');
            $stmt->execute(array($channel, $userId));
        } else {
            $stmt = $db->prepare('INSERT INTO SUBSCRIPTION VALUES(?,?)');
            $stmt->execute(array($channel, $userId));
        }
    }

    function getSubscriptionUser($channel,$userId){
        $db = Database::instance()->db();
        $stmt = $db->prepare(
            'SELECT * FROM SUBSCRIPTION WHERE channel =? AND user=?');
        $stmt->execute(array($channel, $userId));
        return $stmt->fetch();
    }
?>