<?php 
    session_start();

    if (ctype_alnum($_POST["username"]) && ctype_alnum($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        if ($_SESSION["gatekeeper"] == $username) {
            header("Location: index.php");
        }
        else {
            // Try to do the following code. It might generate an exception (error)
            try {
                require("database_connection.php");

                $statement = $conn->prepare("select * from ht_users where username=? AND password=?");

                $statement->execute([$username, $password]);

                while($row=$statement->fetch()) {
                    if ($row) {
                        $_SESSION["gatekeeper"] = $row["username"];
                        if ($row["isadmin"] == 1) {
                            $_SESSION["admin"] = $row["isadmin"];
                        };
                        header("Location: index.php");
                    }
                    else {
                        echo "Try again";
                    }
                };
            }
            // Catch any exceptions (errors) thrown from the 'try' block
            catch(PDOException $e) {
                echo "Error: $e";
            }
        }
    }
    else {
        echo "Don't try to hack this site";
    }
?>