<?php

use LDAP\Result;

require_once('config.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
try {
  $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $query = "SELECT *
    FROM person
    JOIN placement ON person.id = placement.person_id
    JOIN games ON placement.games_id = games.id
    where placement.placing = 1";
  $stmt = $db->query($query);
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $query = "SELECT person.*, COUNT(placement.placing)
    FROM person
    INNER JOIN placement ON person.id = placement.person_id
    WHERE placement.placing = 1
    GROUP BY person.id
    ORDER BY COUNT(placement.placing) DESC
    LIMIT 10";
  $stmt = $db->query($query);
  $topResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  <link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.css" rel="stylesheet">
  <link rel="stylesheet" href="stylesheet/style.css">
  <script src="script.js"></script>
</head>

<body>
  <h2 style="text-align: center;">Zadanie 1</h2>
  <main>

    <?php

    session_start();

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    } else {
      // Prihlaseny pouzivatel, zobraz odkaz na zabezpecenu stranku.
      echo '<h3>Vitaj ' . $_SESSION['fullname'] . ' </h3>';
      echo '<a href="admin.php">Zabezpecena stranka</a>';
    }

    ?>
  </main>
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
  <div class="container-md">
    <h1 style="margin-bottom: 15px">Víťazi OH</h1>
    <table class="table display table-striped table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>Meno</th>
          <th>Priezvisko</th>
          <th>Rok</th>
          <th>Miesto</th>
          <th>Typ</th>
          <th>Disciplína</th>
        </tr>
      </thead>
      <tbody>
        <?php //var_dump($results) 
        foreach ($results as $result) {
          echo "<tr><td><a href='profileModal.php?id=" .  $result["person_id"] . "'>" . $result["name"] . "</a><td>" . $result["surname"] . "</td><td>" . $result["year"] . "</td><td>" . $result["city"] . "</td><td>" . $result["type"] . "</td><td>" . $result["discipline"] . "</td></tr>";
        }

        ?>
      </tbody>
    </table>
    <div style="margin-top: 20px;">
      <h3>10 najúspešnejších olympionikov</h3>
      <table class="table2 display table-striped table-bordered" style="width: 100%">
        <thead class="thead-dark">
          <tr>
            <th>Meno</th>
            <th>Priezvisko</th>
            <th>Rok narodenia</th>
            <th>Miesto narodenia</th>
            <th>Počet zlatých medailí</th>
          </tr>
        </thead>
        <tbody>
          <?php //var_dump($results) 
          foreach ($topResults as $result) {
            echo "<tr><td><a href='profileModal.php?id=" .  $result["id"] . "'>" . $result["name"] . "</a></td><td>" . $result["surname"] . "</td><td>" . $result["birth_day"] . "</td><td>" . $result["birth_place"] . "</td><td>" . $result["COUNT(placement.placing)"] . "</td></tr>";
          }

          ?>
        </tbody>
      </table>
    </div>

  </div>
  <!-- Copyright -->
  <div class="text-center p-3 text-white mt-3" style="background-color: rgba(0, 0, 0, 0.8);">
    © 2023 Copyright:
    <a class="text-white" href="https://www.instagram.com/markomatuska/">Marko Matuska</a>
  </div>
  <!-- Copyright -->
  </footer>
  <!-- Footer -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.js"></script>
  <script>
    $(document).ready(function() {
      $('.table').DataTable(
        /*{
                    columns: [
                { orderable: false },
                null,
                null,
                { orderable: false },
                null,
                { orderable: false }
                ]
                    }*/
      );
      $('.table2').DataTable({
        order: [
          [4, 'desc']
        ],
      });
    });
  </script>
</body>

</html>