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
    <h2 style="margin-top: 0.5em; text-align: center;">Profil</h2>
    <main>

        <?php
        require 'config.php';
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        session_start();

        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header('Location: register.php');
            exit;
        } else {

            // Prihlaseny pouzivatel, zobraz odkaz na zabezpecenu stranku.
            echo '<h3>Vitaj ' . $_SESSION['fullname'] . ' </h3>';
            echo '<a href="passwordReset.php">Zmena hesla</a>';
            // Check if the button was clicked
            if (isset($_SESSION["2fa_active"])) {
                if (isset($_POST['f2on'])) {
                    $_SESSION["2fa_active"] = !$_SESSION["2fa_active"];
                }
            } else {
                $_SESSION["2fa_active"] = true;
            }

            // Output the HTML button
            echo '<form method="post">
            <button type="submit" name="f2on" value="1">Vypni 2fa</button>
            </form>';

            if ($_SESSION["2fa_active"]) {
                echo '<p>Momentálne zapnuté</p>';
                $sql = "UPDATE users SET 2fa_active=? where email=?";
                $stmt = $pdo->prepare($sql);
                $success = $stmt->execute(["true", $_SESSION["email"]]);
            } else {
                echo '<p>Momentálne vypnuté</p>';
                $sql = "UPDATE users SET 2fa_active=? where email=?";
                $stmt = $pdo->prepare($sql);
                $success = $stmt->execute(["false", $_SESSION["email"]]);
            }

            $sql = "SELECT * FROM log WHERE email = :email";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(":email", $_SESSION['email'], PDO::PARAM_STR);

            $stmt->execute();

            $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $sql = "SELECT * FROM editLog WHERE email = :email";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(":email", $_SESSION['email'], PDO::PARAM_STR);

            $stmt->execute();

            $editLogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <div>
            <h3>História prihlásení</h3>
            <table class="table display table-striped table-bordered">
                <thead>
                    <tr>
                        <td>Čas prihlásenia</td>
                        <td>Spôsob prihlásenia</td>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($logs as $log)
                        echo '<tr><td>' . $log['time'] . '</td><td>'  . $log['login_type'] . '</td></tr>';
                    ?>
                </tbody>
            </table>
        </div>
        <div>
            <h3>História aktivít</h3>
            <table class="table display table-striped table-bordered">
                <thead>
                    <tr>
                        <td>Čas aktivity</td>
                        <td>Druh aktivity</td>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($editLogs as $editLog)
                        echo '<tr><td>' . $editLog['time'] . '</td><td>'  . $editLog['activity'] . '</td></tr>';
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
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('.table').DataTable();
    })
</script>

</html>