<?php function draw_posts($posts)
{
    ?>

    <section id="posts">

    <?php
    foreach ($posts as $post) {
        draw_overview_post($post);
    }

    ?>

    </section>
<?php }?>

<?php function draw_post($post)
{
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
<?php }?>


<?php function draw_overview_post($post)
{?>
    <article class="overview-post">
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
        <section class="post">
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

            <h1 class="title">
                <?=$post['title']?>
            </h1>

            <footer>
                <h5 class="comments">
                    <a href= "post.php?id=<?=$post['id']?>" ><?=$post['numComments']?> Comment</a><?=$post['numComments'] == 1 ? '' : 's'?>
                </h5>
            </footer>
        </section>


    </article>
<?php }?>



<?php function humanTiming($time)
{
    // propz =  https://stackoverflow.com/questions/2915864/php-how-to-find-the-time-elapsed-since-a-date-time
    $time = time() - $time; // to get the time since that moment
    $time = ($time < 1) ? 1 : $time;
    $tokens = array(
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second',
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) {
            continue;
        }

        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
    }

}
?>