<?php
//establish connection to B2W database 
try {
    $pdo = new PDO("mysql:host=localhost;dbname=B2W", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>