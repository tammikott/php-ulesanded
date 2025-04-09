<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Töö kataloogidega</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
 <?php
 // h13
 // Ott Tammik
 // 05.04.2025
 if(!empty($_FILES['minu_fail']['name'])){
  $sinu_faili_nimi = $_FILES['minu_fail']['name'];
  $ajutine_fail = $_FILES['minu_fail']['tmp_name'];
  $faili_tyyp = $_FILES['minu_fail']['type'];

  if (in_array($faili_tyyp, ['image/jpeg', 'image/pjpeg'])) {
   $kataloog = 'php13_pildid';

   if (!is_dir($kataloog)) {
    mkdir($kataloog, 0777, true);
   }

   if(move_uploaded_file($ajutine_fail, $kataloog.'/'.$sinu_faili_nimi)){
    echo '<div class="alert alert-success">Faili üleslaadimine oli edukas</div>';
   } else {
    echo '<div class="alert alert-danger">Faili üleslaadimine ebaõnnestus</div>';
   }
  } else {
   echo '<div class="alert alert-warning">Ainult JPG ja JPEG failid on lubatud!</div>';
  }
 }
 ?>

 <form action="" method="post" enctype="multipart/form-data">
  <input type="file" name="minu_fail" accept="image/jpeg, image/jpg"><br>
  <input type="submit" value="Lae üles!">
 </form>

 <h2>Üleslaetud pildid</h2>
 <form method="post" action="">
  <select name="pildid">
   <option value="">Vali pilt</option>
   <?php 
    $kataloog = 'php13_pildid';
    $asukoht = opendir($kataloog);

    while ($rida = readdir($asukoht)) {
     if ($rida != '.' && $rida != '..') {
      echo "<option value='$rida'>$rida</option>\n";
     }
    }
    closedir($asukoht);
   ?>
  </select>
  <input type="submit" value="Vaata">
 </form>

 <?php
 if(!empty($_POST['pildid'])){
  $pilt = $_POST['pildid'];
  $pildi_aadress = 'php13_pildid/'.$pilt;
  echo "<img width='800px' src='$pildi_aadress'><br>";
 }
 ?>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
