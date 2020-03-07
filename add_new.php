<?php 

require("functions.php");

head("Add a new POI");

?>
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
        <p>Description:</p>
        <textarea class="card" type="text" required name="description" placeholder="Mos Eisley is a spaceport town, located on the planet Tatooine"></textarea>
    </label>
    <input class="card" type="submit" value="Submit">
</form>

<?php

foot();

?>