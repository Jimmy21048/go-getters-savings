<?php

try {
    $pdo = new PDO("mysql:host=mysql-2ce69f8a-chama-website.a.aivencloud.com:21347;dbname=defaultdb","avnadmin","AVNS_J1i6I5BGSua5t7i70Qw");
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed" . $e->getMessage();
}

//try {
//    $pdo = new PDO("mysql:host=localhost:3308;dbname=gogetters","root","");
//    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//} catch(PDOException $e) {
//    echo "Connection failed" . $e->getMessage();
//}