
<?php function draw_header($username){
    ?>
    <!DOCTYPE html>
    <html>
        <head>
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
                <?php if($username == NULL){ ?>
                    <a class="normal-button" id="login-button" href="login.php"> Log In</a>
                    <a class="normal-button" id="signup-button" href="signup.php"> Sign Up </a>
                <?php }else{ ?>
                    <aside class="user-actions">
                        <h2 id="username"> <?= ucfirst($username);?> </h2>
                        <ul class="dropdown">
                            <li> <a href="../pages/profile.php"> Profile </a> </li>
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
                <a class="normal-button" id="back"  href="posts.php"> 
                    Back
                </a>
            </header>
<?php } ?> 

<?php function draw_footer(){
    ?>
        <a href="add_post.php" class="add-story"/>
        </body>
    </html>
<?php } ?>



<?php function draw_voting_aside($element)
{?>
    <aside class="voting_section" data-id="<?=$element['id']?>">

        <section class="vote upvote<?php 
                    if(isset($_SESSION['id']) && $element['up']=='true'){
        ?> upvote_triggered<?php } ?>"></section>
        
        <h5 class="votes">
            <?=$element['votes']?>
        </h5>
        
        <section class="vote downvote<?php 
                if(isset($_SESSION['id']) && $element['up']=='false'){
            ?> downvote_triggered<?php } ?>"></section>
    </aside>

    <!-- <span class="partial_line"></span> -->
<?php }?>


<?php function draw_ordering() { ?>
    <span id="ordering" >
        <select class="select">
            <option value="mostrecent"  selected>  Most Recent </option>
            <option value="mostvoted-month">  Most Voted </option>
        </select>
    </span>
<?php } ?>

<?php function drawUserImage($id){
    if( file_exists('../images/users/thumb_small/' . $id . '.jpg') ){ ?>
        <img class="user-image" src="../images/users/thumb_small/<?= $id ?>.jpg" width="16" height="16">
    <?php } else { ?>
        <img src="../images/users/default/user_icon.png" width="16" height="16">
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
}

function draw_search(){?>
    <section id="search-bar" >
        <form autocomplete="off" id = "search" action="../pages/search.php" enctype="multipart/form-data" method="post">
        <input id="searchInput" type="text" name="search" placeholder="Search" required/>
        <div id="displaySuggestions"> </div>
        <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </section>
<?php }

function includeScript($script){ ?>
    <script src="../scripts/<?=$script?>.js" defer></script>
<?php } 
?>
