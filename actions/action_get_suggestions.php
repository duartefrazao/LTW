<?php

    include_once('../database/db_channel.php');
    include_once('../actions/action_verify_input.php');

    if(isset($_POST['search']) && $_POST['search'] != ""){
        $name= test_input($_POST['search']);
        $suggestions = getSimilarChannels($name);
        echo '<ul>';
        foreach($suggestions as $s){ 
            ?><li onclick='fill("<?php
             echo $s['title'];?>")'><a><?php
             echo ($s['title']); ?></li></a><?php
        }
    }
?>
</ul>