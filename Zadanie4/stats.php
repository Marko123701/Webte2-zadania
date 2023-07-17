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

//map
$sql = "SELECT lat, lon FROM logs";
$result = $conn->query($sql);

// Create array of marker locations
$marker_locations = array();
while ($row = $result->fetch_assoc()) {
    $lat = $row["lat"];
    $lon = $row["lon"];
    $marker_locations[] = array("lat" => $lat, "lon" => $lon);
}

// Close MySQL connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@1&family=Open+Sans:ital,wght@0,300;0,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <title>Stats</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbY7yyx_7mjcg3VSBGbOZN8MHCufW4Ebg"></script>
    <script>
        // Initialize map with markers
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 4,
                center: new google.maps.LatLng(48.148598, 17.107748) // Set default map center
            });

            // Add markers to map
            <?php foreach ($marker_locations as $marker_location) { ?>
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(<?php echo $marker_location['lat']; ?>, <?php echo $marker_location['lon']; ?>),
                    map: map
                });
            <?php } ?>
        }
    </script>
    <style>
        body {
            background-image: url('world-map.jpg');
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #map {
            height: 500px;
            width: 700px;
        }

        #flags{
            position: absolute;
            top: 10%;
        }

        .map-div {
            margin: 20px;
            height: 500px;
            /* Set height for the map */
        }

        .table-div {
            width: 700px;
        }

        .table-div-profile {
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

        <div id="flags" class="table-div">
            <?php
            // Connect to MySQL database
            $servername = "localhost";
            $username = "xmatuskam3";
            $password = "sAuXa5s97E0zWhT";
            $dbname = "z4";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT country, COUNT(*) AS visitors FROM logs GROUP BY country ORDER BY visitors DESC";
            $result = $conn->query($sql);

            echo "<table class='table table-dark'>";
            echo "<tr><th scope='col'>Country</th><th scope='col'>Flag</th scope='col'><th>Visitors</th></tr>";
            while ($row = $result->fetch_assoc()) {
                $country_code = $row["country"];
                $visitors = $row["visitors"];

                $flag_url = "http://www.geonames.org/flags/x/" . strtolower($country_code) . ".gif";

                // Display data in table row
                echo "<tr><td><a href='cities.php?country=" . urlencode($country_code) . "'>" . $country_code . "</a></td><td><img class='flag' width='50' height='40' src='" . $flag_url . "' alt='" . $country_code . "'></td><td>" . $visitors . "</td></tr>";
            }
            echo "</table>";
            ?>
            <div class="table-div">
            <?php
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

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
            $sql = "SELECT 
            CASE
                WHEN TIME(time_range) BETWEEN '06:00:00' AND '15:00:00' THEN '6:00-15:00'
                WHEN TIME(time_range) BETWEEN '15:00:00' AND '21:00:00' THEN '15:00-21:00'
                WHEN TIME(time_range) BETWEEN '21:00:00' AND '24:00:00' THEN '21:00-24:00'
                ELSE '24:00-6:00'
            END AS time_range,
            COUNT(*) AS visitors
        FROM logs
        GROUP BY time_range";

            $result = $conn->query($sql);

            echo "<table class='table table-dark'>";
            echo "<tr><th>Time Range</th><th>Visitors</th></tr>";
            while ($row = $result->fetch_assoc()) {
                $time_range = $row["time_range"];
                $visitors = $row["visitors"];

                echo "<tr><td>" . $time_range . "</td><td>" . $visitors . "</td></tr>";
            }
            echo "</table>";

            $conn->close();
            ?>
        </div>
        <div>
            <div id="map"></div>
            <script>
                initMap();
            </script>
        </div>
    </div>
        


</body>

</html>