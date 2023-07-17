<?php 

$hostname = "localhost";
$username = "xmatuskam3";
$password = "sAuXa5s97E0zWhT";
$dbname = "oh";

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>