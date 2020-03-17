<?php 

require("functions.php");

if (isset($_SESSION["user"])) {

    head("Add a new POI");

?>
<div class="container constrained">
    <h1  class="wide">Add a new POI</h1>
    <form class="add_new wide" name="add_new" action="add_new_results.php" method="post">
        <label>
            <p>Name:</p>
            <input class="card" type="text" required name="name" placeholder="Mos Eisley"/>
        </label>
        <label>
            <p>Type:</p>
            <input class="card" type="text" required name="type" placeholder="City"/>
        </label>
        <label>
            <p>Region:</p>
            <input class="card" type="text" required name="region" placeholder="Outer Rim"/>
        </label>
        <label>
            <p>Description:</p>
            <textarea class="card" type="text" required name="description" placeholder="Mos Eisley is a spaceport town, located on the planet Tatooine"></textarea>
        </label>
        <input class="card" type="submit" value="Submit">
    </form>
</div>
<?php

foot();
}	

else {	
    header("Location: sign_up.php?ref=add_new");	
}
?>