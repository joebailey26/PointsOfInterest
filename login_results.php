<?php 
    require("functions.php");

    if (ctype_alnum($_POST["username"]) && ctype_alnum($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        if ($_SESSION["user"] == $username) {
            header("Location: my_account.php");
        }
        else {
            // Try to do the following code. It might generate an exception (error)
            try {
                require("database_connection.php");

                $statement = $conn->prepare("select * from poi_users where username=? AND password=?");

                $statement->execute([$username, $password]);

                if($row=$statement->fetch()) {
                    $_SESSION["user"] = $row["username"];
                    if ($row["isadmin"] == 1) {
                        $_SESSION["admin"] = $row["isadmin"];
                    };
                    header("Location: my_account.php");
                }
                else {
                    head("Log In");
                    echo "<div class='container'><h3 class='wide' style='text-align:center'>Username or Password incorrect.</h3></div>";
                    foot();
                }
            }
            // Catch any exceptions (errors) thrown from the 'try' block
            catch(PDOException $e) {
                echo "Error: $e";
            }
        }
    }
    else {
        head("Log In");
        echo "<div class='container'><h3 class='wide' style='text-align:center'>We only allow letters, numbers, and spaces. Please try again.</h3></div>";
        foot();
    }
?>