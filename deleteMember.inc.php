<?php

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $username = $_POST["username"];

    try {

        require_once "dbh.inc.php";
        require_once "queries.php";

        deleteUser($pdo, $username, $email); 
        header("Location: admin.php");
        die();
    } catch(Exception $e) {
        echo "query failed" . $e->getMessage();
    }
} else {
    header("Location: index.php");
    die();
}