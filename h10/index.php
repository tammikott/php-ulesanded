<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Esimene PHP</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
 <menu>
 <a href="index.php">Avaleht</a> |
 <a href="index.php?leht=portfoolio">Portfoolio</a> |
 <a href="index.php?leht=kaart">Kaart</a> |
 <a href="index.php?leht=kontroll">Kontakt</a>
</menu>

<?php
 // h010
 // Ott Tammik
 // 05.04.2025
if(!empty($_GET['leht'])){
 $leht = htmlspecialchars($_GET['leht']);
 $lubatud = array('portfoolio','kaart','kontakt');
 $kontroll = in_array($leht, $lubatud);
 if($kontroll==true){
     include($leht.'.php');
 } else {
     echo 'Valitud lehte ei eksisteeri!';
 }
} else {


?>
<h2>Avaleht</h2>
<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Illo porro eos placeat sit tempora voluptatum? Asperiores dicta praesentium voluptas enim ipsa doloribus cupiditate modi. Quas exercitationem voluptates quod sunt provident.</p>

<?php


 }

?>

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>