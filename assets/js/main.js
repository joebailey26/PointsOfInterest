function add_review(event) {
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

function recommend(event) {
    event.preventDefault()

    var xhr2 = new XMLHttpRequest();

    var a = document.getElementById("recommend_name").value;

    xhr2.addEventListener ("load", responseReceived_recommend);

    xhr2.open('POST', 'slim/recommend');

    xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr2.send('name=' + a);

    return false;
}

function approval(e, id) {
    function responseReceived_approval(e) {
        doc.innerHTML = e.target.responseText;
    }

    e.preventDefault()

    var xhr2 = new XMLHttpRequest();

    var a = document.querySelector("." + id + " .review_id").value;

    var doc = document.querySelector('.' + id)
    
    xhr2.addEventListener ("load", responseReceived_approval);

    xhr2.open('POST', 'slim/approve_review');

    xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr2.send('id=' + a);

    return false;
}

function search_yes(event) {
    event.preventDefault()

    var xhr2 = new XMLHttpRequest();

    var a = document.getElementById("search").value;

    xhr2.addEventListener ("load", responseReceived);

    xhr2.open('GET', 'json_connect.php?search=' + a);

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

function responseReceived_recommend(e) {
    document.getElementsByClassName('recommend')[0].innerHTML = e.target.responseText;
}