<?php
require("functions.php");
head("Sign Up");
if (ctype_alnum(trim(str_replace(' ','',$_POST["username"]))) && ctype_alnum(trim(str_replace(' ','',$_POST["old_username"]))) && ctype_alnum(trim(str_replace(' ','',$_POST["password"])))) {
    
    $old_username = $_POST["old_username"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        require("database_connection.php");

        $statement = $conn->prepare("UPDATE poi_users SET username=?, password=? WHERE username=?" );

        $statement->execute([$username, $password, $old_username]);

        $_SESSION["user"] = $username;

        echo "<div class='container'><h3 class='wide' style='text-align:center'>Details updated successfully</h3></div>";
    }
    catch(PDOException $e) {
        return "Error: $e";
    };
}
else {
    echo "<div class='container'><h3 class='wide' style='text-align:center'>We only allow letters, numbers, and spaces. Please try again.</h3></div>";
}
foot();
?>