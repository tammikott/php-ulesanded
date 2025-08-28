<?php
include 'config.php';
checkAuth();

$conn = connectDB();
$user_id = $_SESSION['user_id'];

// Vormi töötlemine
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cancel_booking'])) {
        // Broneeringu tühistamine
        $broneering_id = $_POST['broneering_id'];
        
        $sql = "UPDATE broneeringud SET staatus = 'tyhistatud' WHERE id = ? AND klient_id = (SELECT id FROM kliendid WHERE email = (SELECT email FROM kasutajad WHERE id = ?))";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $broneering_id, $user_id);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            $success = "Broneering on tühistatud!";
        } else {
            $error = "Broneeringu tühistamine ebaõnnestus!";
        }
        
        $stmt->close();
    } else {
        // Uue broneeringu loomine
        $teenus_id = $_POST['teenus_id'];
        $tookoht_id = $_POST['tookoht_id'];
        $kuupaev = $_POST['kuupaev'];
        $kellaaeg = $_POST['kellaaeg'];
        
        // Teenuse kestuse leidmine
        $sql_teenus = "SELECT kestus_minutites FROM teenused WHERE id = ?";
        $stmt_teenus = $conn->prepare($sql_teenus);
        $stmt_teenus->bind_param("i", $teenus_id);
        $stmt_teenus->execute();
        $result_teenus = $stmt_teenus->get_result();
        $teenus = $result_teenus->fetch_assoc();
        
        $algus_aeg = $kuupaev . ' ' . $kellaaeg;
        $lopp_aeg = date('Y-m-d H:i:s', strtotime($algus_aeg) + $teenus['kestus_minutites'] * 60);
        
        // Kontrollime, kas broneering on tulevikus
        if (strtotime($algus_aeg) < time()) {
            $error = "Broneering peab olema tulevikus!";
        } 
        // Kontrollime, kas töökoht on vaba
        else if (checkOverlappingBookings($tookoht_id, $algus_aeg, $lopp_aeg)) {
            $error = "Valitud ajal on töökoht juba hõivatud!";
        } else {
            // Leiame kliendi ID - PARANDATUD OSA
            $sql_klient = "SELECT id FROM kliendid WHERE email = (SELECT email FROM kasutajad WHERE id = ?)";
            $stmt_klient = $conn->prepare($sql_klient);
            $stmt_klient->bind_param("i", $user_id);
            $stmt_klient->execute();
            $result_klient = $stmt_klient->get_result();
            
            if ($result_klient->num_rows > 0) {
                $klient = $result_klient->fetch_assoc();
                $klient_id = $klient['id'];
                
                // Lisame broneeringu
                $sql_insert = "INSERT INTO broneeringud (klient_id, teenus_id, tookoht_id, algus_aeg, lopp_aeg) 
                               VALUES (?, ?, ?, ?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("iiiss", $klient_id, $teenus_id, $tookoht_id, $algus_aeg, $lopp_aeg);
                
                if ($stmt_insert->execute()) {
                    $success = "Broneering on loodud!";
                } else {
                    $error = "Broneeringu loomine ebaõnnestus!";
                }
                
                $stmt_insert->close();
            } else {
                $error = "Klienti ei leitud! Palun kontrolli oma andmeid.";
            }
            
            $stmt_klient->close();
        }
        
        $stmt_teenus->close();
    }
}

// Võtame kõik aktiivsed teenused
$sql_teenused = "SELECT * FROM teenused WHERE aktiivne = TRUE";
$result_teenused = $conn->query($sql_teenused);

// Võtame kõik aktiivsed töökohad
$sql_tookohad = "SELECT * FROM tookohad WHERE aktiivne = TRUE";
$result_tookohad = $conn->query($sql_tookohad);

// Võtame kasutaja broneeringud
$sql_broneeringud = "SELECT b.*, t.nimetus as teenus_nimi, tk.nimetus as tookoht_nimi 
                     FROM broneeringud b 
                     JOIN teenused t ON b.teenus_id = t.id 
                     JOIN tookohad tk ON b.tookoht_id = tk.id 
                     JOIN kliendid k ON b.klient_id = k.id 
                     JOIN kasutajad u ON k.email = u.email 
                     WHERE u.id = ? AND b.staatus = 'broneeritud' 
                     ORDER BY b.algus_aeg ASC";
$stmt_broneeringud = $conn->prepare($sql_broneeringud);
$stmt_broneeringud->bind_param("i", $user_id);
$stmt_broneeringud->execute();
$result_broneeringud = $stmt_broneeringud->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Broneeri aeg - Autoremondi Töökoda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .booking-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .booking-form {
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-car me-2"></i>Autoremond
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Avaleht</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="broneering.php">Broneeri aeg</a>
                    </li>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Haldus</a>
                    </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="navbar-text me-3">Tere, <?php echo $_SESSION['user_name']; ?>!</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logi välja</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="booking-container">
            <h2 class="text-center mb-4">Broneeri aeg</h2>
            
            <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <!-- Broneeringu vorm -->
            <div class="booking-form">
                <h4 class="mb-3">Uue broneeringu loomine</h4>
                <form method="POST" action="">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="teenus_id" class="form-label">Teenus</label>
                            <select class="form-select" id="teenus_id" name="teenus_id" required>
                                <option value="">Vali teenus</option>
                                <?php while($teenus = $result_teenused->fetch_assoc()): ?>
                                <option value="<?php echo $teenus['id']; ?>">
                                    <?php echo $teenus['nimetus']; ?> (<?php echo $teenus['hind']; ?>€)
                                </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="tookoht_id" class="form-label">Töökoht</label>
                            <select class="form-select" id="tookoht_id" name="tookoht_id" required>
                                <option value="">Vali töökoht</option>
                                <?php while($tookoht = $result_tookohad->fetch_assoc()): ?>
                                <option value="<?php echo $tookoht['id']; ?>"><?php echo $tookoht['nimetus']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-2 mb-3">
                            <label for="kuupaev" class="form-label">Kuupäev</label>
                            <input type="date" class="form-control" id="kuupaev" name="kuupaev" required min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        
                        <div class="col-md-2 mb-3">
                            <label for="kellaaeg" class="form-label">Kellaaeg</label>
                            <input type="time" class="form-control" id="kellaaeg" name="kellaaeg" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Broneeri</button>
                </form>
            </div>
            
            <!-- Minu broneeringud -->
            <div>
                <h4 class="mb-3">Minu broneeringud</h4>
                
                <?php if ($result_broneeringud->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Teenus</th>
                                <th>Töökoht</th>
                                <th>Kuupäev</th>
                                <th>Kellaaeg</th>
                                <th>Staatus</th>
                                <th>Tegevus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($broneering = $result_broneeringud->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $broneering['teenus_nimi']; ?></td>
                                <td><?php echo $broneering['tookoht_nimi']; ?></td>
                                <td><?php echo date('d.m.Y', strtotime($broneering['algus_aeg'])); ?></td>
                                <td><?php echo date('H:i', strtotime($broneering['algus_aeg'])); ?></td>
                                <td>
                                    <span class="badge bg-success"><?php echo $broneering['staatus']; ?></span>
                                </td>
                                <td>
                                    <?php 
                                    // Kontrollime, kas broneeringut saab tühistada (vähemalt 24h enne)
                                    $now = time();
                                    $booking_time = strtotime($broneering['algus_aeg']);
                                    $diff = $booking_time - $now;
                                    
                                    if ($diff > 24 * 3600): // 24 tundi
                                    ?>
                                    <form method="POST" action="" style="display:inline;">
                                        <input type="hidden" name="broneering_id" value="<?php echo $broneering['id']; ?>">
                                        <button type="submit" name="cancel_booking" class="btn btn-sm btn-danger">Tühista</button>
                                    </form>
                                    <?php else: ?>
                                    <span class="text-muted">Tühistamise aeg on möödas</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p>Teil pole ühtegi broneeringut.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>