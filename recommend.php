<?php

if (ctype_digit(trim(str_replace(' ','',$_POST["value"]))) && ctype_alnum(trim(str_replace(' ','',$_POST["name"])))) {

    $name = $_POST["name"];

    // Try to do the following code. It might generate an exception (error)
    try {
        require("database_connection.php");

        $statement = $conn->prepare("SELECT * from pointsofinterest WHERE name=?");

        $statement->execute([$name]);

        if($row=$statement->fetch()) {
            $recommended = $row["recommended"] + 1;
        };

        // Send an SQL query to the database server
        $statement_two = $conn->prepare("UPDATE pointsofinterest SET recommended=? WHERE name=?" );

        $statement_two->execute([$recommended, $name]);

        return "&check;";
    }
    // Catch any exceptions (errors) thrown from the 'try' block
    catch(PDOException $e) {
        return "Error: $e";
    };
}
else {
    return null;
}

?>