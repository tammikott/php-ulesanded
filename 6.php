<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Tsyklid</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
 <?php
 // h06
 // Ott Tammik
 // 05.04.2025

 echo "<h2>Genereeri</h2>";
 for ($i = 1; $i <= 100; $i++) {
  echo $i . ".";
  if ($i % 10 == 0) {
   echo "<br>";
  }
 }

 echo "<h2>Rida</h2>";
 for ($i = 1; $i <= 10; $i++) {
  echo "*";
 }

 echo "<h2>Rida vertikaalselt</h2>";
 for ($i = 1; $i <= 10; $i++) {
  echo "*<br>";
 }
 ?>
 <h2>Ruut</h2>
 <form method="get">
  <label for="nr1">Külg:</label>
  <input type="number" id="nr1" name="nr1" class="form-control mb-2">
  <button type="submit" class="btn btn-primary">Genereeri</button>
 </form>

 <?php
 if (isset($_GET["nr1"])) {
  $nr1 = (int)$_GET["nr1"];
  echo "<h2>Ruut:</h2>";
  for ($i = 1; $i <= $nr1; $i++) {
   for ($j = 1; $j <= $nr1; $j++) {
    echo "* ";
   }
   echo "<br>";
  }
 }

 echo "<h2>Kahanevad arvud</h2>";
 for ($i = 10; $i >= 1; $i--) {
  echo $i . "<br>";
 }

 echo "<h2>Kolmega jagunevad</h2>";
 for ($i = 1; $i <= 100; $i++) {
  if ($i % 3 == 0) {
   echo $i . "<br>";
  }
 }

 echo "<h2>Massiivid ja tsüklid</h2>";
 $tydrukud = ['mari', 'kati', 'miku', 'miiu'];
 $poisid = ['juhan', 'jaanus', 'johannes', 'matu'];

 echo "<h2>Poiste ja tüdrukute paarid:</h2>";
 for ($i = 0; $i < count($tydrukud); $i++) {
  echo $tydrukud[$i] . ' - ' . $poisid[$i] . '<br>';
 }
 ?>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>