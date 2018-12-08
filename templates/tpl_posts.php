<?php include_once("../templates/tpl_common.php"); ?>


<?php function draw_posts($posts)
{?>
    <section id="posts">
        <?php
            foreach ($posts as $post) {
                draw_overview_post($post);
            }
        ?>
    </section>
<?php }?>


<?php function draw_add_post(){?>

    <form id="new-post" action="../actions/action_add_post.php" enctype="multipart/form-data" method="post">
        <input type="text" required name="title" placeholder="Post's title"/>
        <input type="text" name="description" placeholder="Image Title">
        <input type="file" name="image" placeholder="Your image">
        <textarea name="text" required placeholder="Your post"></textarea>
        
        <input type="submit" value="Share">
    </form>

<?php } ?>


<?php function draw_post($post, $comments){?>
    <article id="post">
        <input type="hidden" name="id" value="<?=$post['id']?>">

        <?php draw_voting_aside($post) ?>

        <?php draw_post_header($post) ?>

        <h1 class="title">
            <?=$post['title']?>
        </h1>

        <h2 class="content">
            <?=$post['content']?>
        </h2>

        <?php drawPostImage($post['id']) ?>

        <?php draw_add_comment($post) ?>   

        <hr/>

        <?php draw_comments($comments) ?>  

    </article>
<?php }?>


<?php function draw_overview_post($post)
{?>
    <article class="overview-post">
        <?php draw_voting_aside($post) ?>

        <?php draw_post_header($post) ?>

        <h1 class="title">
            <?=$post['title']?>
        </h1>

        <?php drawPostImage($post['id']) ?>
        
        <?php draw_comment_footer($post) ?> 
    </article>
<?php }?>



<?php function draw_post_header($post)
{?>
    <header>
        <h3 class="author">
            <?=$post['author']?>
        </h3>
        <h3 class="username">
            <?php drawUserImage($post['author']) ?><?=$post['username']?>
        </h3>
        <h3 class="creationDate">
            <?=humanTiming($post['creationDate']);?>
        </h3>
    </header>
<?php } ?>






<?php function drawPostImage($id){
    if( file_exists('../images/posts/thumb_medium/' . $id . '.jpg') ){ ?>
        <img class="post-image" src="../images/posts/thumb_medium/<?= $id ?>.jpg">
<?php } }?>




<?php function draw_comment_footer($post)
{?>
    <footer>
        <h5 class="comments">
            <a href= "post.php?id=<?=$post['id']?>" ><?=$post['numComments']?> Comment</a><?=$post['numComments'] == 1 ? '' : 's'?>
        </h5>
    </footer>
<?php }?>


