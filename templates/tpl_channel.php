<?php

    include_once("../templates/tpl_common.php");

    function drawChannelInfo($channel){?>
        <article class="channel">
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
    <form id="new-channel" action="../actions/action_add_channel.php" enctype="multipart/form-data" method="post">
        <input type="text" required name="title" placeholder="Channel Title"/>
        <input type="text" required name="description" placeholder="Channel Description">
        <input type="file"  name="image" placeholder="Channel Banner">
        <input type="submit" value="Create">
    </form>
<?php } ?>