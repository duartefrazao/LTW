<?php function draw_posts($posts){
    ?>

    <section id="posts">

    <?php
        foreach($posts as $post)
            draw_post($post);
    ?>
<?php } ?>

<?php function draw_post($post){
    print_r($post);
    ?>
    <article class="post">
        <header>
            <h3 class="author">
                <?=$post['author']?>
            </h3>
            <h3 class="creationDate">
                <?=$post['creationDate']?>
            </h3>

            <h3 class="username">
                <?=$post['username']?>
            </h3>
            <h2 class="title"> 
                <?=$post['title']?>
            </h2>
        </header>

        <h2 class="content">
            <?=$post['content']?>
        </h2>

        <h2 class="votes">
            <?=$posts['votes']?>
        </h2>

        <h2 class="votes">
            <?=$posts['votes']?>
        </h2>
    </article>
<?php } ?>