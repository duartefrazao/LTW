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

<?php function draw_post($post, $comments)
{?>
    <section id="post" />
            
        <article class="overview-post">
                <?php draw_voting_aside($post) ?>
                <section class="post-content">
                    <?php draw_post_header($post) ?>
                    <h1 class="title">
                        <?=$post['title']?>
                    </h1>
                    <h2 class="content">
                        <?=$post['content']?>
                    </h2>
                </section> 
        </article>

<?php draw_add_comment($post) ?>   

<?php draw_comments($comments) ?>  
 
    
    </section>
<?php }?>


<?php function draw_overview_post($post)
{?>
    <article class="overview-post">
        <?php draw_voting_aside($post) ?>
        <section class="post-content">
            <?php draw_post_header($post) ?>
            <h1 class="title">
                <?=$post['title']?>
            </h1>
            <?php draw_comment_footer($post) ?> 
        </section>
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
    <aside class="voting_section">
        <a href="../actions/action_vote_post.php?id=<?=$post['id']?>&type=1" >
            <section class="upvote "></section>
        </a>
        <h5 class="votes">
            <?=$post['votes']?>
        </h5>
        <a href="../actions/action_vote_post.php?id=<?=$post['id']?>&type=-1" >
            <section class="downvote" href="../actions/action_vote_post.php?id=<?=$post['id']?>&type=-1"></section>
        </a>    
    </aside>

    <span class="partial_line"></span>
<?php }?>

<?php function draw_comment_footer($post)
{?>
    <footer>
        <h5 class="comments">
            <a href= "post.php?id=<?=$post['id']?>" ><?=$post['numComments']?> Comment</a><?=$post['numComments'] == 1 ? '' : 's'?>
        </h5>
    </footer>
<?php }?>


