<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');

//parse venza
$sql = "SELECT html FROM html WHERE name='venza' ORDER BY id DESC LIMIT 1";

$stmt = $pdo->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Get the value of the 'html' column from the row
$html = $row['html'];

// create a DOM object and load HTML code
$dom = new DOMDocument();
@$dom->loadHTML($html);

// find the div with the given class name
$div = $dom->getElementById('day_1');

// print the HTML code of the div
$h5_elements = $div->getElementsByTagName('h5');

// Loop through each h5 element and print its content
$i = 0;
$j = 0;
$k = 0;
$MondayMenuItemsVenza = array();
foreach ($h5_elements as $h5) {
    if ($k == 2) {
        $MondayMenuItemsVenza[$j][$k] = "Pondelok";
        $MondayMenuItemsVenza[$j][$k + 1] = "Venza";
        $k = 0;
        $j++;
    }
    if (!(($i == 0) || ($i == 5) || ($i == 8) || ($i == 11) || ($i == 14) || ($i == 17) || ($i == 20) || ($i == 23) || ($i == 26))) {
        //array_push($menuItemsFiitEat, $h5->nodeValue);
        $MondayMenuItemsVenza[$j][$k] = $h5->nodeValue;
        $k++;
    }
    $i++;
}
$canteen = "Venza";
$date = "Pondelok";
foreach($MondayMenuItemsVenza as $item){
    $sql = "INSERT INTO items (name, price, canteen, day) VALUES (:name, :price, :canteen,:date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $item[0]);
    $stmt->bindParam(':price', $item[1]);
    $stmt->bindParam(':canteen', $canteen);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}

// find the div with the given class name
$div = $dom->getElementById('day_2');

// print the HTML code of the div
$h5_elements = $div->getElementsByTagName('h5');

// Loop through each h5 element and print its content
$i = 0;
$j = 0;
$k = 0;
$TuesdayMenuItemsVenza = array();
foreach ($h5_elements as $h5) {
    if ($k == 2) {
        $TuesdayMenuItemsVenza[$j][$k] = "Utorok";
        $TuesdayMenuItemsVenza[$j][$k + 1] = "Venza";
        $k = 0;
        $j++;
    }
    if (!(($i == 0) || ($i == 5) || ($i == 8) || ($i == 11) || ($i == 14) || ($i == 17) || ($i == 20) || ($i == 23) || ($i == 26))) {
        //array_push($menuItemsFiitEat, $h5->nodeValue);
        $TuesdayMenuItemsVenza[$j][$k] = $h5->nodeValue;
        $k++;
    }
    $i++;
}
$canteen = "Venza";
$date = "Utorok";
var_dump($TuesdayMenuItemsVenza);
foreach($TuesdayMenuItemsVenza as $item){
    $sql = "INSERT INTO items (name, price, canteen, day) VALUES (:name, :price, :canteen,:date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $item[0]);
    $stmt->bindParam(':price', $item[1]);
    $stmt->bindParam(':canteen', $canteen);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}

// find the div with the given class name
$div = $dom->getElementById('day_3');

// print the HTML code of the div
$h5_elements = $div->getElementsByTagName('h5');

// Loop through each h5 element and print its content
$i = 0;
$j = 0;
$k = 0;
$WednesdayMenuItemsVenza = array();
foreach ($h5_elements as $h5) {
    if ($k == 2) {
        $WednesdayMenuItemsVenza[$j][$k] = "Streda";
        $WednesdayMenuItemsVenza[$j][$k + 1] = "Venza";
        $k = 0;
        $j++;
    }
    if (!(($i == 0) || ($i == 5) || ($i == 8) || ($i == 11) || ($i == 14) || ($i == 17) || ($i == 20) || ($i == 23) || ($i == 26))) {
        //array_push($menuItemsFiitEat, $h5->nodeValue);
        $WednesdayMenuItemsVenza[$j][$k] = $h5->nodeValue;
        $k++;
    }
    $i++;
}
$canteen = "Venza";
$date = "Streda";
foreach($WednesdayMenuItemsVenza as $item){
    $sql = "INSERT INTO items (name, price, canteen, day) VALUES (:name, :price, :canteen,:date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $item[0]);
    $stmt->bindParam(':price', $item[1]);
    $stmt->bindParam(':canteen', $canteen);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}

// find the div with the given class name
$div = $dom->getElementById('day_4');

// print the HTML code of the div
$h5_elements = $div->getElementsByTagName('h5');

// Loop through each h5 element and print its content
$i = 0;
$j = 0;
$k = 0;
$ThursdayMenuItemsVenza = array();
foreach ($h5_elements as $h5) {
    if ($k == 2) {
        $ThursdayMenuItemsVenza[$j][$k] = "Stvrtok";
        $ThursdayMenuItemsVenza[$j][$k + 1] = "Venza";
        $k = 0;
        $j++;
    }
    if (!(($i == 0) || ($i == 5) || ($i == 8) || ($i == 11) || ($i == 14) || ($i == 17) || ($i == 20) || ($i == 23) || ($i == 26))) {
        //array_push($menuItemsFiitEat, $h5->nodeValue);
        $ThursdayMenuItemsVenza[$j][$k] = $h5->nodeValue;
        $k++;
    }
    $i++;
}
$canteen = "Venza";
$date = "Stvrtok";
foreach($ThursdayMenuItemsVenza as $item){
    $sql = "INSERT INTO items (name, price, canteen, day) VALUES (:name, :price, :canteen,:date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $item[0]);
    $stmt->bindParam(':price', $item[1]);
    $stmt->bindParam(':canteen', $canteen);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}

// find the div with the given class name
$div = $dom->getElementById('day_5');

// print the HTML code of the div
$h5_elements = $div->getElementsByTagName('h5');

// Loop through each h5 element and print its content
$i = 0;
$j = 0;
$k = 0;
$FridayMenuItemsVenza = array();
foreach ($h5_elements as $h5) {
    if ($k == 2) {
        $FridayMenuItems[$j][$k] = "Piatok";
        $FridayMenuItems[$j][$k + 1] = "Venza";
        $k = 0;
        $j++;
    }
    if (!(($i == 0) || ($i == 5) || ($i == 8) || ($i == 11) || ($i == 14) || ($i == 17) || ($i == 20) || ($i == 23) || ($i == 26))) {
        //array_push($menuItemsFiitEat, $h5->nodeValue);
        $FridayMenuItems[$j][$k] = $h5->nodeValue;
        $k++;
    }
    $i++;
}
$canteen = "Venza";
$date = "Piatok";
foreach($FridayMenuItems as $item){
    $sql = "INSERT INTO items (name, price, canteen, day) VALUES (:name, :price, :canteen,:date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $item[0]);
    $stmt->bindParam(':price', $item[1]);
    $stmt->bindParam(':canteen', $canteen);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}

//Eat&Meet
$sql = "SELECT html FROM html WHERE name='eatandmeet' ORDER BY id DESC LIMIT 1";

$stmt = $pdo->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Get the value of the 'html' column from the row
$html = $row['html'];

// create a DOM object and load HTML code
$dom = new DOMDocument();
@$dom->loadHTML($html);

$xpath = new DOMXPath($dom);
$xpath->registerNamespace('html', 'http://www.w3.org/1999/xhtml');

$div = $xpath->query('//div[@id="day-1"]')->item(0);
$menuItemsFiitEat = array();
// Get all the spans with class "day-title"
$ps = $day_offers = $xpath->query('.//p[@class="desc"]', $div);
$days = ["Pondelok", "Utorok", "Streda", "Stvrtok", "Piatok", "Sobota", "Nedela"];
$prices = $xpath->query('.//span[@class="price"]', $div);
$i = 0;
// iterate through the found elements
foreach ($ps as $element) {
    $menuItemsFiitEat[$days[0]][$i][0] = $element->textContent;
    $menuItemsFiitEat[$days[0]][$i][1] = $prices[$i]->textContent;
    $menuItemsFiitEat[$days[0]][$i][2] = "Eat";
}

$canteen = "Eat";
$date = "Pondelok";
foreach($menuItemsFiitEat["Pondelok"] as $item){
    $sql = "INSERT INTO items (name, price, canteen, day) VALUES (:name, :price, :canteen,:date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $item[0]);
    $stmt->bindParam(':price', $item[1]);
    $stmt->bindParam(':canteen', $canteen);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}

$div = $xpath->query('//div[@id="day-2"]')->item(0);

// Get all the spans with class "day-title"
$ps = $xpath->query('.//p[@class="desc"]', $div);
$prices = $xpath->query('.//span[@class="price"]', $div);
$i = 0;
// iterate through the found elements
foreach ($ps as $element) {
    $menuItemsFiitEat[$days[1]][$i][0] = $element->textContent;
    $menuItemsFiitEat[$days[1]][$i][1] = $prices[$i]->textContent;
    $menuItemsFiitEat[$days[1]][$i][2] = "Eat";
    $i++;
}
$canteen = "Eat";
$date = "Utorok";
foreach($menuItemsFiitEat["Utorok"] as $item){
    $sql = "INSERT INTO items (name, price, canteen, day) VALUES (:name, :price, :canteen,:date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $item[0]);
    $stmt->bindParam(':price', $item[1]);
    $stmt->bindParam(':canteen', $canteen);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}

$div = $xpath->query('//div[@id="day-3"]')->item(0);

// Get all the spans with class "day-title"
$ps = $xpath->query('.//p[@class="desc"]', $div);
$prices = $xpath->query('.//span[@class="price"]', $div);
$i = 0;
// iterate through the found elements
foreach ($ps as $element) {
    $menuItemsFiitEat[$days[2]][$i][0] = $element->textContent;
    $menuItemsFiitEat[$days[2]][$i][1] = $prices[$i]->textContent;
    $menuItemsFiitEat[$days[2]][$i][2] = "Eat";
    $i++;
}
$canteen = "Eat";
$date = "Streda";
foreach($menuItemsFiitEat["Streda"] as $item){
    $sql = "INSERT INTO items (name, price, canteen, day) VALUES (:name, :price, :canteen,:date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $item[0]);
    $stmt->bindParam(':price', $item[1]);
    $stmt->bindParam(':canteen', $canteen);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}

$div = $xpath->query('//div[@id="day-4"]')->item(0);

// Get all the spans with class "day-title"
$ps = $xpath->query('.//p[@class="desc"]', $div);
$prices = $xpath->query('.//span[@class="price"]', $div);
$i = 0;
// iterate through the found elements
foreach ($ps as $element) {
    $menuItemsFiitEat[$days[3]][$i][0] = $element->textContent;
    $menuItemsFiitEat[$days[3]][$i][1] = $prices[$i]->textContent;
    $menuItemsFiitEat[$days[3]][$i][2] = "Eat";
    $i++;
}
$canteen = "Eat";
$date = "Stvrtok";
foreach($menuItemsFiitEat["Stvrtok"] as $item){
    $sql = "INSERT INTO items (name, price, canteen, day) VALUES (:name, :price, :canteen,:date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $item[0]);
    $stmt->bindParam(':price', $item[1]);
    $stmt->bindParam(':canteen', $canteen);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}

$div = $xpath->query('//div[@id="day-5"]')->item(0);

// Get all the spans with class "day-title"
$ps = $xpath->query('.//p[@class="desc"]', $div);
$prices = $xpath->query('.//span[@class="price"]', $div);
$i = 0;
// iterate through the found elements
foreach ($ps as $element) {
    $menuItemsFiitEat[$days[4]][$i][0] = $element->textContent;
    $menuItemsFiitEat[$days[4]][$i][1] = $prices[$i]->textContent;
    $menuItemsFiitEat[$days[4]][$i][2] = "Eat";
    $i++;
}
$canteen = "Eat";
$date = "Piatok";
foreach($menuItemsFiitEat["Piatok"] as $item){
    $sql = "INSERT INTO items (name, price, canteen, day) VALUES (:name, :price, :canteen,:date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $item[0]);
    $stmt->bindParam(':price', $item[1]);
    $stmt->bindParam(':canteen', $canteen);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}

$div = $xpath->query('//div[@id="day-6"]')->item(0);

// Get all the spans with class "day-title"
$ps = $xpath->query('.//p[@class="desc"]', $div);
$prices = $xpath->query('.//span[@class="price"]', $div);
$i = 0;
// iterate through the found elements
foreach ($ps as $element) {
    $menuItemsFiitEat[$days[5]][$i][0] = $element->textContent;
    $menuItemsFiitEat[$days[5]][$i][1] = $prices[$i]->textContent;
    $menuItemsFiitEat[$days[5]][$i][2] = "Eat";
    $i++;
}
$canteen = "Eat";
$date = "Sobota";
foreach($menuItemsFiitEat["Sobota"] as $item){
    $sql = "INSERT INTO items (name, price, canteen, day) VALUES (:name, :price, :canteen,:date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $item[0]);
    $stmt->bindParam(':price', $item[1]);
    $stmt->bindParam(':canteen', $canteen);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}

$div = $xpath->query('//div[@id="day-7"]')->item(0);

// Get all the spans with class "day-title"
$ps = $xpath->query('.//p[@class="desc"]', $div);
$prices = $xpath->query('.//span[@class="price"]', $div);
$i = 0;
// iterate through the found elements
foreach ($ps as $element) {
    $menuItemsFiitEat[$days[6]][$i][0] = $element->textContent;
    $menuItemsFiitEat[$days[6]][$i][1] = $prices[$i]->textContent;
    $menuItemsFiitEat[$days[6]][$i][2] = "Eat";
    $i++;
}
$canteen = "Eat";
$date = "Nedela";
foreach($menuItemsFiitEat["Nedela"] as $item){
    $sql = "INSERT INTO items (name, price, canteen, day) VALUES (:name, :price, :canteen,:date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $item[0]);
    $stmt->bindParam(':price', $item[1]);
    $stmt->bindParam(':canteen', $canteen);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}

$elements = $xpath->query('//h5');
$div = $xpath->query('.//section[@class="weak-menu"]')->item(0);
$i = 0;
$prices = $xpath->query('.//span[@class="price"]', $div);
foreach ($elements as $element) {
    $menuItemsFiitEat["Daily Offer"][$i][0] = $element->nodeValue;
    $menuItemsFiitEat["Daily Offer"][$i][1] = $prices[$i]->textContent;
    $menuItemsFiitEat["Daily Offer"][$i][2] = "Eat";
    $i++;
}
$canteen = "Eat";
$date = "Daily Offer";
foreach($menuItemsFiitEat["Daily Offer"] as $item){
    $sql = "INSERT INTO items (name, price, canteen, day) VALUES (:name, :price, :canteen,:date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $item[0]);
    $stmt->bindParam(':price', $item[1]);
    $stmt->bindParam(':canteen', $canteen);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}

//Fiit-food
$sql = "SELECT html FROM html WHERE name='fiit' ORDER BY id DESC LIMIT 1";

$stmt = $pdo->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Get the value of the 'html' column from the row
$html = $row['html'];


// create a DOM object and load HTML code
$dom = new DOMDocument();
@$dom->loadHTML($html);

$xpath = new DOMXPath($dom);
$fiit_food_div = $xpath->query('//div[@id="fiit-food"]')->item(0);
$day_offers = $xpath->query('.//ul[@class="day-offer"]', $fiit_food_div);

$i = 0;
$prices = array();
$brandPrices = $xpath->query('.//span[@class="brand price"]', $fiit_food_div);
foreach ($brandPrices as $brandPrice) {
    // Process each brand price span
    $brandPriceText = $brandPrice->textContent;
    $prices[$i] = $brandPriceText;
    $i++;
}

$days = ["Pondelok", "Utorok", "Streda", "Stvrtok", "Piatok"];

$i = 0;
$j = 0;
$menuItemsFiit = array();
foreach ($day_offers as $day_offer) {
    foreach ($day_offer->childNodes as $child) {
        if ($child->nodeType === XML_ELEMENT_NODE) {
            $menuItemsFiit[$days[$j]][$i][0] = $child->childNodes->item(1)->textContent;
            $menuItemsFiit[$days[$j]][$i][1] = $prices[$i];
            $menuItemsFiit[$days[$j]][$i][2] = "Fiit";
            $i++;
        }
    }
    $j++;
}
$canteen = "Fiit";
$date = "Pondelok";
foreach($menuItemsFiit["Pondelok"] as $item){
    $sql = "INSERT INTO items (name, price, canteen, day) VALUES (:name, :price, :canteen,:date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $item[0]);
    $stmt->bindParam(':price', $item[1]);
    $stmt->bindParam(':canteen', $canteen);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}
$canteen = "Fiit";
$date = "Utorok";
foreach($menuItemsFiit["Utorok"] as $item){
    $sql = "INSERT INTO items (name, price, canteen, day) VALUES (:name, :price, :canteen,:date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $item[0]);
    $stmt->bindParam(':price', $item[1]);
    $stmt->bindParam(':canteen', $canteen);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}
$canteen = "Fiit";
$date = "Streda";
foreach($menuItemsFiit["Streda"] as $item){
    $sql = "INSERT INTO items (name, price, canteen, day) VALUES (:name, :price, :canteen,:date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $item[0]);
    $stmt->bindParam(':price', $item[1]);
    $stmt->bindParam(':canteen', $canteen);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}
$canteen = "Fiit";
$date = "Stvrtok";
foreach($menuItemsFiit["Stvrtok"] as $item){
    $sql = "INSERT INTO items (name, price, canteen, day) VALUES (:name, :price, :canteen,:date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $item[0]);
    $stmt->bindParam(':price', $item[1]);
    $stmt->bindParam(':canteen', $canteen);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}
$canteen = "Fiit";
$date = "Piatok";
foreach($menuItemsFiit["Piatok"] as $item){
    $sql = "INSERT INTO items (name, price, canteen, day) VALUES (:name, :price, :canteen,:date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $item[0]);
    $stmt->bindParam(':price', $item[1]);
    $stmt->bindParam(':canteen', $canteen);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}

$day_offers = $xpath->query('.//ul[@class="pernament-offer"]', $fiit_food_div);

foreach ($day_offers as $day_offer) {
    foreach ($day_offer->childNodes as $child) {
        if ($child->nodeType === XML_ELEMENT_NODE) {
            $menuItemsFiit["Daily Offer"][$i][0] = $child->childNodes->item(0)->textContent;
            $menuItemsFiit["Daily Offer"][$i][1] = $prices[$i];
            $menuItemsFiit["Daily Offer"][$i][2] = "Fiit";
            $i++;
        }
    }
}
$canteen = "Fiit";
$date = "Daily Offer";
foreach($menuItemsFiit["Daily Offer"] as $item){
    $sql = "INSERT INTO items (name, price, canteen, day) VALUES (:name, :price, :canteen,:date)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $item[0]);
    $stmt->bindParam(':price', $item[1]);
    $stmt->bindParam(':canteen', $canteen);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
}
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