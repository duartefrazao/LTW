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
                    <a href="#"> 
                        Mate
                    </a>
                </h1>

                <?php if($username == NULL){ ?>
                   <h2 id="login"> Log In </h2>
                   <h2 id="signup"> Sign Up </h2>
                <?php }else{ ?>
                    <h2 id="username"> </h2>
                <?php } ?>
            </header>

<?php } ?>
