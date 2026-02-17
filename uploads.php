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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carica File</title>
    <link rel="stylesheet" href="style_uploads.css">


    <style>
        /* Reset e base */
        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Segoe UI", sans-serif;
        }

        body {
        background: #f3f4f6;
        color: #111827;
        display: flex;
        flex-direction: column;
        }

        /* Navbar */
        .navbar {
        background: linear-gradient(135deg, #4f46e5, #3b82f6);
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
        }

        .navbar h1 {
        font-size: 20px;
        font-weight: 600;
        }

        .nav-links a {
        margin-left: 15px;
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: background 0.3s ease, transform 0.2s ease;
        }

        .home-btn {
        background: #10b981;
        color: white;
        }

        .home-btn:hover {
        background: #059669;
        transform: translateY(-2px);
        }

        .logout-btn {
        background: #ef4444;
        color: white;
        }

        .logout-btn:hover {
        background: #dc2626;
        transform: translateY(-2px);
        }

        /* Contenuto */
        .container {
        flex: 1;
        display: flex;
        
        margin: auto;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        }

        .card {
        background: white;
        border-radius: 15px;
        padding: 40px;
        text-align: center;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        width: 100%;
        animation: fadeIn 0.6s ease-out;
        }

        .card h2 {
        margin-bottom: 20px;
        color: #1f2937;
        }

        /* Form */
        form {
        display: flex;
        flex-direction: column;
        gap: 15px;
        }

        input[type="file"] {
        padding: 10px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        }

        button[type="submit"] {
        background: linear-gradient(135deg, #6366f1, #3b82f6);
        color: white;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        font-weight: bold;
        cursor: pointer;
        transition: transform 0.2s ease, background 0.3s ease;
        }

        button[type="submit"]:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #4f46e5, #2563eb);
        }

        /* Secondary button */
        .secondary-btn {
        display: inline-block;
        margin-top: 20px;
        background: #6b7280;
        color: white;
        padding: 10px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: background 0.3s ease, transform 0.2s ease;
        }

        .secondary-btn:hover {
        background: #4b5563;
        transform: translateY(-2px);
        }

        /* Animazioni */
        @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
        }

    </style>
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
