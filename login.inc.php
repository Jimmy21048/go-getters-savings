<?php
session_start();

if($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $messages = [];

    try {
        require_once "dbh.inc.php";
        require_once "queries.php";

        if(isUserAdmin($pdo, $username, $pwd)) {
            session_regenerate_id();
            $_SESSION["adminLogged"] = "true";
            header("Location: admin.php");
            die();
        }
        else if(isUserTreasurer($pdo, $username, $pwd)) {
            session_regenerate_id();
            $_SESSION["tresLogged"] = "true";
            header("Location: treasurer.php");
            die();
        }
        else if(isUserSignedUp($pdo, $username, $pwd) !== false) {
            $_SESSION["userLogged"] = "true";
            $_SESSION["userDetails"] = isUserSignedUp($pdo, $username, $pwd);
            header("Location: user.php");
            die();
        } else {
            header("Location: login.php");
            $messages["login-errors"] ="Incorrect username or password";
            $_SESSION["loginErrors"] =  $messages;
            die();
        }
        //to be continued

    } catch(Exception $e) {
        echo "query failed" . $e->getMessage();
    }
} else {
    header("Location: index.php");
    die();
}