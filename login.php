<?php
    include("functions.php"); 
?>
<!DOCTYPE html>
<html>
<head>
    <title>HitTastic! Login</title>
</head>
<body>
    <h1>Log in to HitTastic!</h1>
    <form method="POST" action="login_results.php">
        <label for="username">Username:</label>
        <input name="username" id="username" required/>
        <br/>
        <label for="password">Password:</label>
        <input name="password" id="password" type="password" required/>
        <br/>
        <input type="submit" value="Go!" />
    </form>
    <?php links("Login")?>
</body>
</html>