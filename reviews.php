<?php
    include("functions.php"); 

    if (isset($_SESSION["admin"])) {

        head("Reviews");

        // Try to do the following code. It might generate an exception (error)
        try {
            require("database_connection.php");

            $statement = $conn->query("select * from poi_reviews where approved=0");

            echo "<div class='container constrained'>";
        
            while ($row=$statement->fetch()) {
                echo "<article class='poi card wide single'>
                        <p>".$row["review"]."</p>
                        <form action='reviews_results.php' method='POST'>
                            <input type='hidden' value='".$row["id"]."' name='review_id'/>
                            <input type='submit' value='Approve'/>
                        </form>
                    </article>";
            }
            echo "</div>";
        }
        // Catch any exceptions (errors) thrown from the 'try' block
        catch(PDOException $e) {
            echo "Error: $e";
        };

        foot();
    }
    else {
        header("Location: login.php");	
    }
?>