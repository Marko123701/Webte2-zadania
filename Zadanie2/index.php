<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');

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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" />
    <title>Menu</title>
</head>

<body>
    <h4>Zadanie 3</h4>
    <div class="buttons">
    <button onclick="downloadHtml()">Stiahni</button>
    <button onclick="parseHtml()">Rozparsuj</button>
    <button onclick="deleteHtml()">Vymaz</button>
    </div>
    <div>
        <div class="buttons">
            <button onclick="showMenu('all')">Cely tyzden</button>
            <button onclick="showMenu('Monday')">Pondelok</button>
            <button onclick="showMenu('Tuesday')">Utorok</button>
            <button onclick="showMenu('Wednesday')">Streda</button>
            <button onclick="showMenu('Thursday')">Stvrtok</button>
            <button onclick="showMenu('Friday')">Piatok</button>
            <button onclick="showMenu('Saturday')">Sobota</button>
            <button onclick="showMenu('Sunday')">Nedela</button>
        </div>
        <div class="menu">
            <div id="venza">
                <h2>Venza</h2>
                <div class="Monday">
                    <h3">Pondelok</h3>
                        <ul>
                            <?php
                            // your PHP code here
                            ?>
                            <?php foreach ($MondayMenuItemsVenza as $item) : ?>
                                <li><?php echo $item[0]; ?> <?php echo $item[1]; ?></li>
                            <?php endforeach; ?>
                        </ul>
                </div>
                <div class="Tuesday">
                    <h3>Utorok</h3>
                    <ul>
                        <?php
                        // your PHP code here
                        ?>
                        <?php foreach ($TuesdayMenuItemsVenza as $item) : ?>
                            <li><?php echo $item[0]; ?> <?php echo $item[1]; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="Wednesday">
                    <h3>Streda</h3>
                        <ul>
                            <?php
                            // your PHP code here
                            ?>
                            <?php foreach ($WednesdayMenuItemsVenza as $item) : ?>
                                <li><?php echo $item[0]; ?> <?php echo $item[1]; ?></li>
                            <?php endforeach; ?>
                        </ul>
                </div>
                <div class="Thursday">
                    <h3>Stvrtok</h3>
                        <ul>
                            <?php
                            // your PHP code here
                            ?>
                            <?php foreach ($ThursdayMenuItemsVenza as $item) : ?>
                                <li><?php echo $item[0]; ?> <?php echo $item[1]; ?></li>
                            <?php endforeach; ?>
                        </ul>
                </div>
                <div class="Friday">
                    <h3>Piatok</h3>
                        <ul>
                            <?php
                            // your PHP code here
                            ?>
                            <?php foreach ($FridayMenuItems as $item) : ?>
                                <li><?php echo $item[0]; ?> <?php echo $item[1]; ?></li>
                            <?php endforeach; ?>
                        </ul>
                </div>
            </div>
            <div id="eat">
                <h2>Eat&Meet</h2>
                <div class="Monday">
                    <h3 onclick="toggleMenu(this)">Pondelok</h3>
                    <ul>
                        <?php
                        // your PHP code here
                        ?>
                        <?php foreach ($menuItemsFiitEat["Pondelok"] as $item) : ?>
                            <li><?php echo $item[0]; ?> <?php echo $item[1]; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="Tuesday">
                    <h3>Utorok</h3>
                        <ul>
                            <?php
                            // your PHP code here
                            ?>
                            <?php foreach ($menuItemsFiitEat["Utorok"] as $item) : ?>
                                <li><?php echo $item[0]; ?> <?php echo $item[1]; ?></li>
                            <?php endforeach; ?>
                        </ul>
                </div>
                <div class="Wednesday">
                    <h3>Streda</h3>
                        <ul>
                            <?php
                            // your PHP code here
                            ?>
                            <?php foreach ($menuItemsFiitEat["Streda"] as $item) : ?>
                                <li><?php echo $item[0]; ?> <?php echo $item[1]; ?></li>
                            <?php endforeach; ?>
                        </ul>
                </div>
                <div class="Thursday">
                    <h3>Stvrtok</h3>
                    <ul>
                        <?php
                        // your PHP code here
                        ?>
                        <?php foreach ($menuItemsFiitEat["Stvrtok"] as $item) : ?>
                            <li><?php echo $item[0]; ?> <?php echo $item[1]; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="Friday">
                    <h3>Piatok</h3>
                    <ul>
                        <?php
                        // your PHP code here
                        ?>
                        <?php foreach ($menuItemsFiitEat["Piatok"] as $item) : ?>
                            <li><?php echo $item[0]; ?> <?php echo $item[1]; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="Saturday">
                    <h3>Sobota</h3>
                    <ul>
                        <?php
                        // your PHP code here
                        ?>
                        <?php foreach ($menuItemsFiitEat["Sobota"] as $item) : ?>
                            <li><?php echo $item[0]; ?> <?php echo $item[1]; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="Sunday">
                    <h3>Nedela</h3>
                    <ul>
                        <?php
                        // your PHP code here
                        ?>
                        <?php foreach ($menuItemsFiitEat["Nedela"] as $item) : ?>
                            <li><?php echo $item[0]; ?> <?php echo $item[1]; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="WeeklyOffer">
                    <h3>Tydenne Menu</h3>
                    <ul>
                        <?php
                        // your PHP code here
                        ?>
                        <?php foreach ($menuItemsFiitEat["Daily Offer"] as $item) : ?>
                            <li><?php echo $item[0]; ?> <?php echo $item[1]; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div id="fiit-food">
                <h2>Fiit Food</h2>
                <div class="Monday">
                    <h3>Pondelok</h3>
                    <ul>
                        <?php
                        // your PHP code here
                        ?>
                        <?php foreach ($menuItemsFiit["Pondelok"] as $item) : ?>
                            <li><?php echo $item[0]; ?> <?php echo $item[1]; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="Tuesday">
                    <h3>Utorok</h3>
                    <ul>
                        <?php
                        // your PHP code here
                        ?>
                        <?php foreach ($menuItemsFiit["Utorok"] as $item) : ?>
                            <li><?php echo $item[0]; ?> <?php echo $item[1]; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="Wednesday">
                    <h3>Streda</h3>
                    <ul>
                        <?php
                        // your PHP code here
                        ?>
                        <?php foreach ($menuItemsFiit["Streda"] as $item) : ?>
                            <li><?php echo $item[0]; ?> <?php echo $item[1]; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="Thursday">
                    <h3>Stvrtok</h3>
                    <ul>
                        <?php
                        // your PHP code here
                        ?>
                        <?php foreach ($menuItemsFiit["Stvrtok"] as $item) : ?>
                            <li><?php echo $item[0]; ?> <?php echo $item[1]; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="Friday">
                    <h3>Piatok</h3>
                    <ul>
                        <?php
                        // your PHP code here
                        ?>
                        <?php foreach ($menuItemsFiit["Piatok"] as $item) : ?>
                            <li><?php echo $item[0]; ?> <?php echo $item[1]; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="WeeklyOffer">
                    <h3>Tyzdenne Menu</h3>
                    <ul>
                        <?php
                        // your PHP code here
                        ?>
                        <?php foreach ($menuItemsFiit["Daily Offer"] as $item) : ?>
                            <li><?php echo $item[0]; ?> <?php echo $item[1]; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function downloadHtml() {
        // Initialize a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Set the URL of the PHP script that downloads and stores the HTML
        var url = "download_html.php";

        // Set the HTTP method to POST and the data to an empty string
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        // Send the HTTP request to the PHP script
        xhr.send();

        // Display a success message when the download is complete
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert("HTML source code downloaded and stored successfully!");
            }
        };
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        // Send the HTTP request to the PHP script
        xhr.send();

        // Display a success message when the download is complete
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert("HTML source code downloaded and stored successfully!");
            }
        };

    }

    function parseHtml() {
        // Initialize a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Set the URL of the PHP script that downloads and stores the HTML
        var url = "parse_html.php";

        // Set the HTTP method to POST and the data to an empty string
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        // Send the HTTP request to the PHP script
        xhr.send();

        // Display a success message when the download is complete
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert("Menu parsed successfully!");
            }
        };
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        // Send the HTTP request to the PHP script
        xhr.send();

        // Display a success message when the download is complete
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert("Menu parsed successfully!");
            }
        };

    }

    function deleteHtml() {
        // Initialize a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Set the URL of the PHP script that downloads and stores the HTML
        var url = "delete_html.php";

        // Set the HTTP method to POST and the data to an empty string
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        // Send the HTTP request to the PHP script
        xhr.send();

        // Display a success message when the download is complete
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert("Menu deleted successfully!");
            }
        };
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        // Send the HTTP request to the PHP script
        xhr.send();

        // Display a success message when the download is complete
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert("Menu deleted successfully!");
            }
        };

    }

    function showMenu(day) {
        let divs = document.querySelectorAll('#venza div, #eat div, #fiit-food div');
        if (day === 'all') {
            for (let i = 0; i < divs.length; i++) {
                divs[i].style.display = 'block';
            }
        } else {
            for (let i = 0; i < divs.length; i++) {
                if (divs[i].classList.contains(day) || divs[i].classList.contains("WeeklyOffer")) {
                    divs[i].style.display = 'block';
                } else {
                    divs[i].style.display = 'none';
                }
            }
        }
    }
</script>

</html>