<?php
// Connect to MySQL database
$servername = "localhost";
$username = "xmatuskam3";
$password = "sAuXa5s97E0zWhT";
$dbname = "z4";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from MySQL database
$country_code = $_GET["country"];
$sql = "SELECT city, COUNT(*) AS visitors FROM logs WHERE country = '$country_code' GROUP BY city";
$result = $conn->query($sql);

// Create table to display data
echo "<div class='table-div-profile'><table class='table table-dark'>";
echo "<tr><th scope='col'>County</th><th scope='col'>City</th><th scope='col'>Visitors</th></tr>";
while ($row = $result->fetch_assoc()) {
    $city = $row["city"];
    $visitors = $row["visitors"];

    // Display data in table row
    echo "<tr><td>" . $country_code . "</td><td>" . $city . "</td><td>" . $visitors . "</td></tr>";
}
echo "</table></div>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <title>Document</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('world-map.jpg');
        }

        .table-div-profile {
            position: absolute;
            top: 10%;
            width: 700px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Home</a>
            <button name="navBar" class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Home</h5>
                    <button name="navBar" type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="stats.php">Stats</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

</body>

</html>