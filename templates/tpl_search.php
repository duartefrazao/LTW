<?php

    function draw_channels_search($channels){ 
        if(count($channels)>0){?>
        <h1> Channels </h1>
        <?php 
        foreach($channels as $channel){ ?>
            <a href="../pages/channel.php?channel=<?=$channel['id']?>">
                <?=$channel['title']?>
            </a>
        <?php }}
    }

    function draw_users_search($users){ 
        if(count($users)>0){?>
        <h1> Users </h1>
        <?php 
        foreach($users as $user){ ?>
            <h2><?=$user['username']?></h2>
        <?php }}
    }

    function draw_posts_search($posts){ 
        if(count($posts)>0){?>
        <h1> Posts </h1>
        <?php 
        draw_posts($posts);
    }}

?>