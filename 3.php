<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>H03 PHP</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="container mt-4">
 <?php
 // h03
 // Ott Tammik
 // 05.04.2025
 ?>

 <h2>Trapetsi pindala</h2>
 <form method="get">
  <label for="a">Alus 1:</label>
  <input type="number" id="a" name="a" class="form-control mb-2">
  <label for="b">Alus 2:</label>
  <input type="number" id="b" name="b" class="form-control mb-2">
  <label for="c">Kõrgus:</label>
  <input type="number" id="c" name="c" class="form-control mb-2">
  <button type="submit" class="btn btn-primary">Arvuta</button>
 </form>

 <?php
 if (!empty($_GET["a"]) && !empty($_GET["b"]) && !empty($_GET["c"])) {
  $a = (float)$_GET["a"];
  $b = (float)$_GET["b"];
  $c = (float)$_GET["c"];
  $area = ($a + $b) / 2 * $c;
  echo "<p>Pindala on " . number_format($area, 1) . "</p>";
 }
 ?>

 <h2>Rombi ümbermõõt</h2>
 <form method="get">
  <label for="d">Külg:</label>
  <input type="number" id="d" name="d" class="form-control mb-2">
  <button type="submit" class="btn btn-primary">Arvuta</button>
 </form>

 <?php
 if (!empty($_GET["d"])) {
  $d = (float)$_GET["d"];
  $perimeter = 4 * $d;
  echo "<p>Ümbermõõt on $perimeter</p>";
 }
 ?>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>