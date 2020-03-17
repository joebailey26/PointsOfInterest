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

$app->post('/add_review', function (Request $req, Response $res) use($conn) {
    $post = $req->getParsedBody();

    if (ctype_alnum(trim(str_replace(' ','',$post["review"])))) {
        $check = $conn->prepare("SELECT * FROM pointsofinterest WHERE ID=?");
        $check->execute([$post["poi_id"]]);

        if ($row=$check->fetch()) {
            $stmt = $conn->prepare("INSERT INTO poi_reviews (review, poi_id, approved) VALUES (?, ?, 0)");
            $stmt->execute([$post["review"], $post["poi_id"]]);

            $res->getBody()->write("<p class='wide'>Review added successfuly. Please wait for it to be approved.</p>");
        }
        else {
            $res->getBody()->write("<p class='wide'>Something went wrong please try again.</p>");
        };
    }
    else {
        $res->getBody()->write("<p class='wide'>We only allow letters, numbers, and spaces. Please try again.</p>");
    }
    
    return $res;
});

$app->post('/recommend', function (Request $req, Response $res) use($conn) {
    $post = $req->getParsedBody();

    $statement = $conn->prepare("SELECT * FROM pointsofinterest WHERE name=?");

    $statement->execute([$post["name"]]);

    if($row=$statement->fetch()) {
        $recommended = $row["recommended"] + 1;
    };

    // Send an SQL query to the database server
    $statement_two = $conn->prepare("UPDATE pointsofinterest SET recommended=$recommended WHERE name=?" );

    $statement_two->execute([$post["name"]]);


    $res->getBody()->write("<input disabled type='submit' value='&check;' title='Recommend Me'>");
    return $res;
});

$app->post('/approve_review', function (Request $req, Response $res) use($conn) {
    $post = $req->getParsedBody();

    $stmt = $conn->prepare("UPDATE poi_reviews SET approved=1 WHERE id=?");
    $stmt->execute([$post["id"]]);

    $res->getBody()->write("<input type='submit' value='Approved' disabled class='card'/>");
    
    return $res;
});

$app->get('/search', function (Request $req, Response $res, array $args) use($conn) {
    $stmt = $conn->prepare("SELECT * FROM pointsofinterest");
    $stmt->execute([$args["search"]]);

    $response = array();

    while($row=$stmt->fetch()) {
        array_push($response, $row["name"]);
    };
    
    return $res->withJson($response);
});

$app->get('/search/{search}', function (Request $req, Response $res, array $args) use($conn) {
    $stmt = $conn->prepare("SELECT * FROM pointsofinterest WHERE region=?");
    $stmt->execute([$args["search"]]);

    $response = array();

    while($row=$stmt->fetch()) {
        $response[] = $row;
    };

    return $res->withJson($response);
});

$app->run();