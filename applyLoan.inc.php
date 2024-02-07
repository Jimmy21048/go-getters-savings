<?php
session_start();

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $loanAmount = $_POST["loan-amount"];
    $message=[];

    try {

        require_once "dbh.inc.php";
        require_once "queries.php";
        if($_SESSION["loanToReceive"] < $loanAmount) {
            $message["loan"] =  "You do not qualify for this amount!";
            $_SESSION["loanMessage"] = $message;
        }
        else {
            loanRequest($pdo, $username, $loanAmount);
            $message["loan"] = "Application succesful, Await approval";
            $_SESSION["loanMessage"] = $message;
        }


        header("Location: user.php");
        die();
    } catch(Exception $e) {
        echo "Query failed " . $e->getMessage();
    }

} else {
    header("Location: index.php");
    die();
}