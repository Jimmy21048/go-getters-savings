<?php

if($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"];
    $email = $_POST["email"];
    $sent = $_POST["send"];
    // var_dump($username);
    // var_dump($email);

    try {

        require_once "dbh.inc.php";
        require_once "queries.php";

        approveUser($pdo, $username);

        require_once "mail.php";

        header("Location: admin.php");
    } catch(Exception $e) {
        echo "query failed" . $e->getMessage();
    }
} else {
    header("Location: index.php");
    die();
}