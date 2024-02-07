<?php
//user signup
function isUsernameAvailable($pdo,$username) {
    $query = "SELECT username FROM getters WHERE username=:uname;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":uname",$username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result === false) {
        return true;
    } else {
        return false;
    }
    
}

function isEmailValid($email) {
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function insertUser($pdo, $username, $pwd, $email) {
    $query = "INSERT INTO getters (username, pwd, email) VALUES (:uname, :pwd, :email);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":uname",$username);
    $stmt->bindParam(":pwd",$pwd);
    $stmt->bindParam(":email",$email);
    $stmt->execute();

}
//user signup

//user login
    //admin
function isUserAdmin($pdo, $username, $pwd) {
    $query = "SELECT username, pwd FROM heads WHERE username='admin' AND pwd = :pwd;";
    $stmt = $pdo->prepare($query);
    // $stmt->bindParam(":uname",$username);
    $stmt->bindParam(":pwd",$pwd);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($result !== false) {
        return true;
    } else {
        return false;
    }
}
    //treasurer
function isUserTreasurer($pdo, $username, $pwd) {
    $query = "SELECT username, pwd FROM heads WHERE username='treasurer' AND pwd = :pwd;";
    $stmt = $pdo->prepare($query);
    // $stmt->bindParam(":uname",$username);
    $stmt->bindParam(":pwd",$pwd);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($result !== false) {
        return true;
    } else {
        return false;
    }
}
    //user
 function isUserSignedUp($pdo, $username, $pwd) {
        $query = "SELECT username, pwd, approved FROM getters WHERE username= :uname;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":uname",$username);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $myPwd = password_verify($pwd, $result["pwd"]);
        // var_dump($result);

        if(password_verify($pwd, $result["pwd"]) && $result["approved"] === 1) {
            $query = "SELECT username, email, project, savings, efunds,loanGiven FROM getters WHERE username= :uname;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":uname",$username);
            $stmt->execute();
    
            $result1 = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result1;
        } else {
            return false;
        }
    }

//user login

//totalUsers
function totalSavings($pdo) {
    $query = "SELECT SUM(savings) AS 'TOTAL SAVINGS' FROM getters;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}
function totalFunds($pdo) {
    $query = "SELECT SUM(efunds) AS 'TOTAL FUNDS' FROM getters;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}
function totalProject($pdo) {
    $query = "SELECT SUM(project) AS 'TOTAL PROJECT' FROM getters;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}
function sumLoans($pdo) {
    $query = "SELECT SUM(loanGiven) AS 'TOTAL LOANS' FROM getters;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

//admin page
function toBeApprovedUsers($pdo) {
    $query = "SELECT username, email FROM getters WHERE approved = 0;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function approveUser($pdo,$username) {
    $query = "UPDATE getters SET approved = 1 WHERE username = :uname;";
    $stmt = $pdo->prepare($query); 
    $stmt->bindParam(":uname",$username);
    $stmt->execute();
}

function approvedUsers($pdo) {
    $query = "SELECT username, email FROM getters WHERE approved = 1;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
function deleteUser($pdo, $username, $email) {
    $query = "DELETE FROM getters WHERE username=:uname AND email=:email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":uname",$username);
    $stmt->bindParam(":email",$email);
    $stmt->execute();
}

//treasurer page

function userMoney($pdo) {
    $query = "SELECT username, project, savings, efunds, addSavings, addEfunds FROM getters WHERE approved = 1;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function updateUserMoney($pdo, $username, $s,$f) {
    $query = "UPDATE getters SET savings = savings +:s, efunds = efunds +:f WHERE username = :uname;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":s",$s);
    $stmt->bindParam(":f",$f);
    $stmt->bindParam(":uname",$username);
    $stmt->execute();
}

//loans 

function loanRequest($pdo, $username, $amt) {
    $query = "UPDATE getters SET loanRequest = :amt WHERE username = :uname;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":uname",$username);
    $stmt->bindParam(":amt",$amt);
    $stmt->execute();
}

function requestedLoans($pdo) {
    $query = "SELECT username, loanRequest FROM getters WHERE loanRequest >0;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function approveLoan($pdo, $uname, $amt) {
    $query = "UPDATE getters SET loanGiven = :amt, loanRequest = 0 WHERE username = :uname;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":uname",$uname);
    $stmt->bindParam(":amt",$amt);
    $stmt->execute();
}
function approvedLoans($pdo) {
    $query = "SELECT username, loanGiven FROM getters WHERE loanGiven >0;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
function releaseLoan($pdo, $uname) {
    $query = "UPDATE getters SET loanGiven = 0 WHERE username = :uname;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":uname",$uname);
    $stmt->execute();
}


