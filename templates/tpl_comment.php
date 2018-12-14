<?php include_once("../templates/tpl_common.php"); ?>

<?php function draw_comments($comments){?>

    <section id="comments">

    <?php
        foreach($comments as $commnet)
            draw_comment($commnet);
    ?>

    </section>
<?php  } ?>

<?php function draw_comment($comment){
    ?>
    <article class="comment">
    <?php draw_voting_aside($comment) ?>
        <header>
            <a href="../pages/profile.php?user=<?=$comment['username']?>">
            <h3 data-id="<?= $comment['id'] ?>" class="username">
            <?php drawUserImage($comment['author']) ?><?=$comment['username']?>
            </h3>
            </a>
            <h3 class="creationDate">
                <?=humanTiming($comment['creationDate']);?>
            </h3>
        </header>

        <div class="vr"></div>

        <h2 class="content">
            <?=$comment['title']?>
        </h2>  

        <?php draw_comment_footer($comment) ?>

    </article>
<?php } ?>


<?php function draw_add_comment($post){
    ?>
    <form class="comment-text-area">
        <textarea name="text" required></textarea>
        <input type="hidden" name="id" value="<?=$post['id']?>">
        <input type="submit" value="Reply">
    </form>

<?php } ?>

<?php function draw_comment_footer($comment){ ?>
    <footer>
        <span class="numReplies"> 
                <?=$comment['numComments']?> Repl<?= $comment['numComments'] == 1 ? 'y' : 'ies'?>
        </span>
        <span class="reply">
            Reply
        </span>
    </footer>
<?php }?>