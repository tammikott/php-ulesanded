<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Funktsioonid</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
 <?php
 // h07
 // Ott Tammik
 // 03.03.2025

 echo "<h2>Tervitus</h2>";
 function tervita() {
  echo "Tere päiksekesekene!";
 }
 tervita();

 echo "<h2>Liitu uudiskirjaga</h2>";
 function vorm() {
  echo '<form method="get">';
  echo 'Vormi küsimus: <input type="text" name="vastus" class="form-control"><br>';
  echo '<input type="submit" value="Vasta" class="btn btn-primary"><br>';
  echo '</form>';
 }
 vorm();

 echo "<h2>Kasutajanimi ja email</h2>";
 ?>
 <form method="get">
  <label for="kasutajanimi">Kasutajanimi:</label>
  <input type="text" id="kasutajanimi" name="kasutajanimi" class="form-control mb-2">
  <button type="submit" class="btn btn-primary">Genereeri</button>
 </form>
 <?php
 if (isset($_GET['kasutajanimi'])) {
  $kasutaja = $_GET['kasutajanimi'];
  function gmail($kasutaja) {
   return strtolower($kasutaja) . '@gmail.com';
  }
  echo "<h2>Teie email:</h2>";
  echo gmail($kasutaja);
  echo "<h2>Teie kood:</h2>";
  echo substr(uniqid(), -7);
 }

 echo "<h2>Arvud:</h2>";
 ?>
 <form method="get">
  <label for="arv1">Arv 1:</label>
  <input type="number" id="arv1" name="arv1" class="form-control mb-2">
  <label for="arv2">Arv 2:</label>
  <input type="number" id="arv2" name="arv2" class="form-control mb-2">
  <label for="samm">Samm:</label>
  <input type="number" id="samm" name="samm" class="form-control mb-2">
  <button type="submit" class="btn btn-primary">Arvuta</button>
 </form>
 <?php
 if (isset($_GET['arv1'], $_GET['arv2'], $_GET['samm'])) {
  $arv1 = $_GET['arv1'];
  $arv2 = $_GET['arv2'];
  $samm = $_GET['samm'];
  function arvud($arv1, $arv2, $samm) {
   echo "Arvud:<br>";
   for ($i = $arv1; $i <= $arv2; $i++) {
    if ($i % $samm == 0) {
     echo $i . ", ";
    }
   }
  }
  arvud($arv1, $arv2, $samm);
 }

 echo "<h2>Ristküliku pindala</h2>";
 ?>
 <form method="get">
  <label for="kulg1">Külg 1:</label>
  <input type="number" id="kulg1" name="kulg1" class="form-control mb-2">
  <label for="kulg2">Külg 2:</label>
  <input type="number" id="kulg2" name="kulg2" class="form-control mb-2">
  <button type="submit" class="btn btn-primary">Arvuta</button>
 </form>
 <?php
 if (isset($_GET['kulg1'], $_GET['kulg2'])) {
  $kulg1 = $_GET['kulg1'];
  $kulg2 = $_GET['kulg2'];
  function pindala($kulg1, $kulg2) {
   return $kulg1 * $kulg2;
  }
  echo "<h2>Pindala on:</h2>";
  echo pindala($kulg1, $kulg2);
 }

 echo "<h2>Isikukood</h2>";
 ?>
 <form method="get">
  <label for="isikukood">Isikukood:</label>
  <input type="number" id="isikukood" name="isikukood" class="form-control mb-2">
  <button type="submit" class="btn btn-primary">Kontrolli</button>
 </form>
 <?php
 if (isset($_GET['isikukood'])) {
  $isikukood = $_GET['isikukood'];
  function isikukood($isikukood) {
   $result = "";
   if (strlen($isikukood) == 11) {
    $result .= "Isikukood on õige pikkusega<br>";
   } else {
    $result .= "Isikukood on vale pikkusega<br>";
   }
   $result .= "Sugu: ";
   $result .= substr($isikukood, 0, 1) % 2 == 0 ? "Naine<br>" : "Mees<br>";
   $result .= "Sünniaeg: ";
   $result .= substr($isikukood, 5, 2) . "." . substr($isikukood, 3, 2) . "." . substr($isikukood, 1, 2);
   return $result;
  }
  echo isikukood($isikukood);
 }

 echo "<h2>Head mõtted:</h2>";
 function motted() {
  $alus = ["Tarkus", "Õnn", "Armastus", "Rõõm", "Jõud", "Tervis", "Raha", "Edu", "Sõprus", "Pere"];
  $oeldis = ["on", "toob", "teeb", "aitab", "võimaldab", "tagab", "kingib", "tõstab", "aitab", "loob"];
  $sihitis = ["targaks", "õnnelikuks", "armastavaks", "rõõmsaks", "jõuliseks", "terveks", "jõukaks", "edukaks", "sõbralikuks", "perekeskseks"];
  echo $alus[array_rand($alus)] . " " . $oeldis[array_rand($oeldis)] . " " . $sihitis[array_rand($sihitis)];
 }
 motted();
 ?>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>