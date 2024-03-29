
<?php function draw_header($username){?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <style>
                    @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro');
            </style>
            <meta charset="utf-8">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
            <link rel="stylesheet" href="../css/style.css">
        </head>
        <body>
            <header>
                <h1 id="logo"> 
                    <a href="posts.php"> 
                        Mate
                    </a>
                </h1>
                <?php draw_search() ?>
                <?php if($username == NULL){ 
                        includeScript('auth');
                    ?>
                    
                    <a class="normal-button" id="login-button"> Log In</a>
                    <a class="normal-button" id="signup-button"> Sign Up </a>
                <?php }else{ ?>
                    <aside class="user-actions">
                        <h2 id="username"> <?= ucfirst($username);?> </h2>
                        <ul class="dropdown">
                            <li> <a href="../pages/profile.php?user=<?= $_SESSION['username'] ?>"> Profile </a> </li>
                            <li> <a href="../pages/add_channel.php?csrf=<?=$_SESSION['csrf']?>"> Create a new Channel! </a> </li>
                            <li> <a href="../pages/subscriptions.php"> Your subscriptions </a> </li>
                            <li> <a href="../actions/action_logout.php"> Log Out </a> </li>
                        </ul>
                    </aside>
                <?php } ?>
            </header>


<?php } ?>


<?php function draw_simple_header(){
    ?>
    <!DOCTYPE html>
    <html>
        <head>
         <meta name="viewport" content="width=device-width, initial-scale=1">
            <style>
                @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro');
            </style>
            <meta charset="utf-8">
            <link rel="stylesheet" href="../css/style.css">
        </head>

        <body>

            <header>
                <h1  id="logo" > 
                    <a href="posts.php"> 
                        Mate
                    </a>
                </h1>
                <a class="normal-button" id="back"  href="javascript:history.back()"> 
                    Back
                </a>
            </header>
<?php } ?> 


<?php function draw_add_button(){ 
    if(isset($_SESSION['username'])) {?>
    <a href="add_post.php" class="add-story">&#43;</i></a>
    <?php } ?>

<?php } ?>

 
<?php function draw_footer(){
    ?>
        </body>
    </html>
<?php } ?>
<?php function draw_simple_footer(){
    ?>
        </body>
    </html>
<?php } ?>


<?php function draw_voting_aside($element)
{?>
    <aside class="voting_section" data-id="<?=$element['id']?>">

        <section class="vote upvote<?php 
                if(isset($_SESSION['id']) && isset($element['up']) && $element['up']=='true'){
        ?> upvote_triggered<?php } ?>"></section>
        
        <h5 class="votes">
            <?=$element['votes']?>
        </h5>
        
        <section class="vote downvote<?php 
                if(isset($_SESSION['id']) && isset($element['up']) && $element['up']=='false'){
        ?> downvote_triggered<?php } ?>"></section>

    </aside>

<?php }?>


<?php function draw_ordering() { ?>
    <span id="ordering" >
        <select class="order">
            <option value="mostrecent"  selected>  Most Recent </option>
            <option value="mostvoted">  Most Voted </option>
            <option value="mostcommented">  Most Comments </option>
        </select>
    </span>
<?php } ?>

<?php function drawSmallImage($path, $id){
    $ext=array_map("pathinfo",glob('../images/'. $path. '/originals/' . $id . '.*'));
    $cArray = count($ext);
    if($cArray != 0 && $ext[0]['extension']=="gif" && file_exists('../images/'. $path. '/originals/' . $id . '.' .$ext[0]['extension']) ) { ?>
        <img class="small-image" src="../images/<?=$path?>/originals/<?= $id ?>.<?= $ext[0]['extension']?>" width="40" height="40">
<?php } 
    else if($cArray != 0 &&  file_exists('../images/'. $path. '/thumb_small/' . $id . '.' .$ext[0]['extension']) )
     { ?>
        <img class="small-image" src="../images/<?=$path?>/thumb_small/<?= $id ?>.<?= $ext[0]['extension']?>">
<?php }
    else{  ?>
        <img class="small-image"  src="../images/<?=$path?>/default/default_small.png">
    <?php } }?>

<?php function drawMediumImage($path, $id){
    $ext=array_map("pathinfo",glob('../images/'. $path. '/originals/' . $id . '.*'));
    $cArray = count($ext);
    if($cArray != 0 && $ext[0]['extension']=="gif" && file_exists('../images/' . $path . '/originals/' .$id. '.' .$ext[0]['extension']) ){ ?>
        <img class="small-image" src="../images/<?=$path?>/originals/<?= $id ?>.<?= $ext[0]['extension']?>" width="40" height="40">
    <?php } 
    else if($cArray != 0 &&  file_exists('../images/'. $path. '/thumb_medium/' . $id . '.' .$ext[0]['extension']) )
     { ?>
        <img class="small-image" src="../images/<?=$path?>/thumb_medium/<?= $id ?>.<?= $ext[0]['extension']?>">
     <?php }
     else {?>
        <img class="small-image" src="../images/<?=$path?>/default/default_medium.png" >
<?php } }?>


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
}?>
<?php function draw_search(){?>
    <section id="search-bar" >
        <form autocomplete="off" id = "search" action="../pages/search.php" enctype="multipart/form-data" method="get">
        <input id="searchInput" type="text" name="search" />
        </form>
        <div id="displaySuggestions"> </div>
    </section>
<?php } ?>

<?php function includeScript($script){ ?>
    <script  src="../scripts/<?=$script?>.js" defer></script>
<?php } 
?>

