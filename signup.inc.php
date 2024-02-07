<?php
    session_start();

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = $_POST["username"];
        $pwd = $_POST["pwd"];
        $email = $_POST["mail"];
        $messages = [];

        try {
            require_once "dbh.inc.php";
            require_once "queries.php";

            if(strlen($username) < 5) {
                $messages["shortUname"] = "Username must be 5 characters or more!";
            }
            if(!isUsernameAvailable($pdo,$username) && strlen($username) > 5) {
                $messages["unameTaken"] = "Username taken, choose another!";
            }
            if(strlen($pwd) < 5) {
                $messages["shortPwd"] = "Password must be 5 characters or more!";
            }
            if(!isEmailValid($email)) {
                $messages["invalidEmail"] = "Invalid Email!";
            }   
            if(strlen($username) < 5 || !isUsernameAvailable($pdo,$username) || strlen($pwd) < 5 || !isEmailValid($email)) {
                $_SESSION["signupErrors"] = $messages;
                header("Location: signup.php");
                die();
            }
 

            // $myMsg = "this is my message";
            // mail("rubiajimmy3@gmail.com","registration",$myMsg);

            //Inserting credentials to database
            //1. hashing password
            $options = [
                'cost' => 12
            ];
            $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

            //2. into db
            insertUser($pdo, $username, $hashedPwd, $email);

            // die();
            $pdo = null;
            $stmt = null;
            
        } catch(Exception $e) {
            echo "Query failed" . $e->getMessage();
        }
    } else {
        header("Location: index.php");
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>SIGN UP</title>
</head>
<body>
    <header class="hero-header">
        <h3>GO GETTERS!</h3>
    </header>
    <hr>

    <div class="signup-body">
        <h1 style="color:green;">SIGN UP SUCCESS</h1>
        <h3 style="color:green;">Wait for admin approval</h3>
        <a href="index.php">Home</a>
    </div>
</body>
</html>
