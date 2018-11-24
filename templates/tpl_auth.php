<?php function draw_login(){
    ?>
    <section id="login">
        <header>
            <h1> Log In </h1>
        </header>

        <form method="post" action="../actions/action_login.php">
            <input type="text" name="username" placeholder="username" required>
            <input type="password" name="password" placeholder="password" required>
            <input type="submit" value="Login">
        </form>

        <footer>
            <p>
                <a href="signup.php">Signup here!</a>
            </p>
        </footer>
    
    </section>
<?php } ?>