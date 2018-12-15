<?php 
    include_once("../templates/tpl_posts.php");
    include_once("../templates/tpl_common.php");
    function draw_user_info($info) { ?>

        <section id="information">

                <header>
                    <?php if(isset($_SESSION['username']) && $_SESSION['username'] == $info['username']){?>
                    <a id="settings_button" ><i class="fas fa-user-edit"></i></a>
                    <?php }?>
                    <?php drawMediumImage('users', $info['id']); ?>
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
                ?> </section>
        </section>
<?php }  ?>

<?php 
    function draw_settings($id,$info){?>
    <section id="settings">
        <header>
            <h1>Settings</h1>
        </header>
        <form class="setting" method="post" action="../actions/action_update_data.php" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">
            <input type="hidden" name="id" value="<?=$info['id'];?>">
            <table>
                <tr>
                    <th>Image:</th>
                    <td><?php drawMediumImage('users', $info['id']) ?></td>
                    <td><input type="file" name="image" placeholder="Your image"></td>   
                </tr>
                <tr>
                    <th>Username:</th>
                    <td><input type="text" name="username" placeholder="New username" value="<?=$info['username'];?>" required></td>
                </tr>
                <tr>
                    <th>E-mail:</th>
                    <td><input type="text" name="mail" placeholder="New e-mail" value="<?=$info['mail'];?>" required></td>
                </tr>
                <tr>
                    <th>Description:</th>
                    <td><input type="text" name="description" placeholder="New description" value="<?=$info['description'];?>"></td>
                </tr>
                <tr>
                    <th>New Pass:</th>
                    <td><input type="password" name="pass"></td>
                </tr>
                <tr>
                    <th>Re-enter new pass:</th>
                    <td><input type="password" name="repass"></td>   
                </tr>
                <tr>
                    <td><input class="setting_button" type="submit" value="Save"></td>
                </tr>
            </table>
        </form>
    </section>
<?php }  ?>