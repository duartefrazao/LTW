<?php
    function drawChannelInfo($channel){?>

    <section id="channel_info">
        <h1 id="title"><?=$channel['title']?></h1>
        <!-- <h2 id="description"><?=$channel['description']?></h2> -->
    </section>

    <?php }


    function drawChannelsDropdown($channels){ ?>
        <select class="drp_channels" name="channel">

        <?php foreach($channels as $channel){ ?>
            <option value="<?= $channel['id'] ?>" > <?= $channel['title'] ?> </option>
        <?php } ?>

        </select>
    <?php } ?>
