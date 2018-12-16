<?php 

    include_once('../includes/database.php');

    function insertNewImage($id, $title, $path){
        $db=Database::instance()->db();
        if($path === 'users' || $path === 'posts')
            $stmt = $db->prepare("INSERT INTO images VALUES(?, ?)");
        else if($path === 'channels')
            $stmt = $db->prepare("INSERT INTO channelImages VALUES(?, ?)");

        $stmt->execute(array($id, $title));
    }

    function updateImage($id, $title, $path){
        $db=Database::instance()->db();
        $check = $db->prepare("SELECT id FROM images WHERE id = ?");
        $check->execute(array($id));
        $image = $check->fetchAll();
        if(count($image) == 0){
            if($path === 'users' || $path === 'posts')
                $stmt = $db->prepare("INSERT INTO images VALUES(?, ?)");
            else if($path === 'channels')
                $stmt = $db->prepare("INSERT INTO channelImages VALUES(?, ?)");

        }
        else
        {
            if($path === 'users' || $path === 'posts')
                $stmt = $db->prepare("UPDATE images SET title = ? WHERE id= ?");
            else if($path === 'channels')
                $stmt = $db->prepare("UPDATE images SET title = ? WHERE id= ?");
        }

        $stmt->execute(array($id, $title));
    }
    
    function getImage($id){
        $db=Database::instance()->db();
        $stmt = $db->prepare("SELECT * FROM images WHERE id=?");
        $stmt->execute(array($id));
        $image = $stmt->fetch();
    }

    function getAllImages(){
        $db=Database::instance()->db();
        $stmt = $db->prepare("SELECT * FROM images");
        $stmt->execute(array());
        $image = $stmt->fetchAll();
    }
?>