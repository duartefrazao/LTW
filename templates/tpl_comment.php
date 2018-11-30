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
        <header>
            <h3 data-id="<?= $comment['id'] ?>" class="username">
                <i class="fas fa-user-circle"></i> <?=$comment['username']?>
            </h3>
            <h3 class="creationDate">
                <?=humanTiming($comment['creationDate']);?>
            </h3>

        </header>

        <h2 class="content">
            <?=$comment['title']?>
        </h2>

        <h2 class="votes">
            <?=$comment['votes']?>
        </h2>

        

    </article>
<?php } ?>


<?php function draw_add_comment($post){
    ?>
    <form>
        <label>
          <textarea name="text"></textarea>
        </label>
        <input type="hidden" name="id" value="<?=$post['id']?>">
        <input type="submit" value="Reply">
    </form>

<?php } ?>