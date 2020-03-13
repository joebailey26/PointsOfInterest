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
                        <p class='description'>".$row["description"]."</p>
                        <form class='recommend' onsubmit='return ajaxrequest_recommend(event)' >
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
                    <form class='wide' onsubmit='return ajaxrequest(event)' id='review_form'>
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

foot();
?>
<script>
    function ajaxrequest_recommend(event) {
        event.preventDefault()

        var xhr2 = new XMLHttpRequest();

        var a = document.getElementById("recommend_name").value;

        xhr2.addEventListener ("load", responseReceived_recommend);

        xhr2.open('POST', 'slim/recommend');

        xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr2.send('name=' + a);

        return false;
    }
    function responseReceived_recommend(e) {
        document.getElementsByClassName('recommend')[0].innerHTML = e.target.responseText;
    }

    function ajaxrequest(event) {
        event.preventDefault()
        // Create the XMLHttpRequest variable.
        // This variable represents the AJAX communication between client and
        // server.
        var xhr2 = new XMLHttpRequest();

        // Read the data from the form fields.
        var a = document.getElementById("review").value;
        var b = document.getElementById("poi_id").value;

        // Specify the CALLBACK function. 
        // When we get a response from the server, the callback function will run
        xhr2.addEventListener ("load", responseReceived);

        // Open the connection to the server
        // We are sending a request to "flights.php" in the same folder
        // and passing in the 
        // destination and date as a query string. 
        xhr2.open('POST', 'slim/add_review');

        xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        // Send the request.
        xhr2.send('review=' + a + '&poi_id=' + b);

        return false;
    }

    // The callback function
    // It simply places the response from the server in the div with the ID
    // of 'response'.

    // The parameter "e" contains the original XMLHttpRequest variable as
    // "e.target".
    // We get the actual response from the server as "e.target.responseText"
    function responseReceived(e) {
        document.getElementById('response').innerHTML = e.target.responseText;
    }
</script>