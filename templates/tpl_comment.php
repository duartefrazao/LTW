<?php function draw_comments($comments){
    ?>

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
            <h3 class="author">
                <?=$comment['username']?>
            </h3>
        </header>

        <h2 class="content">
            <?=$comment['content']?>
        </h2>

        <h2 class="votes">
            <?=$comment['upvotes']?>
        </h2>

    </article>
<?php } ?>