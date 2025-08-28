<?php
include 'config.php';
checkAdmin();

$conn = connectDB();

// Vormi töötlemine
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_service'])) {
        // Teenuse lisamine
        $nimetus = $_POST['nimetus'];
        $kirjeldus = $_POST['kirjeldus'];
        $kestus = $_POST['kestus'];
        $hind = $_POST['hind'];
        
        $sql = "INSERT INTO teenused (nimetus, kirjeldus, kestus_minutites, hind) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssid", $nimetus, $kirjeldus, $kestus, $hind);
        $stmt->execute();
        $stmt->close();
        
        $success = "Teenus on lisatud!";
    } 
    else if (isset($_POST['add_workstation'])) {
        // Töökoha lisamine
        $nimetus = $_POST['nimetus'];
        $kirjeldus = $_POST['kirjeldus'];
        
        $sql = "INSERT INTO tookohad (nimetus, kirjeldus) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nimetus, $kirjeldus);
        $stmt->execute();
        $stmt->close();
        
        $success = "Töökoht on lisatud!";
    }
    else if (isset($_POST['update_booking'])) {
        // Broneeringu muutmine
        $broneering_id = $_POST['broneering_id'];
        $staatus = $_POST['staatus'];
        
        $sql = "UPDATE broneeringud SET staatus = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $staatus, $broneering_id);
        $stmt->execute();
        $stmt->close();
        
        $success = "Broneering on uuendatud!";
    }
}

// Võtame kõik broneeringud
$sql_broneeringud = "SELECT b.*, t.nimetus as teenus_nimi, tk.nimetus as tookoht_nimi, 
                     k.eesnimi, k.perekonnanimi, k.email 
                     FROM broneeringud b 
                     JOIN teenused t ON b.teenus_id = t.id 
                     JOIN tookohad tk ON b.tookoht_id = tk.id 
                     JOIN kliendid k ON b.klient_id = k.id 
                     ORDER BY b.algus_aeg DESC";
$result_broneeringud = $conn->query($sql_broneeringud);

// Võtame kõik teenused
$sql_teenused = "SELECT * FROM teenused";
$result_teenused = $conn->query($sql_teenused);

// Võtame kõik töökohad
$sql_tookohad = "SELECT * FROM tookohad";
$result_tookohad = $conn->query($sql_tookohad);

$conn->close();
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haldus - Autoremondi Töökoda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .admin-container {
            max-width: 1400px;
            margin: 50px auto;
            padding: 20px;
        }
        .admin-section {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 30px;
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
                        <a class="nav-link" href="broneering.php">Broneeri aeg</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="admin.php">Haldus</a>
                    </li>
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
        <div class="admin-container">
            <h2 class="text-center mb-4">Halduspanel</h2>
            
            <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <!-- Broneeringute haldamine -->
            <div class="admin-section">
                <h4 class="mb-3">Broneeringud</h4>
                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Klient</th>
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
                                <td><?php echo $broneering['eesnimi'] . ' ' . $broneering['perekonnanimi']; ?></td>
                                <td><?php echo $broneering['teenus_nimi']; ?></td>
                                <td><?php echo $broneering['tookoht_nimi']; ?></td>
                                <td><?php echo date('d.m.Y', strtotime($broneering['algus_aeg'])); ?></td>
                                <td><?php echo date('H:i', strtotime($broneering['algus_aeg'])); ?></td>
                                <td>
                                    <span class="badge 
                                        <?php 
                                        if ($broneering['staatus'] == 'broneeritud') echo 'bg-success';
                                        elseif ($broneering['staatus'] == 'tehtud') echo 'bg-primary';
                                        else echo 'bg-danger';
                                        ?>
                                    "><?php echo $broneering['staatus']; ?></span>
                                </td>
                                <td>
                                    <form method="POST" action="" class="d-inline">
                                        <input type="hidden" name="broneering_id" value="<?php echo $broneering['id']; ?>">
                                        <select name="staatus" class="form-select form-select-sm d-inline" style="width: auto;">
                                            <option value="broneeritud" <?php if ($broneering['staatus'] == 'broneeritud') echo 'selected'; ?>>Broneeritud</option>
                                            <option value="tehtud" <?php if ($broneering['staatus'] == 'tehtud') echo 'selected'; ?>>Tehtud</option>
                                            <option value="tyhistatud" <?php if ($broneering['staatus'] == 'tyhistatud') echo 'selected'; ?>>Tühistatud</option>
                                        </select>
                                        <button type="submit" name="update_booking" class="btn btn-sm btn-primary">Uuenda</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Teenuste haldamine -->
            <div class="admin-section">
                <h4 class="mb-3">Teenused</h4>
                
                <div class="row">
                    <div class="col-md-6">
                        <h5>Lisa uus teenus</h5>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="nimetus" class="form-label">Nimetus</label>
                                <input type="text" class="form-control" id="nimetus" name="nimetus" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="kirjeldus" class="form-label">Kirjeldus</label>
                                <textarea class="form-control" id="kirjeldus" name="kirjeldus" rows="3"></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kestus" class="form-label">Kestus (minutites)</label>
                                    <input type="number" class="form-control" id="kestus" name="kestus" required min="1">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="hind" class="form-label">Hind (€)</label>
                                    <input type="number" step="0.01" class="form-control" id="hind" name="hind" required min="0">
                                </div>
                            </div>
                            
                            <button type="submit" name="add_service" class="btn btn-primary">Lisa teenus</button>
                        </form>
                    </div>
                    
                    <div class="col-md-6">
                        <h5>Olemasolevad teenused</h5>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Nimetus</th>
                                        <th>Kestus</th>
                                        <th>Hind</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($teenus = $result_teenused->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $teenus['nimetus']; ?></td>
                                        <td><?php echo $teenus['kestus_minutites']; ?> min</td>
                                        <td><?php echo $teenus['hind']; ?> €</td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Töökohtade haldamine -->
            <div class="admin-section">
                <h4 class="mb-3">Töökohad</h4>
                
                <div class="row">
                    <div class="col-md-6">
                        <h5>Lisa uus töökoht</h5>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="nimetus" class="form-label">Nimetus</label>
                                <input type="text" class="form-control" id="nimetus" name="nimetus" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="kirjeldus" class="form-label">Kirjeldus</label>
                                <textarea class="form-control" id="kirjeldus" name="kirjeldus" rows="3"></textarea>
                            </div>
                            
                            <button type="submit" name="add_workstation" class="btn btn-primary">Lisa töökoht</button>
                        </form>
                    </div>
                    
                    <div class="col-md-6">
                        <h5>Olemasolevad töökohad</h5>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Nimetus</th>
                                        <th>Kirjeldus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($tookoht = $result_tookohad->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $tookoht['nimetus']; ?></td>
                                        <td><?php echo $tookoht['kirjeldus']; ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>