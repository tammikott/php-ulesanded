<?php
include 'config.php';
$conn = connectDB();

// Võtame kõik aktiivsed teenused
$sql_teenused = "SELECT * FROM teenused WHERE aktiivne = TRUE";
$result_teenused = $conn->query($sql_teenused);

// Võtame kõik aktiivsed töökohad
$sql_tookohad = "SELECT * FROM tookohad WHERE aktiivne = TRUE";
$result_tookohad = $conn->query($sql_tookohad);

$conn->close();
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autoremondi Töökoda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1500&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            margin-bottom: 40px;
        }
        .service-card {
            transition: transform 0.3s;
            margin-bottom: 20px;
        }
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        footer {
            background-color: #343a40;
            color: white;
            padding: 30px 0;
            margin-top: 50px;
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
                        <a class="nav-link active" href="index.php">Avaleht</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="broneering.php">Broneeri aeg</a>
                    </li>
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Haldus</a>
                    </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <span class="navbar-text me-3">Tere, <?php echo $_SESSION['user_name']; ?>!</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logi välja</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Logi sisse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Registreeri</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">Autoremondi Töökoda</h1>
            <p class="lead">Usaldusväline teenus sinu sõidukile</p>
            <a href="broneering.php" class="btn btn-primary btn-lg mt-3">Broneeri aeg</a>
        </div>
    </div>

    <!-- Teenused -->
    <div class="container">
        <h2 class="text-center mb-4">Meie teenused</h2>
        <div class="row">
            <?php while($teenus = $result_teenused->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="card service-card">
                    <div class="card-body text-center">
                        <i class="fas fa-tools fa-3x text-primary mb-3"></i>
                        <h5 class="card-title"><?php echo $teenus['nimetus']; ?></h5>
                        <p class="card-text"><?php echo $teenus['kirjeldus']; ?></p>
                        <p class="fw-bold">Kestus: <?php echo $teenus['kestus_minutites']; ?> min</p>
                        <p class="fw-bold text-primary">Hind: <?php echo $teenus['hind']; ?> €</p>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Töökohad -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Meie töökohad</h2>
        <div class="row">
            <?php while($tookoht = $result_tookohad->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-warehouse fa-3x text-secondary mb-3"></i>
                        <h5 class="card-title"><?php echo $tookoht['nimetus']; ?></h5>
                        <p class="card-text"><?php echo $tookoht['kirjeldus']; ?></p>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p>&copy; 2023 Autoremondi Töökoda. Kõik õigused kaitstud.</p>
            <p>
                <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>