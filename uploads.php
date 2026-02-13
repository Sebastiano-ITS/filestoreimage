<?php
session_start();

// Verifica login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Carica File</title>
    <link rel="stylesheet" href="style_uploads.css">
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>


    <!-- Contenuto -->
    <div class="container">
        <div class="card">
            <h2>Carica Più File</h2>
            <form action="upload_process.php" method="post" enctype="multipart/form-data">
                <label for="fileToUpload">Seleziona i file da caricare:</label>
                <input type="file" name="files[]" id="fileToUpload" multiple>

                <button type="submit" name="submit">Carica File</button>
            </form>

            <a href="download.php" class="secondary-btn">Visualizza e Scarica File</a>
        </div>
    </div>
</body>
</html>
