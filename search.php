<?php 
require("functions.php");

head("Search");
?>
<div class="container constrained">
<form class='wide' onsubmit="return ajaxrequest(event)">
    <label>
        <h1 class="wide">Search by Region</h1>
        <input type="text" required name="search" id="search" class="card" placeholder="Region"/>
    </label>
    <input class="card" type="submit"/>
</form>
</div>
<div class="container" id="response"></div>
<?php
foot();
?>
<script>
    function ajaxrequest(event) {
        event.preventDefault()
        // Create the XMLHttpRequest variable.
        // This variable represents the AJAX communication between client and
        // server.
        var xhr2 = new XMLHttpRequest();

        // Read the data from the form fields.
        var a = document.getElementById("search").value;

        // Specify the CALLBACK function. 
        // When we get a response from the server, the callback function will run
        xhr2.addEventListener ("load", responseReceived);

        // Open the connection to the server
        // We are sending a request to "flights.php" in the same folder
        // and passing in the 
        // destination and date as a query string. 
        xhr2.open('GET', 'json_connect.php?search=' + a);

        // Send the request.
        xhr2.send();

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