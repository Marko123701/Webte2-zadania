<?php
if ($_GET['function'] == 'myFunction') {
  myFunction($_GET['param1'], $_GET['param2'], $_GET['param3'], $_GET['param4'], $_GET['param5']);
}


function myFunction($country, $lat, $lon, $city, $timezone)
{
  $hostname = "localhost";
  $username = "xmatuskam3";
  $password = "sAuXa5s97E0zWhT";
  $dbname = "z4";

  try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }

  // Get the visitor's IP address
  $ip = $_SERVER['REMOTE_ADDR'];

  // Check if there is a record for this IP address in the logs table for the past 1 day
  $stmt = $pdo->prepare("SELECT * FROM logs WHERE ip_address = :ip AND created_at >= DATE_SUB(NOW(), INTERVAL 1 DAY) AND city = :city");
  $stmt->bindParam(':ip', $ip);
  $stmt->bindParam(':city', $city);
  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$row) {
    $stmt = $pdo->prepare("INSERT INTO logs (ip_address, country, lat, lon, created_at, city, time_range) VALUES (:ip, :country, :lat, :lon, :created_at, :city, :time_range)");
    $stmt->bindParam(':ip', $ip);
    $stmt->bindParam(':country', $country);
    $stmt->bindParam(':lat', $lat);
    $stmt->bindParam(':lon', $lon);
    $current_time = time();
    $time = date('Y-m-d H:i:s', $current_time);
    $stmt->bindParam(':created_at', $time);
    $stmt->bindParam(':city', $city);

    $range = getTimeRange($lat, $lon);
    $stmt->bindParam(':time_range', $range);

    $stmt->execute();
  }
}
function getTimeZone($lat, $lng)
{
  //google timezone api
  $apiKey = 'AIzaSyCbY7yyx_7mjcg3VSBGbOZN8MHCufW4Ebg';
  $url = "https://maps.googleapis.com/maps/api/timezone/json?location=$lat,$lng&timestamp=" . time() . "&key=$apiKey";
  $response = file_get_contents($url);
  $data = json_decode($response, true);
  return $data['timeZoneId'];
}

function getTimeRange($lat, $lng)
{
  $timeZone = getTimeZone($lat, $lng);
  date_default_timezone_set($timeZone);
  $hour = date('H');
  if ($hour >= 6 && $hour < 15) {
    return '6:00-15:00';
  } else if ($hour >= 15 && $hour < 21) {
    return '15:00-21:00';
  } else if ($hour >= 21 || $hour < 6) {
    return '21:00-24:00';
  } else {
    return '24:00-6:00';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@1&family=Open+Sans:ital,wght@0,300;0,400;1,500;1,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  <title>Zadanie 4</title>
  <style>
    body {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
  </style>
</head>

<body>
  <div>
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
  </div>

  <div class="card">
    <div class="search">
      <input type="text" class="search-bar">
      <button class="search-button"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1.5em" width="1.5em" xmlns="http://www.w3.org/2000/svg">
          <path d="M10,18c1.846,0,3.543-0.635,4.897-1.688l4.396,4.396l1.414-1.414l-4.396-4.396C17.365,13.543,18,11.846,18,10 c0-4.411-3.589-8-8-8s-8,3.589-8,8S5.589,18,10,18z M10,4c3.309,0,6,2.691,6,6s-2.691,6-6,6s-6-2.691-6-6S6.691,4,10,4z">
          </path>
          <path d="M11.412,8.586C11.791,8.966,12,9.468,12,10h2c0-1.065-0.416-2.069-1.174-2.828c-1.514-1.512-4.139-1.512-5.652,0 l1.412,1.416C9.346,7.83,10.656,7.832,11.412,8.586z">
          </path>
        </svg></button>
    </div>
    <div class="weather">
      <h2 class="city"></h2>
      <h1 class="temp"></h1>
      <img src="" alt="" class="icon">
      <div class="description"></div>
      <div class="humidity"></div>
      <div class="wind"></div>
      <br>
      <div class="location"></div>
      <div class="country"></div>
      <div class="capital"></div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script>
    function randomImg(city) {
      const body = document.querySelector('body');
      //unsplash api
      body.style.backgroundImage = `url('https://source.unsplash.com/random/1920x1080/?city,${city}')`;
    }
    const searchButton = document.querySelector('.search-button');
    const searchBar = document.querySelector('.search-bar');

    let weather = {
      apiKey: "280d6bf4df67ab2e7ce3793cc691de05",
      fetchWeather: function(city) {
        fetch(
            "https://api.openweathermap.org/data/2.5/weather?q=" +
            city +
            "&units=metric&appid=" +
            this.apiKey
          )
          .then((response) => {
            if (!response.ok) {
              alert("No weather found.");
              throw new Error("No weather found.");
            }
            return response.json();
          })
          .then((data) => this.displayWeather(data));
      },
      displayWeather: function(data) {
        const {
          name
        } = data;
        const {
          icon,
          description
        } = data.weather[0];
        const {
          temp,
          humidity
        } = data.main;
        const {
          speed
        } = data.wind;
        const {
          lon,
          lat
        } = data.coord;
        const {
          country
        } = data.sys;
        const {
          timezone
        } = data;

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
          }
        };

        xhttp.open("GET", "index.php?function=myFunction&param1=" + country + "&param2=" + lat + "&param3=" + lon + "&param4=" + name + "&param5=" + timezone, true);
        xhttp.send();

        //restCoutries Api
        const url1 = `https://restcountries.com/v2/alpha/${country}`;

        fetch(url1)
          .then(response => response.json())
          .then(data => {
            const capitalCity = data.capital;

            document.querySelector(".capital").innerText = `Capital city: ${capitalCity}`;
          })
          .catch(error => console.log(error));

        document.querySelector(".city").innerText = "Weather in " + name;
        document.querySelector(".icon").src =
          "https://openweathermap.org/img/wn/" + icon + ".png";
        document.querySelector(".description").innerText = description;
        document.querySelector(".temp").innerText = temp + "°C";
        document.querySelector(".humidity").innerText =
          "Humidity: " + humidity + "%";
        document.querySelector(".wind").innerText =
          "Wind speed: " + speed + " km/h";
        document.querySelector(".weather").classList.remove("loading");
        document.querySelector(".location").innerText =
          "Latitude, longitude: " + lat + ", " + lon;

        const apiKey = '984ad7f6a2a240ec9727f20ed53207f4';
        const url = `https://api.opencagedata.com/geocode/v1/json?q=${lat}+${lon}&key=${apiKey}&pretty=1&language=en    `;

        fetch(url)
          .then(response => response.json())
          .then(data => {
            const {
              country
            } = data.results[0].components;

            document.querySelector(".country").innerText = `Country: ${country}`;
          })
          .catch(error => console.log(error));


      },
      search: function() {
        const searchTerm = searchBar.value;
        randomImg(searchTerm);
        this.fetchWeather(document.querySelector(".search-bar").value);
      },
    };

    document.querySelector(".search-button").addEventListener("click", function() {
      weather.search();
    });

    document
      .querySelector(".search-bar")
      .addEventListener("keyup", function(event) {
        if (event.key == "Enter") {
          weather.search();
        }
      });
  </script>
</body>

</html>