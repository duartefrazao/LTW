<?php 

    include_once('../includes/database.php');

    function insertNewImage($id, $title, $path){
        $db=Database::instance()->db();
        if($path === 'users')
            $stmt = $db->prepare("INSERT INTO images VALUES(?, ?)");
        else if($path === 'channels')
            $stmt = $db->prepare("INSERT INTO channelImages VALUES(?, ?)");
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