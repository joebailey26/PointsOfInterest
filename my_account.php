<?php 

require("functions.php");

if (isset($_SESSION["user"])) {

head("My Account");

?>

<div class="container constrained">
<?php
    // Try to do the following code. It might generate an exception (error)
    try {
        require("database_connection.php");

        $statement = $conn->prepare("select * from poi_users where username=?");

        $statement->execute([$_SESSION["user"]]);

        if($row=$statement->fetch()) {
            echo "<h1 class='wide'>Welcome ".$row["username"]."</h1>";
            echo "<form class='account wide' name='account' action='update_account.php' method='POST'>
                    <input type='hidden' name='old_username' value='".$row["username"]."' />
                    <label>
                        Username:
                        <input type='text' value='".$row["username"]."' required class='card' name='username' />
                    </label>
                    <label>
                        Password:
                        <input type='password' required class='card' name='password' />
                    </label>
                    <input type='submit' value='Update!' class='card'/>
                </form>";
        };
    }
    // Catch any exceptions (errors) thrown from the 'try' block
    catch(PDOException $e) {
        echo "Error: $e";
    };
?>
</div>
<?php

foot();
}

else {
    header("Location: sign_up.php");
}

?>