<?php
session_start();

isset($_SESSION["signupErrors"]) ? $errors = $_SESSION["signupErrors"] : $errors = [];

unset($_SESSION["signupErrors"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>signup</title>
</head>
<body>
    <header class="hero-header">
        <h3>GO GETTERS!</h3>
        <a href="index.php">HOME</a>
    </header>
    <hr>

    <div class="signup-body">
        <h3>SIGN UP</h3>
        <form action="signup.inc.php" method="post" >
            <input type="text" name="username" placeholder="Enter username..." >
            <input type="password" name="pwd" placeholder="Enter password..." >
            <input type="email" name="mail" placeholder="Enter email..." >
            <button>SIGN UP</button>

            <p>Already have an account? <a href="login.php">LOG IN</a></p>
        </form>
        <ol class="error-list" >
        <?php
        
            foreach($errors as $msg) {
                echo "<li>*" . $msg . "</li>";
            }
        ?>
        </ol>
    </div>
</body>
</html>
