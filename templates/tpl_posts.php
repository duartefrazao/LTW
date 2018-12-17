<?php include_once("../templates/tpl_common.php"); ?>
<?php include_once("../templates/tpl_channel.php"); ?>
<?php include_once("../database/db_channel.php"); ?>


<?php function draw_posts()
{?>
    <section id="posts">
    </section>
<?php }?>


<?php function draw_add_post($channels){?>
    <form id="new-post" action="../actions/action_add_post.php?csrf=<?=$_SESSION['csrf']?>" enctype="multipart/form-data" method="post">
        <input type="text" required name="title" placeholder="Post's title"/>
        <?php drawChannelsDropdown($channels) ?>
        <textarea name="text" required placeholder="Your post"></textarea>
        <input type="text" name="description" placeholder="Image Title">
        <label class="fileContainer" >
            File
            <input src="" type="file" id="image_input" name="image" placeholder="Your image" multiple accept="image/jpeg,image/jpg,image/gif,image/png">
        </label>
        <input type="submit" value="Share">
    </form>
<?php } ?>


<?php function draw_post($post){?>

    <article id="post">
        <input type="hidden" name="id" value="<?=$post['id']?>">

        <?php draw_voting_aside($post) ?>

        <?php draw_post_header($post) ?>
        <h1 class="title" >
            <?=$post['title']?>
        </h1>

        <h2 class="content">
            <?=$post['content']?>
        </h2>

        <?php drawPostImage($post['id']) ?>

        <?php draw_add_comment($post) ?>   

        <hr/>

        <section id="comments"> </section>

        <span class="load-more"> Load More </span>

        <?php draw_add_button(); ?>

    </article>
<?php }?>

<?php function draw_post_definition($post){?>

<article id="post">
    <input type="hidden" name="id" value="<?=$post['id']?>">

    <?php draw_voting_aside($post) ?>

    <?php draw_post_header($post) ?>
    <h1 class="title" >
        <?=$post['title']?>
    </h1>

    <h2 class="content">
        <?=$post['content']?>
    </h2>

    <?php drawPostImageDefinition($post['id']) ?>

    <?php draw_add_comment($post) ?>   

    <hr/>

    <section id="comments"> </section>

    <span class="load-more"> Load More </span>

    <?php draw_add_button(); ?>

</article>
<?php }?>


<?php function draw_post_header($post)
{?>
    <header>
        <h3 class="author">
            <?=$post['author']?>
        </h3>
        <a class="user-info" href="../pages/profile.php?user=<?=$post['username']?>">
            <div>
            <?php drawSmallImage('users', $post['author']) ?>
            </div>
            <h3>
                <?=$post['username']?>
            </h3>
        </a>
        <a class="channel-link" href="../pages/channel.php?channel=<?=$post['channel']?>">
            <?= $post['channelTitle'] ?>
        </a>
        <h3 class="creationDate">
            <?=humanTiming($post['creationDate']);?>
        </h3>
    </header>
<?php } ?>


<?php function drawPostImage($id){
    $ext=array_map("pathinfo",glob('../images/posts/originals/' . $id . '.*'));
    $cArray = count($ext);
    if($cArray != 0 && $ext[0]['extension']=="gif" && file_exists('../images/posts/originals/' .$id. '.' .$ext[0]['extension']) ){ ?>
        <img class="post-image" src="../images/posts/originals/<?= $id ?>.<?= $ext[0]['extension']?>">
    <?php } 
    else if($cArray != 0 &&  file_exists('../images/posts/thumb_medium/' . $id . '.' .$ext[0]['extension']) )
     { ?>
        <img class="post-image" src="../images/posts/thumb_medium/<?= $id ?>.<?= $ext[0]['extension']?>">
<?php } }?>
<?php function drawPostImageDefinition($id){
    $ext=array_map("pathinfo",glob('../images/posts/originals/' . $id . '.*'));
    $cArray = count($ext);
    if($cArray != 0 && file_exists('../images/posts/originals/' .$id. '.' .$ext[0]['extension']) ){ ?>
        <img class="post-image" src="../images/posts/originals/<?= $id ?>.<?= $ext[0]['extension']?>">
    <?php }  }?>
