<?php
session_start();

// Andmebaasi seaded
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'autoremondi_systeem');

// Loome andmebaasi ühenduse
function connectDB() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Kontrollime ühendust
    if ($conn->connect_error) {
        die("Ühendus ebaõnnestus: " . $conn->connect_error);
    }
    
    // Määrame kodeeringu
    $conn->set_charset("utf8mb4");
    return $conn;
}

// Funktsioon parooli räsimiseks
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Funktsioon parooli kontrollimiseks
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// Funktsioon veateadete kuvamiseks
function displayError($message) {
    return '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        ' . $message . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}

// Funktsioon õnnestumisteate kuvamiseks
function displaySuccess($message) {
    return '<div class="alert alert-success alert-dismissible fade show" role="alert">
        ' . $message . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}

// Kasutaja autentimise kontroll
function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

// Administraatori õiguste kontroll
function checkAdmin() {
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
        header("Location: index.php");
        exit();
    }
}

// Isikukoodi valideerimine
function validateIsikukood($isikukood) {
    if (strlen($isikukood) != 11 || !is_numeric($isikukood)) {
        return false;
    }
    
    // Lihtsam valideerimine (põhivalideerimine)
    // Eestis on isikukoodi täpsem valideerimine keerulisem
    return true;
}

// Emaili valideerimine
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Kuupäeva ja kellaaja valideerimine
function validateDateTime($date, $time) {
    $datetime = $date . ' ' . $time;
    $format = 'Y-m-d H:i';
    
    $d = DateTime::createFromFormat($format, $datetime);
    return $d && $d->format($format) == $datetime;
}

// Kattuvate broneeringute kontroll
function checkOverlappingBookings($tookoht_id, $algus_aeg, $lopp_aeg, $broneering_id = null) {
    $conn = connectDB();
    
    $sql = "SELECT id FROM broneeringud 
            WHERE tookoht_id = ? 
            AND staatus = 'broneeritud'
            AND (
                (algus_aeg < ? AND lopp_aeg > ?) OR
                (algus_aeg < ? AND lopp_aeg > ?) OR
                (algus_aeg >= ? AND lopp_aeg <= ?)
            )";
    
    if ($broneering_id) {
        $sql .= " AND id != ?";
    }
    
    $stmt = $conn->prepare($sql);
    
    if ($broneering_id) {
        $stmt->bind_param("issssssi", $tookoht_id, $lopp_aeg, $algus_aeg, $algus_aeg, $lopp_aeg, $algus_aeg, $lopp_aeg, $broneering_id);
    } else {
        $stmt->bind_param("issssss", $tookoht_id, $lopp_aeg, $algus_aeg, $algus_aeg, $lopp_aeg, $algus_aeg, $lopp_aeg);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $overlapping = $result->num_rows > 0;
    
    $stmt->close();
    $conn->close();
    
    return $overlapping;
}
?>