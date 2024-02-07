<?php

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $amount = $_POST["amount"];

    try {

        require_once "dbh.inc.php";
        require_once "queries.php";

        releaseLoan($pdo, $username);
        header("Location: treasurer.php");
        die();
    } catch(Exception $e) {
        echo "Query failed " . $e->getMessage();
    }

} else {
    header("Location: index.php");
    die();
}