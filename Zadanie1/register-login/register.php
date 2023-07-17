<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// Konfiguracia PDO
require_once '../config.glogal.php';
// Kniznica pre 2FA
require_once '../GoogleAuthenticator-master/PHPGangsta/GoogleAuthenticator.php';

// ------- Pomocne funkcie -------
function checkEmpty($field)
{
    // Funkcia pre kontrolu, ci je premenna po orezani bielych znakov prazdna.
    // Metoda trim() oreze a odstrani medzery, tabulatory a ine "whitespaces".
    if (empty(trim($field))) {
        return true;
    }
    return false;
}

function checkLength($field, $min, $max)
{
    // Funkcia, ktora skontroluje, ci je dlzka retazca v ramci "min" a "max".
    // Pouzitie napr. pre "login" alebo "password" aby mali pozadovany pocet znakov.
    $string = trim($field);     // Odstranenie whitespaces.
    $length = strlen($string);      // Zistenie dlzky retazca.
    if ($length < $min || $length > $max) {
        return false;
    }
    return true;
}

function checkUsername($username)
{
    // Funkcia pre kontrolu, ci username obsahuje iba velke, male pismena, cisla a podtrznik.
    if (!preg_match('/^[a-zA-Z0-9_]+$/', trim($username))) {
        return false;
    }
    return true;
}

function checkName($name)
{
    if (preg_match('/^[a-zA-Z]+$/', $name)) {
        return true;
    } else {
        return false;
    }
}

function checkGmail($email)
{
    // Funkcia pre kontrolu, ci zadany email je gmail.
    if (!preg_match('/^[\w.+\-]+@gmail\.com$/', trim($email))) {
        return false;
    }
    return true;
}

function userExist($db, $login, $email)
{
    // Funkcia pre kontrolu, ci pouzivatel s "login" alebo "email" existuje.
    $exist = false;

    $param_login = trim($login);
    $param_email = trim($email);

    $sql = "SELECT id FROM users WHERE login = :login OR email = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":login", $param_login, PDO::PARAM_STR);
    $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $exist = true;
    }

    unset($stmt);

    return $exist;
}

// ------- ------- ------- -------



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errmsg = "";

    // Validacia username
    if (checkEmpty($_POST['login']) === true) {
        $errmsg .= "<p>Zadajte login.</p>";
    } elseif (checkLength($_POST['login'], 6, 32) === false) {
        $errmsg .= "<p>Login musi mat min. 6 a max. 32 znakov.</p>";
    } elseif (checkUsername($_POST['login']) === false) {
        $errmsg .= "<p>Login moze obsahovat iba velke, male pismena, cislice a podtrznik.</p>";
    }

    // Kontrola pouzivatela
    if (userExist($pdo, $_POST['login'], $_POST['email']) === true) {
        $errmsg .= "Pouzivatel s tymto e-mailom / loginom uz existuje.</p>";
    }

    // Validacia mailu
    if (checkGmail($_POST['email'])) {
        $errmsg .= "Prihlaste sa pomocou Google prihlasenia";
        header("Location: ../google-login/login.php");
    }

    // Validacia hesla
    if (checkLength($_POST['login'], 6, 32) === false) {
        $errmsg .= "<p>Heslo musi mat min. 6 a max. 32 znakov.</p>";
    }
    // Validacia mena, priezviska
    if (checkName($_POST['firstname']) === false) {
        $errmsg .= "<p>Meno musi obsahovat iba znaky.</p>";
    }
    if (checkName($_POST['lastname']) === false) {
        $errmsg .= "<p>Priezvisko musi obsahovat iba znaky.</p>";
    }



    if (empty($errmsg)) {
        $sql = "INSERT INTO users (fullname, login, email, password, 2fa_code) VALUES (:fullname, :login, :email, :password, :2fa_code)";

        $fullname = $_POST['firstname'] . ' ' . $_POST['lastname'];
        $email = $_POST['email'];
        $login = $_POST['login'];
        $hashed_password = password_hash($_POST['password'], PASSWORD_ARGON2ID);

        // 2FA pomocou PHPGangsta kniznice: https://github.com/PHPGangsta/GoogleAuthenticator
        $g2fa = new PHPGangsta_GoogleAuthenticator();
        $user_secret = $g2fa->createSecret();
        $codeURL = $g2fa->getQRCodeGoogleUrl('Olympic Games', $user_secret);

        // Bind parametrov do SQL
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":fullname", $fullname, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":login", $login, PDO::PARAM_STR);
        $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(":2fa_code", $user_secret, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // qrcode je premenna, ktora sa vykresli vo formulari v HTML.
            $qrcode = $codeURL;
        } else {
            echo "Ups. Nieco sa pokazilo";
        }

        unset($stmt);
    }
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
    <title>Login/register s 2FA - Register</title>

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
            align-items: center;
        }

        a {
            color: #000;
        }
    </style>
</head>

<body>
    <header>
        <hgroup>
            <h1>Registrácia.</h1>
            <h2>Vytvorenie noveho konta pouzivatela</h2>
        </hgroup>
    </header>
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
                                <a class="nav-link" href=".../profile.php">Profil</a>
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
    <main>


        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label for="firstname">
                Meno:
                <input type="text" name="firstname" value="" id="firstname" placeholder="napr. Jonatan" required>
            </label>

            <label style="margin-left: -50px;" for="lastname">
                Priezvisko:
                <input type="text" name="lastname" value="" id="lastname" placeholder="napr. Petrzlen" required>
            </label>

            <br>

            <label for="email">
                E-mail:
                <input type="email" name="email" value="" id="email" placeholder="napr. jpetrzlen@example.com" required>
            </label>

            <label for="login">
                Login:
                <input type="text" name="login" value="" id="login" placeholder="napr. jperasin" required">
            </label>

            <br>

            <label for="password">
                Heslo:
                <input type="password" name="password" value="" id="password" required>
            </label>

            <button type="submit">Vytvorit konto</button>

            <?php
            if (!empty($errmsg)) {
                // Tu vypis chybne vyplnene polia formulara.
                echo $errmsg;
            }
            if (isset($qrcode)) {
                // Pokial bol vygenerovany QR kod po uspesnej registracii, zobraz ho.
                $message = '<p>Naskenujte QR kod do aplikacie Authenticator pre 2FA: <br><img src="' . $qrcode . '" alt="qr kod pre aplikaciu authenticator"></p>';

                echo $message;
                echo '<p>Teraz sa mozte prihlasit: <a href="login.php" role="button">Login</a></p>';
            }
            ?>

        </form>
        <p>Mate vytvorene konto? <a href="login.php">Prihlaste sa tu.</a></p>
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