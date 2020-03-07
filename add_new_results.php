<?php 

require("functions.php");

head("Add a new POI");

if (ctype_alnum(trim(str_replace(' ','',$_POST["name"]))) && ctype_alnum(trim(str_replace(' ','',$_POST["type"]))) && ctype_alnum(trim(str_replace(' ','',$_POST["description"])))) {

    $name = $_POST["name"];
    $type = $_POST["type"];
    $description = $_POST["description"];

    // Try to do the following code. It might generate an exception (error)
    try {
        require("database_connection.php");

        // Send an SQL query to the database server
        $statement = $conn->prepare("insert into pointsofinterest (name, type, description) values (?, ?, ?)" );

        $statement->execute([$name, $type, $description]);

        echo "<h1 class='wide'>POI added successfully</h1>";
        
        echo "<a href='poi.php?title=$name' class='poi card wide'>
                <article>
                    <h3 class='title'>$name</h3>
                    <p class='type'>$type</p>
                    <p class='description'>$description</p>
                </article>
            </a>";
        echo "<h3  class='wide'><a href='add_new.php'>Go back</a></h3>";
    }
    // Catch any exceptions (errors) thrown from the 'try' block
    catch(PDOException $e) {
        echo "Error: $e";
    };
}
else {
    echo "<h1 class='wide'>We only allow letters, numbers, and spaces in our fields</h1>";
    echo "<h3 class='wide'><a href='add_new.php'>Go back</a></h3>";
}

foot();

?>