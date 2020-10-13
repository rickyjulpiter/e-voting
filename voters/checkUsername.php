<?php
include('../config.php');
if (isset($_POST['username'])) {
    $username = htmlentities($_POST['username']);
    $query = "SELECT COUNT(username) AS many FROM voters WHERE BINARY username='$username'";
    $result = $pdo->prepare($query);
    $result->execute();
    $username = $result->fetch(PDO::FETCH_ASSOC);
    $usernameCount = $username['many'];

    echo $usernameCount;
}