<?php
include('../config.php');
if (isset($_POST['email'])) {
    $email = htmlentities($_POST['email']);
    $query = "SELECT COUNT(email) AS many FROM voters WHERE BINARY email='$email'";
    $result = $pdo->prepare($query);
    $result->execute();
    $email = $result->fetch(PDO::FETCH_ASSOC);
    $emailCount = $email['many'];

    echo $emailCount;
}