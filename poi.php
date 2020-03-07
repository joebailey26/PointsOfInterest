<?php 

require("functions.php");

if (ctype_alnum(trim(str_replace(' ','',$_GET["name"])))) {

    $name = $_GET["name"];

    // Try to do the following code. It might generate an exception (error)
    try {
        require("database_connection.php");

        // Send an SQL query to the database server
        $statement = $conn->prepare("select * from pointsofinterest where name=?" );

        $statement->execute([$name]);

        if($row=$statement->fetch()) {
            head($name);
            echo "<div class='container constrained'>
                <article class='poi card wide single'>
                    <h1 class='title'>$name</h3>
                    <p class='type'>".$row["type"]."</p>
                    <div class='location'>
                        <p class='region'>".$row["region"]."</p>
                        <p class='seperator'>, </p>
                        <p class='country'>".$row["country"]."</p>
                    </div>
                    <p class='description'>".$row["description"]."</p>
                </article>
            </div>";
        }
        else {
            head("");
            echo "<div class='container constrained'><h1 class='wide'>Incorrect POI name</h1></div>";
        }
    }
    // Catch any exceptions (errors) thrown from the 'try' block
    catch(PDOException $e) {
        echo "Error: $e";
    };
}
else {
    head("");
    echo "<div class='container constrained'><h1 class='wide'>Incorrect POI name</h1></div>";
}

foot();

?>