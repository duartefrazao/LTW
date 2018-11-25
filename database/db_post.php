<?php 

    include_once('../includes/database.php');

    function getPosts(){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT * FROM POST');
        $stmt->execute();
        return $stmt->fetchAll();
    }

?>