<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');


if (!isset($_GET['id'])) {
    exit("id not exist");
}

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

    
    $query = "SELECT * FROM person where id=?";
    $stmt = $db->prepare($query);
    $stmt->execute([$_GET['id']]);
    $person = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($_POST) && !empty($_POST['name'])) {
        $sql = "UPDATE person SET name=?, surname=?, birth_day=?, birth_place=?, birth_country=? where id=?";
        $stmt = $db->prepare($sql);
        $success = $stmt->execute([$_POST['name'], $_POST['surname'], $_POST['birth_day'], $_POST['birth_place'], $_POST['birth_country'], intval($_POST['person_id'])]);

        if ($success === true) {
            $sql = "INSERT INTO editLog (email, time, activity) VALUES (:email, :time, :activity)";
            $stmt = $pdo->prepare($sql);

            $current_time = time();
            $time = date('Y-m-d H:i:s', $current_time);
            $activity = "Edited " . $_POST['name'] . " " . $_POST['surname'] . " in database";

            $stmt->bindParam(":email", $_SESSION['email'], PDO::PARAM_STR);
            $stmt->bindParam(":time", $time, PDO::PARAM_STR);
            $stmt->bindParam(":activity", $activity, PDO::PARAM_STR);

            $stmt->execute();
            echo '<script>alert("Person was successfully edited")</script>';
        }
    }

    if (isset($_POST['add_placement_id'])) {
        $sql = "INSERT INTO placement (person_id, games_id, placing, discipline) VALUES (?,?,?,?)";
        $stmt = $db->prepare($sql);
        $success = $stmt->execute([intval($_POST['add_placement_id']), intval($_POST['InputOH']), intval($_POST['placing']), $_POST['discipline']]);

        if ($success === true) {
            $sql = "INSERT INTO editLog (email, time, activity) VALUES (:email, :time, :activity)";
            $stmt = $pdo->prepare($sql);

            $current_time = time();
            $time = date('Y-m-d H:i:s', $current_time);
            $activity = "Added placement to " . $person['name'] . " " . $person['surname'] . " with placing: " . intval($_POST['placing']) . " and discipline: " . $_POST['discipline'];

            $stmt->bindParam(":email", $_SESSION['email'], PDO::PARAM_STR);
            $stmt->bindParam(":time", $time, PDO::PARAM_STR);
            $stmt->bindParam(":activity", $activity, PDO::PARAM_STR);

            $stmt->execute();
            echo '<script>alert("Placement was successfully added")</script>';
        }
    }

    if (isset($_POST['del_placement_id'])) {
        $sql = "DELETE FROM placement WHERE id=?";
        $stmt = $db->prepare($sql);
        $success = $stmt->execute([intval($_POST['del_placement_id'])]);

        if ($success === true) {
            $sql = "INSERT INTO editLog (email, time, activity) VALUES (:email, :time, :activity)";
            $stmt = $pdo->prepare($sql);

            $current_time = time();
            $time = date('Y-m-d H:i:s', $current_time);
            $activity = "Deleted placement of " . $person['name'] . " " . $person['surname'] . " with placement id: " . intval($_POST['del_placement_id']);

            $stmt->bindParam(":email", $_SESSION['email'], PDO::PARAM_STR);
            $stmt->bindParam(":time", $time, PDO::PARAM_STR);
            $stmt->bindParam(":activity", $activity, PDO::PARAM_STR);

            $stmt->execute();

            echo '<script>alert("Placement was successfully deleted")</script>';
        }
    }


    $query = "SELECT *
    FROM person
    JOIN placement ON person.id = placement.person_id
    JOIN games ON placement.games_id = games.id";
    $stmt = $db->query($query);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $query = "SELECT * FROM games";
    $stmt = $db->query($query);
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);



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
    <title>Document</title>
    <link rel="stylesheet" href="stylesheet/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
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
        <h2>Info o sportovcovi</h2>
        <form action="#" method="post">
            <input type="hidden" name="person_id" value="<?php echo $person['id']; ?>">
            <div class="mb-3">
                <label for="InputName" class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" id="InputName" value="<?php echo $person['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="InputSurname" class="form-label">Surname:</label>
                <input type="text" name="surname" class="form-control" id="InputSurname" value="<?php echo $person['surname']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="InputDate" class="form-label">birth day:</label>
                <input type="date" name="birth_day" class="form-control" id="InputDate" value="<?php echo $person['birth_day']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="InputbrPlace" class="form-label">birth place:</label>
                <input type="text" name="birth_place" class="form-control" id="InputBrPlace" value="<?php echo $person['birth_place']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="InputBrCountry" class="form-label">birth country:</label>
                <input type="text" name="birth_country" class="form-control" id="InputBrCountry" value="<?php echo $person['birth_country']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Edit</button>
        </form>


        <div>
            <h2>Umiestnenia</h2>
            <form action="#" method="post">
                <input type="hidden" name="add_placement_id" value="<?php echo $person['id']; ?>">
                <div class="mb-3">
                    <label for="InputName" class="form-label">Umiestnenie:</label>
                    <input type="number" name="placing" class="form-control" id="InputPlacing" value="<?php echo $placements[0]['placing']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="InputSurname" class="form-label">Disciplína:</label>
                    <input type="text" name="discipline" class="form-control" id="InputDiscipline" placeholder="vodný slalom - C2" value="<?php if (isset($placement[0]))
                                                                                                                echo $placements[0]['discipline']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="InputOH" class="form-label">OH:</label>
                    <select name="InputOH">
                        <?php
                        foreach ($games as $game) {
                            echo '<option value="' . $game['id'] . '">' . $game['city'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Pridaj</button>
            </form>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <td>Umiestnenie</td>
                    <td>discipline</td>
                    <td>OH</td>
                    <td>Akcia</td>
                </tr>
            </thead>
            <tbody>
                <?php //var_dump($results) 
                foreach ($placements as $placement) {
                    //var_dump($placement);
                    echo '<tr><td>' . $placement['placing'] . '</td><td>' . $placement['discipline'] . '</td><td>' . $placement['city'] . '</td><td>';
                    echo '<form action="#" method="post"><input type="hidden" name="del_placement_id" value="' . $placement['id'] . '"><button type="submit" class="btn btn-primary">Vymaz</button></form>';
                    echo '</td></tr>';
                }
                ?>
            </tbody>
        </table>
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