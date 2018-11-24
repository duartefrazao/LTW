
<?php function draw_header($username){
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
                    <a href="list.php"> 
                        Mate
                    </a>
                </h1>

                <?php if($username == NULL){ ?>
                   <a href="login.php"> Log In</a>
                   <a href="signup.php"> Sign Up </a>
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
                    <a href="list.php"> Mate </a>
                </h1>
                <h1> 
                    <a href="list.php"> 
                        Back
                    </a>
                </h1>
            </header>
<?php } ?> 

<?php function draw_footer(){
    ?>
        </body>
    </html>
<?php } ?>