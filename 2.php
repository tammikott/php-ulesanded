<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>H02 PHP</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="container mt-4">
 <?php
 // h02
 // Ott Tammik
 // 05.04.2025

 echo "<h2>Matemaatilised tehteid</h2>";
 $x = 2; $y = 3;
 echo "$x + $y = " . ($x + $y) . "<br>";
 echo "$x - $y = " . ($x - $y) . "<br>";
 echo "$x * $y = " . ($x * $y) . "<br>";
 echo "$x / $y = " . number_format($x / $y, 2) . "<br>";
 ?>

 <h2>Teisendamine</h2>
 <form method="get">
  <label for="nr">Sisesta mm:</label>
  <input type="number" id="nr" name="nr" class="form-control mb-2">
  <button type="submit" class="btn btn-primary">Arvuta</button>
 </form>

 <?php
 if (!empty($_GET["nr"])) {
  $nr = (float)$_GET["nr"];
  echo "<p>$nr mm on " . ($nr / 10) . " cm</p>";
  echo "<p>$nr mm on " . ($nr / 1000) . " m</p>";
 }
 ?>

 <h2>kolmnurk</h2>
 <form method="get">
  <label for="a">Külg 1:</label>
  <input type="number" id="a" name="a" class="form-control mb-2">
  <label for="b">Külg 2:</label>
  <input type="number" id="b" name="b" class="form-control mb-2">
  <label for="c">Külg 3:</label>
  <input type="number" id="c" name="c" class="form-control mb-2">
  <button type="submit" class="btn btn-primary">Arvuta</button>
 </form>

 <?php
 if (!empty($_GET["a"]) && !empty($_GET["b"]) && !empty($_GET["c"])) {
  $a = (float)$_GET["a"];
  $b = (float)$_GET["b"];
  $c = (float)$_GET["c"];

  if ($a + $b > $c && $a + $c > $b && $b + $c > $a) {
   echo "<p>Kolmnurk on võimalik</p>";
   $perimeter = $a + $b + $c;
   echo "<p>Kolmnurga ümbermõõt on $perimeter</p>";

   $s = $perimeter / 2;
   $area = sqrt($s * ($s - $a) * ($s - $b) * ($s - $c));
   echo "<p>Kolmnurga pindala on " . round($area, 2) . "</p>";
  } else {
   echo "<p>Kolmnurk ei ole võimalik</p>";
  }
 }
 ?>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>