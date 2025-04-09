<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Tekstifunktsioonid</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
 <?php
 // h09
 // Mattias Elmers
 // 28.03.2025
 ?>

 <h2>Tervitus</h2>
 <form method="get">
  <label for="nimi">Tervituse nimi:</label>
  <input type="text" id="nimi" name="nimi" class="form-control mb-2">
  <button type="submit" class="btn btn-primary">Tervita</button>
 </form>

 <?php
 if (isset($_GET['nimi'])) {
  echo "Tere, " . ucfirst(strtolower($_GET['nimi']));
 }
 ?>

 <h2>Punktidega sõna</h2>
 <form method="get">
  <label for="tekst">Sisesta sõna:</label>
  <input type="text" id="tekst" name="tekst" class="form-control mb-2">
  <button type="submit" class="btn btn-primary">Punktitan</button>
 </form>

 <?php
 if (isset($_GET['tekst'])) {
  $tekst = $_GET['tekst'];
  for ($i = 0; $i < strlen($tekst); $i++) {
   echo $tekst[$i] . ".";
  }
 }
 ?>

 <h2>Ropenduste asendamine</h2>
 <form method="get">
  <label for="ropp">Sisesta tekst:</label>
  <input type="text" id="ropp" name="ropp" class="form-control mb-2">
  <button type="submit" class="btn btn-primary">Asenda</button>
 </form>

 <?php
 if (isset($_GET['ropp'])) {
  $ropp = $_GET['ropp'];
  $asendatav = ['puts', 'lits', 'taun', 'ropp'];
  $asendus = str_replace($asendatav, '****', $ropp);
  echo $asendus;
 }
 ?>

 <h2>Emaili genereerimine</h2>
 <form method="get">
  <label for="nimi">Eesnimi:</label>
  <input type="text" id="nimi" name="nimi" class="form-control mb-2">
  <label for="perenimi">Perekonnanimi:</label>
  <input type="text" id="perenimi" name="perenimi" class="form-control mb-2">
  <button type="submit" class="btn btn-primary">Genereeri email</button>
 </form>

 <?php
 if (isset($_GET['nimi']) && isset($_GET['perenimi'])) {
  $imeliktaht = ['ä', 'ö', 'ü', 'õ', 'š', 'ž'];
  $asendus2 = ['a', 'o', 'u', 'o', 's', 'z'];
  $nimi = str_replace($imeliktaht, $asendus2, $_GET['nimi']);
  $perenimi = str_replace($imeliktaht, $asendus2, $_GET['perenimi']);
  echo strtolower($nimi) . "." . strtolower($perenimi) . "@hkhk.edu.ee";
 }
 ?>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>