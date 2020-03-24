<?php
    include("functions.php"); 

    head("Log In");

?>
<div class="container constrained">
<?php if (!isset($_SESSION["user"])) { ?>
    <h1 class="wide">Log In to Points Of Interest</h1>
    <form method="POST" action="login_results.php" class='wide'>
        <label>
            Username:
            <input type="text" placeholder="Han Solo" required class="card" name="username" />
        </label>
        <label>
            Password:
            <input type="password" required class="card" name="password" />
        </label>
        <input type="submit" value="Log In!" class="card"/>
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