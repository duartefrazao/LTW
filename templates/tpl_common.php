
<?php function draw_header($username){
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
                <h1 > 
                    <a id="logo" href="list.php"> 
                        Mate
                    </a>
                </h1>

                <?php if($username == NULL){ ?>
                   <a class="normal-button" id="login-button" href="login.php"> Log In</a>
                   <a class="normal-button" id="signup-button" href="signup.php"> Sign Up </a>
                <?php }else{ ?>
                    <h2 id="username"> <?=$username?> </h2>
                <?php } ?>
            </header>

<?php } ?>


<?php function draw_simple_header(){
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <link rel="stylesheet" href="../css/style.css">
        </head>

        <body>

            <header>
                <h1> 
                    <a id="logo" href="list.php"> Mate </a>
                </h1>
                    <a href="list.php"> 
                        Back
                    </a>
            </header>
<?php } ?> 

<?php function draw_footer(){
    ?>
        </body>
    </html>
<?php } ?>