<?php 

    include_once('../includes/database.php');

    function getPostsFromChannel($username, $offset,$channel){
        if($username !==NULL)
            return getPostsFromChannelLogged($username, $offset,5,$channel);
        else 
            return getPostsFromChannelGuest($offset, 5,$channel);

    }
    function getChannel($channelId){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT *  
                            FROM CHANNEL WHERE CHANNEL.title = ?');
        $stmt->execute(array($channelId));
        return $stmt->fetch();
    }

    function getChannelSuggestionsBySubstring($subs){
        $param = "%{$subs}%";
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT title FROM CHANNEL WHERE title LIKE ? LIMIT 5');
        $stmt->execute(array($param));
        $res =  $stmt->fetchAll();

        if($res < 5){
            $stmt = $db->prepare('SELECT title FROM CHANNEL');
            $stmt->execute();
            $res = $stmt->fetchAll();
            $final = array();

            foreach($res as $r){
                if(levenshtein($r,$subs)>2)
                    array_push($final,$r);
            }
            $res = $final;
        }

        return $res;
    }
    function getPostsFromChannelGuest($offset, $numOfElements,$channel){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT ENTITY.* , USER.username 
                            FROM ENTITY JOIN USER JOIN CHANNEL ON ENTITY.author = USER.id 
                            AND ENTITY.channel=CHANNEL.id
                            AND ENTITY.parentEntity is NULL 
                            WHERE ENTITY.id < ? AND CHANNEL.title=? ORDER BY ENTITY.id DESC LIMIT ?');
        $stmt->execute(array($offset,$channel, $numOfElements));
        return $stmt->fetchAll();
    }
    
    function getPostsFromChannelLogged($username, $offset, $numOfElements,$channel){
        $db = Database::instance()->db();
        $stmt = $db->prepare(
        'SELECT A1.*, A2.up FROM 
           (SELECT ENTITY.* , USER.username
            FROM ENTITY JOIN USER JOIN CHANNEL 
                ON ENTITY.author = USER.id AND ENTITY.channel=CHANNEL.id
                AND ENTITY.parentEntity is NULL
                WHERE CHANNEL.title=?) as A1
        LEFT JOIN 
            (SELECT VOTE.* FROM VOTE JOIN USER 
                ON USER.username = ?
                AND VOTE.user = USER.id) as A2
        ON A2.entity = A1.id
        WHERE A1.id < ? ORDER BY  A1.id DESC LIMIT ?');

        $stmt->execute(array($channel,$username,$offset, $numOfElements));
        return $stmt->fetchAll();
    }

?>