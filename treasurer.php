<?php
    session_start();

    if(isset($_SESSION["tresLogged"])) {

        try {

            require_once "dbh.inc.php";
            require_once "queries.php";

            $userMoney = userMoney($pdo);
            $requestedLoans = requestedLoans($pdo);
            $approvedLoans = approvedLoans($pdo);
        } catch(Exception $e) {
            echo "query failed" . $e->getMessage(); 
        }

    } else {
        header("Location: login.php");
        die();
    }
    // unset($_SESSION["tresLogged"]);
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Treasurer</title>
</head>
<body>
    <header class="hero-header">
        <h3>GO GETTERS!</h3>
        <a href="index.php">HOME</a>
    </header>
    <hr>

    <div class="tres-body">
        <div class="left leftTwo">
        <?php
            echo "<table>
            <thead>
            <tr>
                <th>username</th>
                <th>project</th>
                <th>savings</th>
                <th>E funds</th>
                <th>Add saving</th>
                <th>Add efund</th>

            </tr>
        </thead>
        <tbody>";
        
        foreach($userMoney as $user) {
            // var_dump(count($registered));
            
            $myUser = $user["username"];
            $myProject = $user["project"];
            $mySavings = $user["savings"];
            $myEfunds = $user["efunds"];
            $myAddSavings = $user["addSavings"];
            $myAddFunds = $user["addEfunds"];
            echo "<tr> <form class='form2' action='updateDetails.inc.php' method='post'>
            
            <td>
                <input type='text' name='username' value=" . $myUser . "  >
            </td>
            <td>
                <input type='number' name='project' value=" . $myProject . " disabled>
            </td>
            <td>
                <input type='number' name='savings' value=" . $mySavings . " disabled>
            </td>
            <td>
                <input type='number' name='efunds' value=" . $myEfunds . " disabled>
            </td>
            <td>
                <input type='number' name='add-savings' value=" . $myAddSavings . " >
            </td>
            <td>
                <input type='number' name='add-funds' value=" . $myAddFunds . " >
            </td>
            <td>
                <button>UPDATE</button>
            </td>
            </form> 
            </tr>";
        }
        echo "</tbody></table>";
                    ?>
        </div>

        <div class="right">
            <h2>LOANS REQUESTED</h2>
            <table>
                <thead>
                    <tr>
                        <th>USERNAME</th>
                        <th>REQUEST</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($requestedLoans as $rst) {
                            echo "<tr>
                                    <form action='approveLoan.inc.php' method='post'>
                                        <td> <input type='text' name='username' value=" . $rst["username"] . "></td>
                                        <td> <input type='number' name='amount' value=" . $rst["loanRequest"] . "></td>
                                        <td> <button>Approve</button> </td>
                                    </form>
                                </tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="right">
            <h2>LOAN DEBTS</h2>
            <table>
                <thead>
                    <tr>
                        <th>USERNAME</th>
                        <th>DEBT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($approvedLoans as $rst) {
                            echo "<tr>
                                    <form action='releaseLoan.inc.php' method='post'>
                                        <td> <input type='text' name='username' value=" . $rst["username"] . "></td>
                                        <td> <input type='number' name='amount' value=" . $rst["loanGiven"] . "></td>
                                        <td> <button>Release</button> </td>
                                    </form>
                                </tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>