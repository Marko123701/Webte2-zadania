<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');

//Venza
// URL of the website to download HTML source code from
$url = 'https://www.novavenza.sk/tyzdenne-menu';
$ch = curl_init();

// Set the URL and other options for cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Execute the cURL session and fetch the HTML source code
$html = curl_exec($ch);

// Close the cURL session
curl_close($ch);

// Insert the HTML source code into the database
$date = date('Y-m-d H:i:s'); // current date and time in MySQL format
$name = "venza";
$sql = "INSERT INTO html (html, date, name) VALUES (:html, :date, :name)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':html', $html);
$stmt->bindParam(':date', $date);
$stmt->bindParam(':name', $name);
$stmt->execute();

//Eat
// URL of the website to download HTML source code from
$url = 'http://eatandmeet.sk/tyzdenne-menu';
$ch = curl_init();

// Set the URL and other options for cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Execute the cURL session and fetch the HTML source code
$html = curl_exec($ch);

// Close the cURL session
curl_close($ch);

// Insert the HTML source code into the database
$date = date('Y-m-d H:i:s'); // current date and time in MySQL format
$name = "eatandmeet";
$sql = "INSERT INTO html (html, date, name) VALUES (:html, :date, :name)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':html', $html);
$stmt->bindParam(':date', $date);
$stmt->bindParam(':name', $name);
$stmt->execute();

//Fiit-food
// URL of the website to download HTML source code from
$url = 'http://www.freefood.sk/menu/#fiit-food';
$ch = curl_init();

// Set the URL and other options for cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Execute the cURL session and fetch the HTML source code
$html = curl_exec($ch);

// Close the cURL session
curl_close($ch);

// Insert the HTML source code into the database
$date = date('Y-m-d H:i:s'); // current date and time in MySQL format
$name = "fiit";
$sql = "INSERT INTO html (html, date, name) VALUES (:html, :date, :name)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':html', $html);
$stmt->bindParam(':date', $date);
$stmt->bindParam(':name', $name);
$stmt->execute();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>