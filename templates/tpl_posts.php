<?php include_once("../templates/tpl_common.php"); ?>
<?php include_once("../templates/tpl_channel.php"); ?>


<?php function draw_posts($posts)
{?>
    <section id="posts">
        <?php
            foreach ($posts as $post) {
                draw_overview_post($post);
            }
        ?>
    </section>


    <a href="add_post.php" class="add-story">&#43;</i></a>
<?php }?>


<?php function draw_add_post($channels){?>
    <form id="new-post" action="../actions/action_add_post.php" enctype="multipart/form-data" method="post">
        <input type="text" required name="title" placeholder="Post's title"/>
        <?php drawChannelsDropdown($channels) ?>
        <textarea name="text" required placeholder="Your post"></textarea>
        <input type="text" name="description" placeholder="Image Title">
        <label class="fileContainer" >
            File
            <input type="file" title=" " name="image" placeholder="Your image">
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

    </article>
<?php }?>


<?php function draw_overview_post($post)
{?>
    <article class="overview-post">
        <?php draw_voting_aside($post) ?>

        <?php draw_post_header($post) ?>

        <a href="../pages/post.php?id=<?= $post['id']?>">
            <h1 class="title" >
                <?=$post['title']?>
            </h1>
        </a>

        <?php drawPostImage($post['id']) ?>
        
        <?php draw_post_footer($post) ?> 
    </article>
<?php }?>



<?php function draw_post_header($post)
{?>
    <header>
        <h3 class="author">
            <?=$post['author']?>
        </h3>
        <a href="../pages/profile.php?user=<?=$post['username']?>">
            <h3 class="username">
                <?php drawSmallImage('users', $post['author']) ?><?=$post['username']?>
            </h3>
        </a>
        <h3 class="creationDate">
            <?=humanTiming($post['creationDate']);?>
        </h3>
    </header>
<?php } ?>






<?php function drawPostImage($id){
    if( file_exists('../images/posts/thumb_medium/' . $id . '.jpg') ){ ?>
        <img class="post-image" src="../images/posts/thumb_medium/<?= $id ?>.jpg">
<?php } }?>




<?php function draw_post_footer($post)
{?>
    <footer>
        <h5 class="comments">
            <a href= "post.php?id=<?=$post['id']?>" ><?=$post['numComments']?> Comment</a><?=$post['numComments'] == 1 ? '' : 's'?>
        </h5>
    </footer>
<?php }?>


