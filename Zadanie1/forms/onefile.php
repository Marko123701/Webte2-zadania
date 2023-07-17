<html>
  <head>
     <meta charset="UTF-8"> 
     <style>
        label
        {
            width: 6em;
            float: left;
        }
    </style>
  </head>
<body>

 <?php
  if ($_POST['submit']) {
    $meno = $_POST['meno'];
    $vek = $_POST['vek'];
    echo $meno."<br>";
    echo $vek."<br><br>";
    
    echo "<a href='onefile.php'>Choď späť na formulár</a>"; 
  }
  else
  { ?>
    <form action="onefile.php" method="post">
      <p>
        <label for="meno">Meno: </label>
        <input type="text" name="meno" id="meno"> 
      </p>
      <p>
        <label for="vek">Vek: </label>
        <input type="text" name="vek" id="vek"> 
      </p>
    <input type="submit" name="submit">
    </form> 
  <?php }
 ?>

</body>
</html> 