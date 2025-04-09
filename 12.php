<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Töö CSV failidega</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
 <h2>Sõiduaeg</h2>

<form action="" method="get">
 <div class="mb-3">
  <label class="form-label">Sisesta oma nimi!</label>
  <input type="text" class="form-control" name="kasutaja">
 </div>
 <div class="mb-3">
  <label class="form-label">Sõidu alustus aeg: [hh:mm]</label>
  <input type="text" class="form-control" name="algus">
 </div>
 <div class="mb-3">
  <label class="form-label">Sõidu lõpetamise aeg: [hh:mm]</label>
  <input type="text" class="form-control" name="lopp">
 </div>
 <button type="submit" class="btn btn-primary">Saada</button>
</form>

<?php
// h12
// Ott Tammik
// 05.04.2025
if (isset($_GET["kasutaja"]) && isset($_GET["algus"]) && isset($_GET["lopp"])) {
    $kasutaja = $_GET["kasutaja"];
    $algus_sisend = $_GET["algus"];
    $lopp_sisend = $_GET["lopp"];

    if (strpos($algus_sisend, ":") !== false && strpos($lopp_sisend, ":") !== false) {
        $algus = explode(":", $algus_sisend);
        $lopp = explode(":", $lopp_sisend);

        $algus_minutites = (int)$algus[0] * 60 + (int)$algus[1];
        $lopp_minutites = (int)$lopp[0] * 60 + (int)$lopp[1];

        $soiduaeg = $lopp_minutites - $algus_minutites;
        $tunnid = floor($soiduaeg / 60);
        $minutid = $soiduaeg % 60;

        echo "Tere, $kasutaja! Teie sõiduaeg on $tunnid tundi ja $minutid minutit.";
    } else {
        echo "Palun sisesta algus- ja lõppaeg õigel kujul (hh:mm)!";
    }
}

?>

<h2>Palkade võrdlus</h2>

<?php
// h12
// Ott Tammik
// 05.04.2025

$allikas = 'csv/tootajad.csv';

if (file_exists($allikas)) {
    $fail = fopen($allikas, 'r');

    $meeste_palk = 0;
    $naiste_palk = 0;
    $meeste_arv = 0;
    $naiste_arv = 0;
    $meeste_max = 0;
    $naiste_max = 0;

    while (($rida = fgetcsv($fail, 1000, ";")) !== false) {
        if (count($rida) >= 3) {
            $nimi = $rida[0];
            $sugu = strtolower(trim($rida[1]));
            $palk = (int)$rida[2];

            if ($sugu == "m") {
                $meeste_palk += $palk;
                $meeste_arv++;
                if ($palk > $meeste_max) {
                    $meeste_max = $palk;
                }
            } elseif ($sugu == "n") {
                $naiste_palk += $palk;
                $naiste_arv++;
                if ($palk > $naiste_max) {
                    $naiste_max = $palk;
                }
            }
        }
    }
    fclose($fail);

    if ($meeste_arv > 0) {
        $meeste_keskmine = round($meeste_palk / $meeste_arv, 2);
    } else {
        $meeste_keskmine = 0;
    }

    if ($naiste_arv > 0) {
        $naiste_keskmine = round($naiste_palk / $naiste_arv, 2);
    } else {
        $naiste_keskmine = 0;
    }

    echo "<p>Meeste keskmine palk: $meeste_keskmine €</p>";
    echo "<p>Naiste keskmine palk: $naiste_keskmine €</p>";
    echo "<p>Meeste suurim palk: $meeste_max €</p>";
    echo "<p>Naiste suurim palk: $naiste_max €</p>";
} else {
    echo "<p>Faili '$allikas' ei leitud!</p>";
}
?>

</body>
</html>
