<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kasutajanimi = $_POST['kasutajanimi'];
    $parool = $_POST['parool'];
    $korda_parool = $_POST['korda_parool'];
    $eesnimi = $_POST['eesnimi'];
    $perekonnanimi = $_POST['perekonnanimi'];
    $email = $_POST['email'];
    $isikukood = $_POST['isikukood'];
    $telefon = $_POST['telefon'];
    
    $errors = [];
    
    // Valideerimine
    if (empty($kasutajanimi) || empty($parool) || empty($korda_parool) || empty($eesnimi) || empty($perekonnanimi) || empty($email) || empty($isikukood)) {
        $errors[] = "Kõik väljad peavad olema täidetud!";
    }
    
    if ($parool != $korda_parool) {
        $errors[] = "Paroolid ei kattu!";
    }
    
    if (strlen($parool) < 6) {
        $errors[] = "Parool peab olema vähemalt 6 tähemärki pikk!";
    }
    
    if (!validateEmail($email)) {
        $errors[] = "Palun sisesta korrektne e-posti aadress!";
    }
    
    if (!validateIsikukood($isikukood)) {
        $errors[] = "Palun sisesta korrektne isikukood!";
    }
    
    if (empty($errors)) {
        $conn = connectDB();
        
        // Kontrollime, kas kasutajanimi või email on juba olemas
        $sql_check = "SELECT id FROM kasutajad WHERE kasutajanimi = ? OR email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("ss", $kasutajanimi, $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        
        if ($result_check->num_rows > 0) {
            $errors[] = "Kasutajanimi või e-posti aadress on juba kasutusel!";
        } else {
            // Lisame kasutaja andmebaasi
            $hashed_password = hashPassword($parool);
            
            $sql_insert = "INSERT INTO kasutajad (kasutajanimi, parool_hash, eesnimi, perekonnanimi, email) 
                           VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("sssss", $kasutajanimi, $hashed_password, $eesnimi, $perekonnanimi, $email);
            
            if ($stmt_insert->execute()) {
                $user_id = $stmt_insert->insert_id;
                
                // Lisame kliendi andmed
                $sql_client = "INSERT INTO kliendid (eesnimi, perekonnanimi, isikukood, email, telefon) 
                               VALUES (?, ?, ?, ?, ?)";
                $stmt_client = $conn->prepare($sql_client);
                $stmt_client->bind_param("sssss", $eesnimi, $perekonnanimi, $isikukood, $email, $telefon);
                $stmt_client->execute();
                
                // Logime kasutaja sisse
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $eesnimi . ' ' . $perekonnanimi;
                $_SESSION['user_role'] = 'tavakasutaja';
                
                header("Location: index.php");
                exit();
            } else {
                $errors[] = "Tekkis viga registreerimisel. Palun proovi uuesti!";
            }
            
            $stmt_insert->close();
        }
        
        $stmt_check->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreeri - Autoremondi Töökoda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .register-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-container">
            <h2 class="text-center mb-4">Loo konto</h2>
            
            <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="eesnimi" class="form-label">Eesnimi</label>
                        <input type="text" class="form-control" id="eesnimi" name="eesnimi" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="perekonnanimi" class="form-label">Perekonnanimi</label>
                        <input type="text" class="form-control" id="perekonnanimi" name="perekonnanimi" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="isikukood" class="form-label">Isikukood</label>
                    <input type="text" class="form-control" id="isikukood" name="isikukood" required maxlength="11">
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">E-posti aadress</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <div class="mb-3">
                    <label for="telefon" class="form-label">Telefon</label>
                    <input type="tel" class="form-control" id="telefon" name="telefon">
                </div>
                
                <div class="mb-3">
                    <label for="kasutajanimi" class="form-label">Kasutajanimi</label>
                    <input type="text" class="form-control" id="kasutajanimi" name="kasutajanimi" required>
                </div>
                
                <div class="mb-3">
                    <label for="parool" class="form-label">Parool</label>
                    <input type="password" class="form-control" id="parool" name="parool" required minlength="6">
                </div>
                
                <div class="mb-3">
                    <label for="korda_parool" class="form-label">Korda parooli</label>
                    <input type="password" class="form-control" id="korda_parool" name="korda_parool" required minlength="6">
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Registreeri</button>
            </form>
            
            <hr>
            
            <div class="text-center">
                <p>Juba kasutaja? <a href="login.php">Logi sisse siin</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>