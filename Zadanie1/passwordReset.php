<?php
session_start();

include 'config.php';

if (!isset($_SESSION['loggedin'])) {
    $_SESSION['error'] = 'You must be logged in to change your password';
    header('Location: register-login/register.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
$stmt->execute([$_SESSION['email']]);
$user = $stmt->fetch();
$current_password = $user['password'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!password_verify($_POST['current_password'], $current_password)) {
        $_SESSION['error'] = 'Zlé heslo';
        header('Location: passwordReset.php');
        exit;
    }

    $new_password = password_hash($_POST['new_password'], PASSWORD_ARGON2ID);

    $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE email = ?');
    $stmt->execute([$new_password, $_SESSION['email']]);

    $_SESSION['success'] = 'Heslo úspešne zmenené';
    header('Location: passwordReset.php');
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.css" rel="stylesheet">
    <title>Password Change Form</title>
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
    <main>
        <h1>Zmena hesla</h1>
        <?php if (isset($_SESSION['error'])) : ?>
            <p style="color:red"><?php echo $_SESSION['error']; ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])) : ?>
            <p style="color:green"><?php echo $_SESSION['success']; ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <form method="post">
            <label for="current_password">Momentálne heslo:</label>
            <input type="password" name="current_password" id="current_password">
            <br><br>
            <label for="new_password">Nové heslo:</label>
            <input type="password" name="new_password" id="new_password">
            <br><br>
            <input type="submit" value="Zmeň heslo">
        </form>
    </main>

    <!-- Copyright -->
    <div class="text-center p-3 text-white mt-3" style="background-color: rgba(0, 0, 0, 0.8);">
        © 2023 Copyright:
        <a class="text-white" href="https://www.instagram.com/markomatuska/">Marko Matuska</a>
    </div>
    <!-- Copyright -->
    </footer>
    <!-- Footer -->
</body>

</html>