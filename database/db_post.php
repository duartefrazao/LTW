<?php 

    include_once('../includes/database.php');

    function getPosts(){
        $db = Database::instance()->db();
        $stmt = $db->prepare('SELECT POST.id, POST.title, POST.content, POST.author, POST.votes, POST.creationDate, USER.username FROM POST JOIN USER ON POST.author = USER.id');
        $stmt->execute();
        return $stmt->fetchAll();
    }

?>