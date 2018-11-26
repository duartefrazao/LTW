
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