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

    <form id="new-post" action="../actions/action_add_post.php" method="post">
        <input type="text" required name="title" placeholder="Post's title" />
        <textarea name="text" required placeholder="Your post"></textarea>
        <input type="submit" value="Share">
    </form>

<?php } ?>


<?php function draw_post($post, $comments)
{?>
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
            <i class="fas fa-user-circle"></i> <?=$post['username']?>
        </h3>
        <h3 class="creationDate">
            <?=humanTiming($post['creationDate']);?>
        </h3>
    </header>
<?php } ?>


<?php function draw_voting_aside($post)
{?>
    <aside class="voting_section" data-id="<?=$post['id']?>">

        <section class="vote upvote<?php 
                    if($post['up']=='true'){
        ?> upvote_triggered<?php } ?>"></section>
        
        <h5 class="votes">
            <?=$post['votes']?>
        </h5>
        
        <section class="vote downvote<?php 
                if($post['up']=='false'){
            ?> downvote_triggered<?php } ?>"></section>
    </aside>

    <!-- <span class="partial_line"></span> -->
<?php }?>

<?php function draw_comment_footer($post)
{?>
    <footer>
        <h5 class="comments">
            <a href= "post.php?id=<?=$post['id']?>" ><?=$post['numComments']?> Comment</a><?=$post['numComments'] == 1 ? '' : 's'?>
        </h5>
    </footer>
<?php }?>


