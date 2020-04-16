<?php
    include("functions.php"); 

    head("Sign Up");

?>
<div class="container constrained">
<?php
    if (!isset($_SESSION["user"])) {
        if ($_GET["ref"] == "add_new") {
            echo "<h1 class='wide'>You need an account to add a new POI</h1>";
        }
        else {
            echo "<h1 class='wide'>Create an account for Points Of Interest</h1>";
        };

?>
    <form method="POST" action="sign_up_results.php" class='wide'>
        <label>
            Username:
            <input type="text" placeholder="Han Solo" required class="card" name="username" />
        </label>
        <label>
            Password:
            <input type="password" required class="card" name="password" />
        </label>
        <input type="submit" value="Sign Up!" class="card"/>
    </form>
<?php 
    }
    else {
        echo "<h1 class='wide'>You're already logged in!</h1>";
    };
    ?>
    </div>
    <?php
    foot(); 
    
?>