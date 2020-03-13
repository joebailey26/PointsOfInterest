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
                $id = $row["id"];
                $review = $row["review"];
                $statement_two = $conn->query("select * from pointsofinterest where ID=$id");

                while ($row=$statement_two->fetch()) {
                    echo "<article class='poi card wide single'>
                            <h3>".$row["name"]."</h3>
                            <p>$review</p>
                            <form id='response' onsubmit='return ajaxrequest(event)'>
                                <input type='hidden' value='$id' name='review_id' id='review_id'/>
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

        foot();
    ?>
    <script>
        function ajaxrequest(event) {
            event.preventDefault()

            var xhr2 = new XMLHttpRequest();

            var a = document.getElementById("review_id").value;

            xhr2.addEventListener ("load", responseReceived);

            xhr2.open('POST', 'slim/approve_review');

            xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr2.send('id=' + a);

            return false;
        }
        function responseReceived(e) {
            document.getElementById("response").innerHTML = e.target.responseText;
        }
    </script>
    <?php    
    }
    else {
        header("Location: login.php");	
    }
?>