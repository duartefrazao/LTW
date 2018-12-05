<?php 

    include_once('../includes/database.php');

    function insertNewImage($id, $title){
        $db=Database::instance()->db();
        $stmt = $db->prepare("INSERT INTO images VALUES(?, ?)");
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