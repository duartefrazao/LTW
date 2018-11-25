<?php 
    include_once("../templates/tpl_common.php");
    include_once("../templates/tpl_posts.php");
    include_once("../database/db_post.php");
    include_once("../includes/session.php");

    $posts = getPosts();
    draw_header($_SESSION['username']);
    draw_posts($posts);
    ?>
    <div class="vote_section">
        <div class="upvote "></div>
        <div class="downvote "></div>
    </div>
    <?php
    draw_footer();
?>