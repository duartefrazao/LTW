<?php
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_channel.php");

    function draw_search_results($channels,$users,$posts){
        if(count($channels) + count($users) + count($posts) == 0){
            ?> 
                <a id="go_back_search" href="posts.php">No results found, click to go back</a>
            <?php
        }else{
            ?> <section id="search_results"> <?php
            draw_channels_search($channels);
            draw_users_search($users);
            draw_posts_search($posts);
            ?> </section> <?php
        }
    }

    function draw_channels_search($channels){ 
        if(count($channels)>0){?>
        
        <section id="channels_search">
            <h1 class="search_title"> <i class="fas fa-tv"></i>  Channels </h1>
            <?php 
            foreach($channels as $channel){
                drawChannelInfo($channel);
            } ?>
        </section> <?php }
    }

    function draw_users_search($users){ 
        if(count($users)>0){?>
        <section id="users_search">
            <h1 class="search_title"> Users </h1>
            <?php 
            foreach($users as $user){ ?>
               <a class="box" href="../pages/profile.php?user=<?=$user['username']?>">
                    <h3 class="username">
                        <?php drawSmallImage('users', $user['id']) ?><?=$user['username']?>
                    </h3>
                </a>
            <?php } ?>
        </section>
        <?php }
    }

    function draw_posts_search($posts){ 
        if(count($posts)>0){?>
        <section id="posts_search">
        <h1 class="search_title"> Posts </h1>
        <?php 
        draw_posts($posts);
        ?>
        </section>
        <?php
    }}

?>