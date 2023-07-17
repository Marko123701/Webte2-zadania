<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');

session_start();
if (isset($_SESSION['login_id']) || isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == true) {
    echo '<h3>Vitaj ' . $_SESSION['fullname'] . ' </h3>';
} else {
    header('Location: register.php');
    exit;
}

try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!empty($_POST) && !empty($_POST['name']) && !empty($_POST['surname'])) {

        $sql = "SELECT * FROM person WHERE name=? AND surname=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$_POST['name'], $_POST['surname']]);

        if ($stmt->rowCount() > 0) {
            echo '<script>alert("Person already exists in the table")</script>';
        } else {
            echo '<script>alert("Person successfully added")</script>';
            $sql = "INSERT INTO person (name, surname, birth_day, birth_place, birth_country) VALUES (?,?,?,?,?)";
            $stmt = $db->prepare($sql);
            $success = $stmt->execute([$_POST['name'], $_POST['surname'], $_POST['birth_day'], $_POST['birth_place'], $_POST['birth_country']]);

            $sql = "INSERT INTO editLog (email, time, activity) VALUES (:email, :time, :activity)";
            $stmt = $pdo->prepare($sql);

            $current_time = time();
            $time = date('Y-m-d H:i:s', $current_time);
            $activity = "Added person " . $_POST['name'] . " " . $_POST['surname'] . " to database";

            $stmt->bindParam(":email", $_SESSION['email'], PDO::PARAM_STR);
            $stmt->bindParam(":time", $time, PDO::PARAM_STR);
            $stmt->bindParam(":activity", $activity, PDO::PARAM_STR);

            $stmt->execute();
        }
    }

    if (isset($_POST['del_person_id'])) {
        $stmt = $pdo->prepare("SELECT name, surname FROM person WHERE id = :person_id");
        $person_id = intval($_POST['del_person_id']);
        $stmt->bindParam(':person_id', $person_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $activity = "Deleted person " . $result['name'] . " " . $result['surname'] . " from database";

        $sql = "DELETE FROM placement WHERE id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([intval($_POST['del_person_id'])]);

        $sql = "DELETE FROM person WHERE id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([intval($_POST['del_person_id'])]);

        $sql = "SELECT * FROM person WHERE id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([intval($_POST['del_person_id'])]);
        if ($stmt->rowCount() > 0) {
            echo '<script>alert("Person was not deleted")</script>';
        } else {
            echo '<script>alert("Person was successfully deleted")</script>';
            $sql = "INSERT INTO editLog (email, time, activity) VALUES (:email, :time, :activity)";
            $stmt = $pdo->prepare($sql);

            $current_time = time();
            $time = date('Y-m-d H:i:s', $current_time);

            $stmt->bindParam(":email", $_SESSION['email'], PDO::PARAM_STR);
            $stmt->bindParam(":time", $time, PDO::PARAM_STR);
            $stmt->bindParam(":activity", $activity, PDO::PARAM_STR);

            $stmt->execute();
        }
    }

    $query = "SELECT * FROM person";
    $stmt = $db->query($query);
    $persons = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
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
    <div class="container-md">
        <h1>Admin panel</h1>
        <h2>Pridaj športovca</h2>
        <form action="#" method="post">
            <div class="mb-3">
                <label for="InputName" class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" id="InputName" placeholder="Janko" required>
            </div>
            <div class="mb-3">
                <label for="InputSurname" class="form-label">Surname:</label>
                <input type="text" name="surname" class="form-control" id="InputSurname" placeholder="Hrasko" required>
            </div>
            <div class="mb-3">
                <label for="InputDate" class="form-label">birth day:</label>
                <input type="date" name="birth_day" class="form-control" id="InputDate" required>
            </div>
            <div class="mb-3">
                <label for="InputbrPlace" class="form-label">birth place:</label>
                <input type="text" name="birth_place" class="form-control" id="InputBrPlace" placeholder="Kabul" required>
            </div>
            <div class="mb-3">
                <label for="InputBrCountry" class="form-label">birth country:</label>
                <input type="text" name="birth_country" class="form-control" id="InputBrCountry" placeholder="Afganistan" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        </form>

        <table class="table">
            <thead>
                <tr>
                    <td>Meno</td>
                    <td>Priezvisko</td>
                    <td>Narodenie</td>
                </tr>
            </thead>
            <tbody>
                <?php //var_dump($results) 
                foreach ($persons as $person) {
                    $date = new DateTimeImmutable($person["birth_day"]);
                    echo "<tr><td><a href='editPerson.php?id=" .  $person["id"] . "'>" . $person["name"] . "</a></td><td>" . $person["surname"] . "</td><td>" . $date->format("d.m.Y") . "</td><td>";
                    echo '<form action="#" method="post"><input type="hidden" name="del_person_id" value="' . $person["id"] . '"><button type="submit" class="btn btn-primary">Vymaz</button></form>';
                    echo '</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Copyright -->
    <div class="text-center p-3 text-white" style="background-color: rgba(0, 0, 0, 0.8);">
        © 2023 Copyright:
        <a class="text-white" href="https://www.instagram.com/markomatuska/">Marko Matuska</a>
    </div>
    <!-- Copyright -->
    </footer>
    <!-- Footer -->
</body>


</html>