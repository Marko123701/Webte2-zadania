<?php 
require_once('config.php');

// Select the ID of the last occurrence of the "eatandmeet" row
$sql = "SELECT id FROM html WHERE name='venza' ORDER BY id DESC LIMIT 1";
$stmt = $pdo->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Delete the last occurrence of the "eatandmeet" row
$sql = "DELETE FROM html WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $row['id']]);

// Select the ID of the last occurrence of the "eatandmeet" row
$sql = "SELECT id FROM html WHERE name='eatandmeet' ORDER BY id DESC LIMIT 1";
$stmt = $pdo->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Delete the last occurrence of the "eatandmeet" row
$sql = "DELETE FROM html WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $row['id']]);

// Select the ID of the last occurrence of the "eatandmeet" row
$sql = "SELECT id FROM html WHERE name='fiit' ORDER BY id DESC LIMIT 1";
$stmt = $pdo->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Delete the last occurrence of the "eatandmeet" row
$sql = "DELETE FROM html WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $row['id']]);

$sql = "DELETE FROM items";
$stmt = $pdo->prepare($sql);
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