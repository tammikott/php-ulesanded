<?php
include 'config.php';

// Kustutame sessiooni andmed
session_unset();
session_destroy();

// Kustutame küpsise "mäleta mind" jaoks
if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 3600, '/');
}

// Suuname avalehele
header("Location: index.php");
exit();
?>