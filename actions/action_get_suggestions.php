<?php

    include_once('../database/db_channel.php');

    if(isset($_POST['search']) && $_POST['search'] != ""){
        $name= $_POST['search'];
        $suggestions = getChannelSuggestionsBySubstring($name);
        echo '<ul>';
        foreach($suggestions as $s){ 
            ?><li onclick='fill("<?php
             echo $s['title']; ?>")'><a><?php
             echo ($s['title']); ?></li></a><?php
        }
    }
?>
</ul>