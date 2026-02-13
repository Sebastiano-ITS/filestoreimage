<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    /* Reset e stile base */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", sans-serif;
    }

    body {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, #4f46e5, #3b82f6);
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
      color: #111827;
    }

    /* Card centrale */
    .login-card {
      background: #ffffff;
      padding: 40px 30px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      width: 350px;
      animation: fadeIn 0.6s ease-out;
    }

    label {
      display: block;
      font-weight: 600;
      margin-bottom: 5px;
      color: #374151;
    }

    input[type="text"], 
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      font-size: 14px;
      transition: all 0.3s;
    }

    input:focus {
      border-color: #3b82f6;
      outline: none;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
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
      width: 100%;
      transition: transform 0.2s ease, background 0.3s ease;
    }

    button:hover {
      transform: translateY(-2px);
      background: linear-gradient(135deg, #4f46e5, #2563eb);
    }

    .error {
      color: #ef4444;
      margin-top: 10px;
      text-align: center;
      font-weight: 500;
    }

    .login-link {
      margin-top: 15px;
      text-align: center;
    }

    .login-link a {
      text-decoration: none;
      color: #3b82f6;
      font-weight: bold;
    }

    /* Animazione ingresso */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="login-card">
    <h1>Accedi</h1>
    <?php
    if (isset($_GET['error'])) {
        echo '<p class="error">' . htmlspecialchars($_GET['error']) . '</p>';
    }
    ?>
    <form action="login_process.php" method="post">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Accedi</button>
    </form>

    <div class="login-link">
      Non Hai già un account? <a href="signup.php">Registrati</a>
    </div>

  </div>
</body>
</html>
