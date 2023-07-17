function randomImg(city) {
    const body = document.querySelector('body');
    body.style.backgroundImage = `url('https://source.unsplash.com/random/1920x1080/?city,${city}')`;
}
const searchButton = document.querySelector('.search-button');
const searchBar = document.querySelector('.search-bar');

let weather = {
    apiKey: "280d6bf4df67ab2e7ce3793cc691de05",
    fetchWeather: function (city) {
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
    displayWeather: function (data) {
        const { name } = data;
        const { icon, description } = data.weather[0];
        const { temp, humidity } = data.main;
        const { speed } = data.wind;
        const { lon, lat } = data.coord;
        const { country } = data.sys;

        //call php fuction
        var param1 = "Hello, ";
  var param2 = "World!";

  // Create an AJAX request
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      // When the AJAX request is complete, log the response to the console
    }
  };
  
  // Send the AJAX request to the PHP script, passing the function name and parameters as URL parameters
  xhttp.open("GET", "stats.php?function=myFunction&param1=" + param1 + "&param2=" + param2, true);
  xhttp.send();

        const url1 = `https://restcountries.com/v2/alpha/${country}`;

        fetch(url1)
            .then(response => response.json())
            .then(data => {
                const capitalCity = data.capital;

                // display the capital city
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

        const apiKey = '984ad7f6a2a240ec9727f20ed53207f4'; // replace with your OpenCage API key
        const url = `https://api.opencagedata.com/geocode/v1/json?q=${lat}+${lon}&key=${apiKey}&pretty=1&language=en    `;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                const { country } = data.results[0].components;

                // display the location data
                document.querySelector(".country").innerText = `Country: ${country}`;
            })
            .catch(error => console.log(error));


    },
    search: function () {
        const searchTerm = searchBar.value;
        randomImg(searchTerm);
        this.fetchWeather(document.querySelector(".search-bar").value);
    },
};

document.querySelector(".search-button").addEventListener("click", function () {
    weather.search();
});

document
    .querySelector(".search-bar")
    .addEventListener("keyup", function (event) {
        if (event.key == "Enter") {
            weather.search();
        }
    });

weather.fetchWeather("Bratislava");