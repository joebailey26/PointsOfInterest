<?php
require('database_connection.php');


// Import classes from the Psr library (standardised HTTP requests and responses)
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Factory\AppFactory;

// Create our app.
$app = AppFactory::create();

// Add routing functionality to Slim. This is not included by default and
// must be turned on.
$app->addRoutingMiddleware();

// Add error handling functionality. The three 'true's indicate:
// - first argument: display full error details
// - second argument: call Slim error handler
// - third argument: log error details

$app->addErrorMiddleware(true, true, true);
 
// For the routes to work correctly, you must set your base path.
// This is the relative path of your webspace on the server, including the
// folder you're using but NOT public_html. Here we are assuming the Slim app
// is saved in the 'slimapp' folder within 'public_html' 
$app->setBasePath('/~assign217/slim');

// Create our PHP renderer object
$view = new \Slim\Views\PhpRenderer('views');

$app->get('/add_review', function (Request $req, Response $res, array $args) use($conn) {
    $stmt = $conn->prepare("INSERT INTO poi_reviews (review, poi_id, approved) VALUES (?, ?, 0)");
    $stmt->execute([$args["review"], $args["poi_review"]]);

    $res->getBody()->write("<p class='wide'>Review added successfuly. Please wait for it to be approved.</p>");
    return $res;
});

$app->get('/recommend', function (Request $req, Response $res, array $args) use($conn) {
    $statement = $conn->prepare("SELECT * from pointsofinterest WHERE name=?");

    $statement->execute([$args["name"]]);

    if($row=$statement->fetch()) {
        $recommended = $row["recommended"] + 1;
    };

    // Send an SQL query to the database server
    $statement_two = $conn->prepare("UPDATE pointsofinterest SET recommended=? WHERE name=?" );

    $statement_two->execute([$recommended, $args["name"]]);


    $res->getBody()->write("<input disabled type='submit' value='&check;' title='Recommend Me'>");
    return $res;
});

$app->run();