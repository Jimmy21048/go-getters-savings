<?php
session_start();

isset($_SESSION["loginErrors"]) ? $errors = $_SESSION["loginErrors"] : $errors = [];

unset($_SESSION["loginErrors"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>login</title>
</head>
<body>
    <header class="hero-header">
        <h3>GO GETTERS!</h3>
        <a href="index.php">HOME</a>
    </header>
    <hr>

    <div class="signup-body">
        <h3>LOG IN</h3>
        <form action="login.inc.php" method="post">
            <input type="text" name="username" placeholder="Enter username..." >
            <input type="password" name="pwd" placeholder="Enter password..." >
            <button>LOG IN</button>

            <p>Don't have an account? <a href="signup.php">SIGN UP</a></p>
        </form>
        <ol class="error-list">
        <?php
        
            foreach($errors as $msg) {
                echo "<li>*" . $msg . "</li>";
            }
        ?>
        </ol>
    </div>
</body>
</html>