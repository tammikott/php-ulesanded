<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>masiivid</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
 <?php
 // h05
 // Mattias Elmers
 // 14.02.2025

 echo "<h2>Masiiv:</h2>";
 $nimed = ['mari', 'kati', 'juhan', 'miku', 'uku', 'miiu', 'lote'];
 sort($nimed);

 foreach ($nimed as $nimi) {
  echo $nimi . '<br>';
 }

 echo "<h2>Esimesed 3 nime:</h2>";
 echo implode('<br>', array_slice($nimed, 0, 3)) . '<br>';

 echo "<h2>Viimane nimi:</h2>";
 echo end($nimed) . '<br>';

 echo "<h2>Suvaline nimi:</h2>";
 echo $nimed[array_rand($nimed)] . '<br>';

 echo "<h1>Autod</h1>";
 $margid = ["Subaru", "BMW", "Acura", "Mercedes-Benz", "Toyota", "Volkswagen"];
 $vinkoodid = ["1GKS1GKC8FR966658", "1FTEW1C87AK375821", "1G4GF5E30DF760067"];

 echo "<h2>Autode arv:</h2>";
 echo count($margid) . '<br>';

 echo "<h2>Kas masiivid on võrdsed:</h2>";
 echo count($margid) === count($vinkoodid) ? "Jah" : "Ei";

 echo "<h2>Toyotade arv:</h2>";
 echo count(array_filter($margid, fn($mark) => $mark === "Toyota")) . '<br>';

 echo "<h2>Lühikesed VIN koodid:</h2>";
 foreach ($vinkoodid as $vin) {
  if (strlen($vin) < 17) {
   echo $vin . '<br>';
  }
 }

 echo "<h1>Palkade keskmine:</h1>";
 $palk = [1220, 1213, 1295, 1312, 1298, 1354];
 echo array_sum($palk) / count($palk) . '<br>';

 echo "<h1>Firmad</h1>";
 $firmad = ["Kimia", "Mynte", "Voomm", "Twiyo", "Layo"];
 sort($firmad);

 foreach ($firmad as $firma) {
  echo $firma . '<br>';
 }
 ?>
 <h2>Eemaldus</h2>
 <form method="get">
  <label for="eemaldus">Millist firmat soovite eemaldada:</label>
  <input type="text" id="eemaldus" name="eemaldus" class="form-control mb-2">
  <button type="submit" class="btn btn-primary">Eemalda</button>
 </form>
 <?php
 if (!empty($_GET["eemaldus"])) {
  $eemaldus = $_GET["eemaldus"];
  $firmad = array_diff($firmad, [$eemaldus]);
  foreach ($firmad as $firma) {
   echo $firma . '<br>';
  }
 }
 ?>

 <h1>Riigid</h1>
 <?php
 $riigid = ["Indonesia", "Canada", "Germany", "Philippines", "Brazil"];
 echo "<h2>Kõige pikema riigi nime märkide arv:</h2>";
 echo max(array_map('strlen', $riigid)) . '<br>';
 ?>

 <h1>Hiina nimed</h1>
 <?php
 $hiina = ["瀚聪", "月松", "雨萌", "展博", "雪丽"];
 sort($hiina);
 echo "<h2>Esimene nimi:</h2>";
 echo $hiina[0] . '<br>';
 echo "<h2>Viimane nimi:</h2>";
 echo end($hiina) . '<br>';
 ?>

 <h1>Google nimed</h1>
 <form method="get">
  <label for="kontroll">Millist nime soovid kontrollida:</label>
  <input type="text" id="kontroll" name="kontroll" class="form-control mb-2">
  <button type="submit" class="btn btn-primary">Kontrolli</button>
 </form>
 <?php
 $google = ["Feake", "Bradwell", "Dreger", "Bloggett"];
 if (!empty($_GET["kontroll"])) {
  $kontroll = $_GET["kontroll"];
  echo in_array($kontroll, $google)
   ? '<div class="alert alert-success">Nimi on olemas</div>'
   : '<div class="alert alert-danger">Nimi ei ole olemas</div>';
 }
 ?>

 <h1>Pildid</h1>
 <?php
 $pildid = ["img/prentice.jpg", "img/freeland.jpg", "img/peterus.jpg"];
 echo "<h2>Kolmas pilt:</h2>";
 echo '<img src="' . $pildid[2] . '" alt="Pilt" class="rounded-circle" style="width:200px;height:200px;margin:10px;"><br>';
 echo "<h2>Kõik pildid:</h2>";
 foreach ($pildid as $pilt) {
  echo '<img src="' . $pilt . '" alt="Pilt" class="rounded-circle" style="width:200px;height:200px;margin:10px;">';
 }
 ?>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>