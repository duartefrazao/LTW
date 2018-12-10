<?php

    function draw_search_results($channels,$users,$posts){
        if(count($channels) + count($users) + count($posts) == 0){
            ?> 
                <a id="go_back_search" href="posts.php">No results found, click to go back</a>
            <?php
        }else{
            draw_channels_search($channels);
            draw_users_search($users);
            draw_posts_search($posts);
        }
    }

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
            <a href="../pages/profile.php?user=<?=$user['username']?>">
                <?=$user['username']?>
            </a>
        <?php }}
    }

    function draw_posts_search($posts){ 
        if(count($posts)>0){?>
        <h1> Posts </h1>
        <?php 
        draw_posts($posts);
    }}

?>