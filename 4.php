<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>h04</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="container mt-4">
 <?php
 // h04
 // Ott Tammik
 // 05.04.2025
 ?>

 <h2>Jagamine</h2>
 <form method="get">
  <label for="nr1">Nr1:</label>
  <input type="number" id="nr1" name="nr1" class="form-control mb-2">
  <label for="nr2">Nr2:</label>
  <input type="number" id="nr2" name="nr2" class="form-control mb-2">
  <button type="submit" class="btn btn-primary">Arvuta</button>
 </form>

 <?php
 if (isset($_GET["nr1"]) && isset($_GET["nr2"])) {
  $nr1 = (float)$_GET["nr1"];
  $nr2 = (float)$_GET["nr2"];
  if ($nr1 == 0 || $nr2 == 0) {
   echo "Nulliga ei saa jagada<br>";
  } else {
   printf("%d / %d = %.2f <br>", $nr1, $nr2, $nr1 / $nr2);
  }
 }
 ?>

 <h2>Kumb on vanem</h2>
 <form method="get">
  <label for="kasutaja1">Kasutaja 1 vanus:</label>
  <input type="number" id="kasutaja1" name="kasutaja1" class="form-control mb-2">
  <label for="kasutaja2">Kasutaja 2 vanus:</label>
  <input type="number" id="kasutaja2" name="kasutaja2" class="form-control mb-2">
  <button type="submit" class="btn btn-primary">Arvuta</button>
 </form>

 <?php
 if (isset($_GET["kasutaja1"]) && isset($_GET["kasutaja2"])) {
  $k1 = (int)$_GET["kasutaja1"];
  $k2 = (int)$_GET["kasutaja2"];
  if ($k1 > $k2) {
   echo "Kasutaja 1 on vanem<br>";
  } elseif ($k1 < $k2) {
   echo "Kasutaja 2 on vanem<br>";
  } else {
   echo "Kasutajad on sama vanad<br>";
  }
 }
 ?>

 <h2>Ristkülik või ruut</h2>
 <form method="get">
  <label for="kulg1">Külg 1:</label>
  <input type="number" id="kulg1" name="kulg1" class="form-control mb-2">
  <label for="kulg2">Külg 2:</label>
  <input type="number" id="kulg2" name="kulg2" class="form-control mb-2">
  <label for="kulg3">Külg 3:</label>
  <input type="number" id="kulg3" name="kulg3" class="form-control mb-2">
  <label for="kulg4">Külg 4:</label>
  <input type="number" id="kulg4" name="kulg4" class="form-control mb-2">
  <button type="submit" class="btn btn-primary">Arvuta</button>
 </form>

 <?php
 if (isset($_GET["kulg1"], $_GET["kulg2"], $_GET["kulg3"], $_GET["kulg4"])) {
  $k1 = (int)$_GET["kulg1"];
  $k2 = (int)$_GET["kulg2"];
  $k3 = (int)$_GET["kulg3"];
  $k4 = (int)$_GET["kulg4"];
  if ($k1 == $k2 && $k2 == $k3 && $k3 == $k4) {
   echo "Ruut<br>";
  } elseif ($k1 == $k3 && $k2 == $k4) {
   echo "Ristkülik<br>";
  } else {
   echo "Ei ole ristkülik ega ruut<br>";
  }
 }
 ?>

 <h2>Juubel?</h2>
 <form method="get">
  <label for="synniaasta">Sinu sünniaasta:</label>
  <input type="number" id="synniaasta" name="synniaasta" class="form-control mb-2">
  <button type="submit" class="btn btn-primary">Arvuta</button>
 </form>

 <?php
 if (isset($_GET["synniaasta"])) {
  $synniaasta = (int)$_GET["synniaasta"];
  $vanus = 2025 - $synniaasta;
  if ($vanus % 10 == 0 || $vanus % 10 == 5) {
   echo "Juubel<br>";
  } else {
   echo "Ei ole juubel<br>";
  }
 }
 ?>

 <h2>Hinne</h2>
 <form method="get">
  <label for="punktid">Sisesta punktide summa:</label>
  <input type="number" id="punktid" name="punktid" class="form-control mb-2">
  <button type="submit" class="btn btn-primary">Arvuta</button>
 </form>

 <?php
 if (isset($_GET["punktid"])) {
  $punktid = (int)$_GET["punktid"];
  if ($punktid >= 10) {
   echo "SUPER!!<br>";
  } elseif ($punktid >= 5) {
   echo "TEHTUD!<br>";
  } else {
   echo "KASIN!<br>";
  }
 }
 ?>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>