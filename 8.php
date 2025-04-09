<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Ajafunktsioonid</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
 <?php
 // h08
 // Ott Tammik
 // 05.04.2025

 echo "<h2>Kuupäev ja kellaaeg:</h2>";
 echo date('d.m.Y G:i', time()) . "<br>";
 ?>

 <h2>Sinu vanus</h2>
 <form method="get">
  <label for="aasta">Sisesta enda sünniaasta:</label>
  <input type="number" id="aasta" name="aasta" class="form-control mb-2">
  <button type="submit" class="btn btn-primary">Arvuta</button>
 </form>

 <?php
 if (isset($_GET["aasta"])) {
  $aasta = (int)$_GET["aasta"];
  $vanus = date('Y') - $aasta;
  echo "<h2>Oled $vanus aastat vana</h2>";
 }

 $tana = strtotime(date('Y-m-d'));
 $koolLopp = strtotime("2025-06-10");
 $paevad = ($koolLopp - $tana) / (60 * 60 * 24);

 echo "<h2>Kooli aasta lõpuni on jäänud:</h2>";
 echo floor($paevad) . " päeva<br>";

 echo "<h2>Aastaaeg:</h2>";
 $kuu = date('n');
 if ($kuu >= 3 && $kuu <= 5) {
  echo '<img src="img/kevad.png" alt="Kevad" class="img-fluid">';
 } elseif ($kuu >= 6 && $kuu <= 8) {
  echo '<img src="img/suvi.png" alt="Suvi" class="img-fluid">';
 } elseif ($kuu >= 9 && $kuu <= 11) {
  echo '<img src="img/sügis.png" alt="Sügis" class="img-fluid">';
 } else {
  echo '<img src="img/talv.png" alt="Talv" class="img-fluid">';
 }
 ?>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>