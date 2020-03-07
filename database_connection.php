<?php
    require("vendor/autoload.php");
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $dotenv->required(['DATABASE_HOST', 'DATABASE_NAME', 'DATABASE_USER'])->notEmpty();

    $db_host = $_ENV['DATABASE_HOST'];
    $db_name = $_ENV['DATABASE_NAME'];
    $db_user = $_ENV['DATABASE_USER'];
    $db_pass = $_ENV['DATABASE_PASS'];

    // Connect to the database
    $conn = new PDO ("mysql:host=$db_host;dbname=$db_name;", $db_user, $db_pass);

    // Set up exception-based error handling
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>