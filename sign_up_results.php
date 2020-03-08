<?php 
    require("functions.php");

    if (ctype_alnum(trim(str_replace(' ','',$_POST["username"]))) && ctype_alnum(trim(str_replace(' ','',$_POST["password"])))) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Try to do the following code. It might generate an exception (error)
        try {
            require("database_connection.php");

            $statement = $conn->prepare("INSERT INTO poi_users (username, password) VALUES (?, ?)");

            $statement->execute([$username, $password]);

            $_SESSION["user"] = $username;

            header("Location: my_account.php");
        }
        // Catch any exceptions (errors) thrown from the 'try' block
        catch(PDOException $e) {
            echo "Error: $e";
        }
    }
    else {
        head("Sign Up");
        echo "<div class='container'><h3 class='wide' style='text-align:center'>We only allow letters, numbers, and spaces. Please try again.</h3></div>";
        foot();
    }
?>