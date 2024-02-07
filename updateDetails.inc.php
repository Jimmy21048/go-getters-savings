<?php

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $addSaving = $_POST["add-savings"];
    $addFunds = $_POST["add-funds"];
    $username = $_POST["username"];

    try {

        require_once "dbh.inc.php";
        require_once "queries.php";

        updateUserMoney($pdo,$username,$addSaving, $addFunds);

        header("Location: treasurer.php");
        die();
        
    } catch(Exception $e) {
        echo "query failed" . $e->getMessage();
    }
} else {
    header("Location: index.php");
    die();
}