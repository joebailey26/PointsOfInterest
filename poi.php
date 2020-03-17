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
                        <h1 class='title'>$name</h1>
                        <p class='type'>".$row["type"]."</p>
                        <p class='region'>".$row["region"]."</p>
                        <p class='description'>".$row["description"]."</p>
                        <form class='recommend' onsubmit='return recommend(event)' >
                            <input name='name' id='recommend_name' type='hidden' value='$name' />
                            <input type='submit' value='+' title='Recommend Me'/>
                        </form>
                    </article>
                </div>";

            $poi_id = $row["ID"];

            // Send an SQL query to the database server
            $statement_two = $conn->query("SELECT * FROM poi_reviews WHERE poi_id=$poi_id AND approved=1" );

            if(!$statement_two->fetch()) {
                echo "<div class='container constrained'><h2 class='wide'>No Reviews found. Add one below...</h2></div>";
            }
            else {
                echo "<div class='container constrained'><h2 class='wide'>Reviews</h2>";
                while($row=$statement_two->fetch()) {
                        echo "<article class='poi card wide single'>
                                    <p>".$row["review"]."</p>
                                </article>";
                };  
                echo "</div>";
            };
            echo "<div class='container constrained' id='response'>
                    <form class='wide' onsubmit='return add_review(event)' id='review_form'>
                        <label>
                            <h2 class='wide'>Add Review:</h2>
                            <input type='hidden' value='$poi_id' name='poi_id' id='poi_id'/>
                            <textarea type='text' placeholder='This is an epic place' required class='card' name='review' id='review' required></textarea>
                        </label>
                        <input type='submit' value='Submit!' class='card'/>
                    </form>
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
?>
<script src="assets/js/main.js"></script>
<?php foot(); ?>