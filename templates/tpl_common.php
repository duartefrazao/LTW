
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
            <?php 
                if($username!==NULL){?>
                    <script src="../scripts/script.js" defer></script>
                <?php } ?>
        </head>

        <body>

            <header>
                <h1 > 
                    <a id="logo" href="posts.php"> 
                        Mate
                    </a>
                </h1>
                <?php if($username == NULL){ ?>
                   <a class="normal-button" id="login-button" href="login.php"> Log In</a>
                   <a class="normal-button" id="signup-button" href="signup.php"> Sign Up </a>
                <?php }else{ ?>
                    
                    <a class="normal_button" href="../actions/action_logout.php">
                        Log Out
                    </a> 
                    <h2 id="username"> <?=$username?> </h2>
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
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
            <link rel="stylesheet" href="../css/style.css">
            <script src="../scripts/script.js" defer></script>
        </head>

        <body>

            <header>
                <h1 > 
                    <a id="logo" href="posts.php"> 
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
        </body>
    </html>
<?php } ?>


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