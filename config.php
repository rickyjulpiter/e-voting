<?php

// $host = "localhost";
// $username = "root";
// $password = "";
// $database = "e-voting";

// sistempintar server
$host = "localhost";
$username = "u9070309_e-vote";
$password = "A%xz*yep]lc8";
$database = "u9070309_e-vote";

$pdo = new PDO('mysql:host=' . $host . ';dbname=' . $database, $username, $password);

try {
    $pdo = new PDO('mysql:host=' . $host . ';dbname=' . $database, $username, $password);
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}

include 'function.php';