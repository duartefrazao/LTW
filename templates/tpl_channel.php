<?php

    include_once("../templates/tpl_common.php");

    function drawChannelInfo($channel){?>
        <article class="channel-info">
            <?php drawSmallImage('channels', $channel['id']) ?>
            <a  href="../pages/channel.php?channel=<?=$channel['id']?>">
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
        <input type="file"  name="image" placeholder="Channel Banner">
        <input type="submit" value="Create">
    </form>
<?php } ?>


<?php function drawChannelPage($channelInfo, $posts){ ?>
    
        <article id="channel">

            <section class='info'>
                <?php drawMediumImage('channels', $channelInfo['id']) ?>
                <h1> <?= $channelInfo['title'] ?> </h1>
                <span>
                    <?=$channelInfo['description'] ?>
                </span>
            </section>

            <?php draw_posts($posts); ?>
        </article>
<?php } ?>