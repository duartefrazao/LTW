<?php include_once("../templates/tpl_common.php"); ?>

<?php function draw_add_comment($post){
    ?>
    <form class="comment-text-area">
        <textarea name="text" required></textarea>
        <input type="hidden" name="id" value="<?=$post['id']?>">
        <input type="submit" value="Reply">
    </form>

<?php } ?>
