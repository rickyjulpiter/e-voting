<?php
include('template/head.php');
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    if (strlen($username) >= 8) {
        $query = "SELECT COUNT(username) AS status FROM voters WHERE BINARY username='$username'";
        $result = $pdo->prepare($query);
        $result->execute();
        $username = $result->fetch(PDO::FETCH_ASSOC);
        echo json_encode($username['status']);
    } else {
        echo json_encode("1");
    }
}