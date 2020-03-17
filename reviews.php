<?php
    include("functions.php"); 

    function generateRandomString($length = 10) {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    if (isset($_SESSION["admin"])) {

        head("Reviews");

        // Try to do the following code. It might generate an exception (error)
        try {
            require("database_connection.php");

            $statement = $conn->query("SELECT * FROM poi_reviews WHERE approved=0");

            echo "<div class='container constrained'>";
        
            while ($row=$statement->fetch()) {
                $id = $row["poi_id"];
                $review = $row["review"];
                $statement_two = $conn->query("SELECT * FROM pointsofinterest WHERE ID=$id");

                while ($row_two=$statement_two->fetch()) {
                    $random = generateRandomString();
                    echo "<article class='poi card wide single'>
                            <h3>".$row_two["name"]."</h3>
                            <p>$review</p>
                            <form class='$random' onsubmit='return approval(event, \"$random\")'>
                                <input type='hidden' value='".$row["id"]."' name='review_id' class='review_id'/>
                                <input type='submit' value='Approve' class='card'/>
                            </form>
                        </article>";
                }
            }
            echo "</div>";
        }
        // Catch any exceptions (errors) thrown from the 'try' block
        catch(PDOException $e) {
            echo "Error: $e";
        };
    ?>
        <script src="assets/js/main.js"></script>
    <?php
        foot();
    }
    else {
        header("Location: login.php");	
    }
?>