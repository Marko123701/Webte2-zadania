<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
session_start();

function checkEmpty($field)
{
    // Funkcia pre kontrolu, ci je premenna po orezani bielych znakov prazdna.
    // Metoda trim() oreze a odstrani medzery, tabulatory a ine "whitespaces".
    if (empty(trim($field))) {
        return true;
    }
    return false;
}

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ../admin.php");
    exit;
}

require_once "../config.glogal.php";
require_once '../GoogleAuthenticator-master/PHPGangsta/GoogleAuthenticator.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // TODO: Skontrolovat ci login a password su zadane (podobne ako v register.php).
    if (checkEmpty($_POST['login']) === true) {
        $errmsg .= "<p>Zadajte login.</p>";
    } elseif (checkEmpty($_POST['password']) === true) {
        $errmsg .= "<p>Zadajte heslo.</p>";
    }

    $sql = "SELECT fullname, email, login, password, created_at, 2fa_code, 2fa_active FROM users WHERE (login = :login OR email = :email)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":login", $_POST["login"], PDO::PARAM_STR);
    $stmt->bindParam(":email", $_POST["login"], PDO::PARAM_STR);


    if ($stmt->execute()) {
        if ($stmt->rowCount() == 1) {
            // Uzivatel existuje, skontroluj heslo.
            $row = $stmt->fetch();
            $hashed_password = $row["password"];

            if (password_verify($_POST['password'], $hashed_password)) {
                // Heslo je spravne.
                $g2fa = new PHPGangsta_GoogleAuthenticator();
                if ($g2fa->verifyCode($row["2fa_code"], $_POST['2fa'], 2) || $row["2fa_active"] == 'false') {
                    // Heslo aj kod su spravne, pouzivatel autentifikovany.

                    // Uloz data pouzivatela do session.
                    $_SESSION["loggedin"] = true;
                    $_SESSION["login"] = $row['login'];
                    $_SESSION["fullname"] = $row['fullname'];
                    $_SESSION["email"] = $row['email'];
                    $_SESSION["created_at"] = $row['created_at'];
                    $_SESSION["2fa_active"] = $row["2fa_active"];

                    $sql = "INSERT INTO log (email, time, login_type) VALUES (:email, :time, :login_type)";
                    $stmt = $pdo->prepare($sql);

                    $current_time = time();
                    $time = date('Y-m-d H:i:s', $current_time);
                    $login_type = "register login";

                    $stmt->bindParam(":email", $row['email'], PDO::PARAM_STR);
                    $stmt->bindParam(":time", $time, PDO::PARAM_STR);
                    $stmt->bindParam(":login_type", $login_type, PDO::PARAM_STR);

                    $stmt->execute();

                    // Presmeruj pouzivatela na zabezpecenu stranku.
                    header("location: ../admin.php");
                } else {
                    echo '<script>alert("Neplatny kod 2FA alebo ste ho zabudli zadat a mate zapnute 2FA.")</script>';
                }
            } else {
                echo '<script>alert("Nespravne meno alebo heslo.")</script>';
            }
        } else {
            echo '<script>alert("Nespravne meno alebo heslo.")</script>';
        }
    } else {
        echo '<script>alert("Ups. Nieco sa pokazilo!")</script>';
    }

    unset($stmt);
    unset($pdo);
}

?>

<!doctype html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.css" rel="stylesheet">
    <title>Login/register s 2FA - Login</title>

    <style>
        main {
            text-align: center;
            max-width: 70ch;
            padding: 3em 1em;
            margin: auto;
            line-height: 1.75;
            font-size: 1.25em;
            background-color: #fff;
            color: #000;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin-top: 2em;
            text-align: center;
            color: #000;
        }

        p,
        ul,
        ol {
            color: #000;
            font-family: sans-serif;
        }

        input,
        button {
            background-color: transparent;
            color: #000;
            border: none;
            padding: 0.5em;
            font-size: 1em;
            border-radius: 3px;
            border: 1px solid #000;
        }

        label {
            display: block;

            margin: 1em 0;
        }

        button {
            cursor: pointer;
            font-weight: bold;
            background-color: #000;
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 0.5em 1em;
        }

        form {
            margin-top: 2em;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        a {
            color: #000;
        }
    </style>
</head>

<body>
    <div>
        <nav class="navbar navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="../index.php">Domov</a>
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
                                <a class="nav-link active" aria-current="page" href="../index.php">Domov</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../admin.php">Admin panel</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../profile.php">Profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <header>
        <hgroup>
            <h1>Prihlasenie</h1>
            <h2>Prihlasenie pouzivatela po registracii</h2>
        </hgroup>
    </header>
    <main>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

            <label style="margin-left: -150px;" for="login">
                Prihlasovacie meno:
                <input type="text" name="login" value="" id="login" required>
            </label>
            <br>
            <label for="password">
                Heslo:
                <input type="password" name="password" value="" id="password" required>
            </label>
            <br>
            <label style="margin-left: -40px;" for="2fa">
                2FA kod:
                <input type="number" name="2fa" value="" id="2fa">
            </label>

            <button type="submit">Prihlasit sa</button>
        </form>
        <p>Este nemate vytvorene konto? <a href="register.php">Registrujte sa tu.</a></p>
    </main>
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