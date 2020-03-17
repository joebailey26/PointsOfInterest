<?php 
require("functions.php");

head("Search");
?>
<script src="assets/js/main.js"></script>
<div class="container constrained">
<form class='wide' onsubmit="return search_yes(event)">
    <label>
        <h1 class="wide">Search by Region</h1>
        <input type="text" required name="search" id="search" class="card" placeholder="Region"/>
    </label>
    <input class="card" type="submit"/>
</form>
</div>
<div class="container" id="response"></div>
<?php foot(); ?>