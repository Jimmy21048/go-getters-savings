<?php
session_start();
// var_dump($_SESSION["userDetails"]);
if(isset($_SESSION["userLogged"])) {
    

    try {

        require_once "dbh.inc.php";
        require_once "queries.php";

        isset($_SESSION["userDetails"]) ? $details = $_SESSION["userDetails"] : $details = [];
        isset($_SESSION["loanMessage"]) ? $loanMessage = $_SESSION["loanMessage"] : $loanMessage = [];
        // unset($_SESSION["userDetails"]);
        unset($_SESSION["loanMessage"]);

        $totalSavings = totalSavings($pdo);
        $totalFunds = totalFunds($pdo);
        $totalProject = totalProject($pdo);
        $totalLoans = sumLoans($pdo);

        if($details["loanGiven"] > 0 || $totalLoans["TOTAL LOANS"] > $totalProject["TOTAL PROJECT"]) {
            $myLoan = 0;
        } else {
            $myLoan = (($details["savings"]+$details["project"])/2)
             < ($totalProject["TOTAL PROJECT"] - $totalLoans["TOTAL LOANS"]) 
             ? (($details["savings"]+$details["project"])/2) 
             : ($totalProject["TOTAL PROJECT"] - $totalLoans["TOTAL LOANS"]);
        }

        if($totalFunds["TOTAL FUNDS"] <1) {
            $fundsHeight = 0;
        } else {
            $fundsHeight =($details["efunds"]/$totalFunds["TOTAL FUNDS"])*100;
        }
        
        if($totalSavings["TOTAL SAVINGS"] <1) {
            $savingsHeight = 0;
        } else {
            $savingsHeight =($details["savings"]/$totalSavings["TOTAL SAVINGS"])*100;
        }
        if($totalProject["TOTAL PROJECT"] <1) {
            $projectHeight = 0;
            $myLoanP = 0;
        } else {
            $projectHeight =($details["project"]/$totalProject["TOTAL PROJECT"])*100;
            $myLoanP = ($myLoan/$totalProject["TOTAL PROJECT"])*100;
        }
        
        $_SESSION["loanToReceive"] = $myLoan;

    } catch(Exception $e) {
        echo "query failed" . $e->getMessage(); 
    }

} else {
    header("Location: login.php");
    die();
}


// unset($_SESSION["userDetails"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>user</title>
</head>
<body>
    <header class="hero-header">
        <div class="user-names">
                <?php echo strtoupper($details["username"][0]); ?>
        </div>
        <a href="index.php">HOME</a>
    </header>
    <hr>

    <div class="account-body">
        <div class="acc-left">

            <div class="account-username">
                <p class="acc-title">USERNAME</p>
                <p class="acc-content"><?php echo $details["username"]; ?></p>
            </div>
            <div class="account-username">
                <p class="acc-title">PROJECT</p>
                <p class="acc-content"><?php echo  $details["project"] ;?></p>
            </div>
            <div class="account-username">
                <p class="acc-title">YOUR SAVINGS</p>
                <p class="acc-content"><?php echo $details["savings"]; ?></p>
            </div>
            <div class="account-username">
                <p class="acc-title">GROUP SAVINGS</p>
                <p class="acc-content"><?php echo $totalSavings["TOTAL SAVINGS"]; ?></p>
            </div>
            <div class="account-username">
                <p class="acc-title">YOUR EMERGENCY FUNDS</p>
                <p class="acc-content"><?php echo $details["efunds"]; ?></p>
            </div>
            <div class="account-username">
                <p class="acc-title">GROUP E FUNDS</p>
                <p class="acc-content"><?php echo $totalFunds["TOTAL FUNDS"]; ?></p>
            </div>
            <div class="account-username">
                <p class="acc-title">AVAILABLE LOAN</p>
                <p class="acc-content"><?php echo $myLoan; ?></p>
            </div>
            <div class="account-username">
                <p class="acc-title">LOAN YOU OWE</p>
                <p class="acc-content"><?php echo $details["loanGiven"]; ?></p>
            </div>
        </div>

        <form action="applyLoan.inc.php" method="post" id="loan-form" >
                <h3>Apply Loan</h3>
                <input hidden type="text" name="username" value="<?php echo $details["username"] ;?>">
                <input type="number" name="loan-amount" placeholder="Enter amount...">
                <button name="loan-btn" value="SUBMIT APPLICATION" onclick="handleRefresh()" >SUBMIT APPLICATION</button>
                <p>
                    <?php
                        foreach($loanMessage as $msg) {
                            echo $msg;
                        }
                    ?>
                </p>
        </form>

        <div class="acc-right">
            <div id="acc-savings"><?php echo "<p>".$details["savings"] ."/".$totalSavings["TOTAL SAVINGS"]."Ksh</p>" ;?> <p>SAVINGS</p></div>
            <div id="acc-funds"><?php echo "<p>".$details["efunds"] ."/".$totalFunds["TOTAL FUNDS"]."Ksh</p>" ;?> <p>E FUNDS</p></div>
            <div id="acc-project"><?php echo "<p>".$details["project"] ."/".$totalProject["TOTAL PROJECT"]."Ksh</p>" ;?> <p>PROJECT</p></div>
            <div id="acc-loan"><?php echo "<p>". $myLoan ."Ksh</p>" ;?> <p>LOAN</p></div>

        </div>
    </div>

    <script>

        let accSavings = document.getElementById("acc-savings");
        let accFunds = document.getElementById("acc-funds");
        let accProject = document.getElementById("acc-project");
        let accLoan = document.getElementById("acc-loan");


        accSavings.style.height = "<?php echo $savingsHeight ;?>%";
        accFunds.style.height = "<?php echo $fundsHeight ;?>%";
        accProject.style.height = `<?php echo $projectHeight ;?>%`;
        accLoan.style.height = `<?php echo  $myLoanP;?>%`;

        function handleRefresh() {
            location.reload();
        }
    </script>
</body>
</html>