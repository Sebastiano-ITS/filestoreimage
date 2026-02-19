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


        /* BOX CON I PULSANTI */
    .password-box {
        background: #ffffff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        margin: 20px auto;
        max-width: 450px;
        text-align: center;
    }

    .password-box h3 {
        margin-bottom: 20px;
        font-size: 22px;
        color: #333;
    }

    .password-actions {
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    /* BOTTONI */
    .pw-btn {
        text-decoration: none;
        padding: 12px 18px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.25s;
        color: #fff;
    }

    /* NUOVA PASSWORD */
    .pw-btn.add {
        background: #28a745;
    }

    .pw-btn.add:hover {
        background: #218838;
    }

    /* VISUALIZZA PASSWORD */
    .pw-btn.view {
        background: #007bff;
    }

    .pw-btn.view:hover {
        background: #0069d9;
    }

    /* MOBILE RESPONSIVE */
    @media(max-width: 480px) {
        .password-actions {
            flex-direction: column;
        }
    }

  </style>
</head>
<body>
  <!-- Navbar -->
    <!-- Navbar -->
    <?php include 'navbarHome.php'; ?>

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

      <!-- Contenitore Password Manager -->
      <div class="password-box">
          <h3>Gestione Password</h3>

          <div class="password-actions">
              <a href="password_add.php" class="pw-btn add">
                  <i class="fas fa-plus"></i> Nuova Password
              </a>

              <a href="password_view.php" class="pw-btn view">
                  <i class="fas fa-eye"></i> Visualizza Password
              </a>
          </div>
      </div>
    </div>
  </div>
</body>
</html>
