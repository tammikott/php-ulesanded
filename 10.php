<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Esimene PHP</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
 <ul>
  <li>
   <a href="h10.php">Avaleht</a>
   <a href="h10.php?leht=portfoolio">Portfoolio</a>
   <a href="h10.php?leht=kaart">Kaart</a>
   <a href="h10.php?leht=kontakt">Kontakt</a>
  </li>
 </ul>

 <?php
 // h010
 // Ott Tammik
 // 05.04.2025

 if (!empty($_GET['leht'])) {
  $leht = htmlspecialchars($_GET['leht']);
  $lubatud = ['portfoolio', 'kaart', 'kontakt', 'minust'];
  if (in_array($leht, $lubatud)) {
   include($leht . '.php');
  } else {
   echo "<br>";
   echo '<div class="alert alert-danger">Leht ei eksisteeri</div>';
  }
 }
 ?>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>