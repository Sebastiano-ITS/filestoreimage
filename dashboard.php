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
  <title>Dashboard</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", sans-serif;
    }

    body {
      background: #f3f4f6;
      color: #111827;
      min-height: 100vh;
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

    .logout-btn {
      background: #ef4444;
      padding: 10px 18px;
      border-radius: 8px;
      color: white;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .logout-btn:hover {
      background: #dc2626;
      transform: translateY(-2px);
    }

    /* Contenuto */
    .container {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
    }

    .welcome {
      font-size: 22px;
      margin-bottom: 40px;
      text-align: center;
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
      width: 100%;
      max-width: 700px;
    }

    .card {
      background: white;
      border-radius: 15px;
      padding: 30px;
      text-align: center;
      box-shadow: 0 6px 15px rgba(0,0,0,0.1);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    }

    .card h2 {
      margin-bottom: 15px;
      color: #1f2937;
    }

    .card a {
      display: inline-block;
      margin-top: 10px;
      background: linear-gradient(135deg, #6366f1, #3b82f6);
      color: white;
      padding: 12px 20px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .card a:hover {
      background: linear-gradient(135deg, #4f46e5, #2563eb);
      transform: translateY(-2px);
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
    <h1>Dashboard</h1>
    <a class="logout-btn" href="logout.php">Disconetti</a>
  </div>

  <!-- Contenuto -->
  <div class="container">
    <p class="welcome">Benvenuto, <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong> 👋<br>
    Qui puoi gestire e condividere i tuoi file.</p>

    <div class="cards">
      <div class="card">
        <h2>Carica File</h2>
        <p>Seleziona e carica nuovi file dal tuo dispositivo.</p>
        <a href="uploads.php">Vai</a>
      </div>

      <div class="card">
        <h2>Visualizza & Scarica</h2>
        <p>Accedi ai file caricati e scaricali quando vuoi.</p>
        <a href="download.php">Vai</a>
      </div>
    </div>
  </div>
</body>
</html>
