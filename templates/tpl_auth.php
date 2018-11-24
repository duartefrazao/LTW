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
                <a href="signup.php">Sign Up here!</a>
            </p>
        </footer>
    
    </section>
<?php } ?>

<?php function draw_signup(){
    ?>
    <section id="signup">
        <header>
            <h1> Sign Up </h1>
        </header>

        <form method="post" action="../actions/action_signup.php">
            <input type="text" name="username" placeholder="username" required>
            <input type="text" name="mail" placeholder="mail" required>
            <input type="password" name="password" placeholder="password" required>
            <input type="text" name="description" placeholder="Brief description of yourself">
            <input type="submit" value="Signup">
        </form>

        <footer>
            <p>
                <a href="login.php">Log In here!</a>
            </p>
        </footer>
    
    </section>
<?php } ?>