<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kasutajanimi = $_POST['kasutajanimi'];
    $parool = $_POST['parool'];
    $meeldetuletus = isset($_POST['meeldetuletus']) ? true : false;
    
    $conn = connectDB();
    
    $sql = "SELECT * FROM kasutajad WHERE kasutajanimi = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $kasutajanimi);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        if (verifyPassword($parool, $user['parool_hash'])) {
            // Logime kasutaja sisse
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['eesnimi'] . ' ' . $user['perekonnanimi'];
            $_SESSION['user_role'] = $user['roll'];
            
            // "Mäleta mind" funktsioon
            if ($meeldetuletus) {
                $token = bin2hex(random_bytes(32));
                $expiry = date('Y-m-d H:i:s', time() + 4 * 3600); // 4 tundi
                
                $sql_update = "UPDATE kasutajad SET meeldetuletus_token = ?, meeldetuletus_aeg = ? WHERE id = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("ssi", $token, $expiry, $user['id']);
                $stmt_update->execute();
                
                setcookie('remember_token', $token, time() + 4 * 3600, '/');
            }
            
            header("Location: index.php");
            exit();
        } else {
            $error = "Vale kasutajanimi või parool!";
        }
    } else {
        $error = "Vale kasutajanimi või parool!";
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logi sisse - Autoremondi Töökoda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2 class="text-center mb-4">Logi sisse</h2>
            
            <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="kasutajanimi" class="form-label">Kasutajanimi</label>
                    <input type="text" class="form-control" id="kasutajanimi" name="kasutajanimi" required>
                </div>
                
                <div class="mb-3">
                    <label for="parool" class="form-label">Parool</label>
                    <input type="password" class="form-control" id="parool" name="parool" required>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="meeldetuletus" name="meeldetuletus">
                    <label class="form-check-label" for="meeldetuletus">Jäta mind meelde</label>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Logi sisse</button>
            </form>
            
            <hr>
            
            <div class="text-center">
                <p>Pole kasutajat? <a href="register.php">Registreeri siin</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>