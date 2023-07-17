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
  <script src="script.js"></script>
</head>

<body>
  <header>
    <hgroup>
      <h1 style="margin-top: 1.2em;">Sprava pouzivatelov</h1>
    </hgroup>
  </header>
  <main>

    <?php

    session_start();

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_SESSION['login_id'])) {
      // Neprihlaseny pouzivatel, zobraz odkaz na Login alebo Register stranku.
      echo '<p>Nie ste prihlaseny, prosim <a href="register-login/login.php">prihlaste sa pomocou mena a hesla</a>/<a href="google-login/login.php">pomocou google</a> alebo sa <a href="register-login/register.php">zaregistrujte</a>.</p>';
    }/*  else {
            // Prihlaseny pouzivatel, zobraz odkaz na zabezpecenu stranku.
            echo '<h3>Vitaj ' . $_SESSION['fullname'] . ' </h3>';
            echo '<a href="register-login/restricted.php">Zabezpecena stranka</a>';
        } */

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
</body>

</html>