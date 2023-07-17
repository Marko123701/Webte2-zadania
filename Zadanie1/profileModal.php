<?php
require_once('config.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
try {
  $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if (!isset($_GET['id'])) {
    exit("id not exist");
  }
  $query = "SELECT * FROM person where id=?";
  $stmt = $db->prepare($query);
  $stmt->execute([intval($_GET['id'])]);
  $person = $stmt->fetch(PDO::FETCH_ASSOC);

  $query = "select placement.*, games.city from placement join games on placement.games_id = games.id where placement.person_id=?";
  $stmt = $db->prepare($query);
  $stmt->execute([$_GET['id']]);
  $placements = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="stylesheet/style.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <title>profileModal</title>
</head>

<body>
  <div>
    <nav class="navbar navbar-dark bg-dark fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Domov</a>
        <button name="navBar" class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Domov</h5>
            <button name="navBar" type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Domov</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="admin.php">Admin panel</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="profile.php">Profil</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="register-login/logout.php">Logout</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
  </div>
  <div>
    <h3 style="margin-bottom: 25px;">Profil športovca</h3>
    <div>
      <table class="table display table-striped table-bordered">
        <thead>
          <tr>
            <td>Meno</td>
            <td>Priezvisko</td>
            <td>Dátum narodenia</td>
            <td>Mesto</td>
            <td>Krajina</td>

          </tr>
        </thead>
        <tbody>
          <?php
          echo '<tr><td>' . $person['name'] . '</td><td>' . $person['surname'] . '</td><td>' . $person['birth_day'] . '</td><td>' . $person['birth_place'] . '</td><td>' . $person['birth_country'] . '</td></tr>';
          ?>
        </tbody>
      </table>
    </div>
    <div>
      <table class="table display table-striped table-bordered">
        <thead>
          <tr>
            <td>Umiestnenie</td>
            <td>discipline</td>
            <td>OH</td>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($placements as $placement) {
            echo '<tr><td>' . $placement['placing'] . '</td><td>' . $placement['discipline'] . '</td><td>' . $placement['city'] . '</td><td>';
            echo '</td></tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>