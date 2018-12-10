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
                            FROM CHANNEL WHERE CHANNEL.id = ?');
        $stmt->execute(array($channelId));
        return $stmt->fetch();
    }

    function getChannels(){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM CHANNEL');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getSimilarChannels($subs){
        $param = "%{$subs}%";
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT id, title FROM CHANNEL WHERE title LIKE ? LIMIT 3');
        $stmt->execute(array($param));
        $res =  $stmt->fetchAll();

        /* if(count($res) < 2){
            $stmt = $db->prepare('SELECT title,NULL as distance FROM CHANNEL');
            $stmt->execute();
            $res= $stmt->fetchAll();
            $final = array();

            foreach($res as $key=>$r){
                $res[$key]['distance'] = levenshtein($r['title'],$subs);
            }
            foreach ($res as $key => $row) {
                $title[$key]  = $row['title'];
                $distance[$key] = $row['distance'];
            }

            $title  = array_column($res, 'title');
            $distance = array_column($res, 'distance');  

            array_multisort($distance, SORT_ASC,$title,SORT_ASC, $res);
            
        } */

        return $res;
    }
    function getPostsFromChannelGuest($offset, $numOfElements,$channel){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT ENTITY.* , USER.username 
                            FROM ENTITY JOIN USER JOIN CHANNEL ON ENTITY.author = USER.id 
                            AND ENTITY.channel=CHANNEL.id
                            AND ENTITY.parentEntity is NULL 
                            WHERE ENTITY.id < ? AND CHANNEL.id=? ORDER BY ENTITY.id DESC LIMIT ?');
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
                WHERE CHANNEL.id=?) as A1
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