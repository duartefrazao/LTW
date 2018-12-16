<?php

    include_once("../templates/tpl_common.php");

    function drawChannelInfo($channel){?>
        <article class="channel-info">
            <?php drawSmallImage('channels', $channel['id']) ?>
            <a  class="channel-link" href="../pages/channel.php?channel=<?=$channel['id']?>">
                <?=$channel['title']?>
            </a>
            <span>
                <?=$channel['description'] ?>
            </span>
        </article>
    <?php }


    function drawChannelsDropdown($channels){ ?>
        <select class="drp_channels" name="channel">

        <?php foreach($channels as $channel){ ?>
            <option value="<?= $channel['id'] ?>" > <?= $channel['title'] ?> </option>
        <?php } ?>

        </select>
    <?php } ?>


<?php function drawAddChannel() { ?>
    <form id="new-channel" action="../actions/action_add_channel.php?csrf=<?=$_SESSION['csrf']?>" enctype="multipart/form-data" method="post">
        <input type="text" required name="title" placeholder="Channel Title"/>
        <input type="text" required name="description" placeholder="Channel Description">
        <input type="text" name="imageDescription" placeholder="Image Title">
        <label class="fileContainer" >
            File
            <input type="file" title=" " name="image" placeholder="Channel Banner">
        </label>
        <input type="submit" value="Create">
    </form>
<?php } ?>


<?php function drawChannelPage($channelInfo){ ?>
    
        <article id="channel">

            <section class='info'>
                <input type="hidden" value="<?= $channelInfo['id']?>" > 
                <?php drawMediumImage('channels', $channelInfo['id']) ?>
                <h1> <?= $channelInfo['title'] ?> </h1>
                <span>
                    <?=$channelInfo['description'] ?>
                </span>
            </section>
<<<<<<< HEAD

            <?php draw_posts(); ?>
=======
            <section id="channel_right"> <?php
            draw_ordering();
            draw_posts($posts); ?>
            </section>
>>>>>>> mobile
        </article>
<?php } ?>