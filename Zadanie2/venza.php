<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
</head>
<body>
<button onclick="downloadVenzaHtml()">Stiahni</button>
<button onclick="">Rozparsuj</button>
<button onclick="">Vymaz</button>
</body>
<script>
function downloadVenzaHtml() {
    // Initialize a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Set the URL of the PHP script that downloads and stores the HTML
    var url = "download_venza_html.php";

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
</script>
</html>