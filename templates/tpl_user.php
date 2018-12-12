<?php 
    include_once("../templates/tpl_posts.php");
    include_once("../templates/tpl_common.php");
    function draw_user_info($info) { ?>

        <section id="information">

                <header>
                    <a href="settings.php"><i class="fas fa-user-edit"></i></a>
                    <?php drawUserImageMedium($info['id']); ?>
                    <h1><?=ucfirst($info['username']);?></h1>
                </header>
                <table>
                    <tr>
                        <th>E-Mail</th>
                        <td><?=$info['mail']; ?></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><?=$info['description']; ?></td>
                    </tr>
                    <tr>
                        <th>Date of Creation</th>
                        <td><?=humanTiming($info['creationDate']); ?></td>
                    </tr>
                </table>

        </section>
<?php }
    function draw_profile($user,$info,$posts){?>
        <section class = "user_page">
            <?php 
                draw_user_info($info);
                ?> <section id="profile_right"> <?php
                    draw_ordering();
                    draw_posts($posts);
                ?> </section><?php
            ?>
        </section>
<?php }  ?>