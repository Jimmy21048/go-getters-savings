<?php

session_start();
// isset($_SESSION["adminLogged"]) ? $set = $_SESSION["adminLogged"] : $set = null;
// unset($_SESSION["adminLogged"]);
if(isset($_SESSION["adminLogged"])) {

    try {

        require_once "dbh.inc.php";
        require_once "queries.php";

        $unRegistered = toBeApprovedUsers($pdo);
        $registered = approvedUsers($pdo);
    } catch(Exception $e) {
        echo "query failed" . $e->getMessage();
    }

}else {
    header("Location: login.php");
    die();
}
// unset($_SESSION["adminLogged"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>administrator</title>
</head>
<body>
    <header class="hero-header">
        <h3>GO GETTERS!</h3>
        <a href="index.php">HOME</a>
    </header>
    <hr>

    <div class="admin-body">
        <div class="left">
            <h3>APPROVE USERS</h3>
                    <?php
                    foreach($unRegistered as $user) {
                        $myUser = $user["username"];
                        $myEmail = $user["email"];
                        echo "<div> <form class='form1' action='approveUser.inc.php' method='post' >
                                        <input type='text' name='username' value=" . $myUser . "  >
                                        <input type='text' name='email' value=" . $myEmail . "  >
                                        <button name='send'>approve</button>
                                    </form> 
                              </div>";
                    }
                    ?>
        </div>
        <div class="right">
            <h3>MEMBERS</h3>
            <?php
            echo "<table>
            <thead>
            <tr>
                <th>username</th>
                <th>project</th>

            </tr>
        </thead>
        <tbody>";
        $arrLen = count($registered);
        foreach($registered as $user) {
            // var_dump(count($registered));
            
            $myUser = $user["username"];
            $myEmail = $user["email"];
            echo "<div> <form class='form1' action='deleteMember.inc.php' method='post'>
            <tr>
            <td>
                <input id='name1' type='text' name='username' value=" . $myUser . "  >
            </td>
            <td>
                <input id='email1' type='text' name='email' value=" . $myEmail . " >
            </td>
            <td>
                <button>delete</button>
            </td>
            </tr>
            </form> 
            </div>";
        }
        echo "</tbody>";
                    ?>  
        </div>
    </div>

    <script>


        // function handleDelete(mail) {
        //     let myName = document.getElementById("name1");


        //     if(!confirm("Delete")) {
        //         let myEmail = document.getElementById("email1");
        //         console.log(mail);
        //         console.log(myEmail.value);
        //             myName.value = '';
        //             myEmail.value='';

        //     }
        // }
    </script>
</body>
</html>