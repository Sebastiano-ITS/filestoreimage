<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrazione</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: "Segoe UI", sans-serif; }

    body {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, #4f46e5, #3b82f6);
    }

    .signup-card {
      background: #ffffff;
      padding: 40px 30px;
      border-radius: 15px;
      width: 350px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
      animation: fadeIn .6s ease-out;
    }

    h1 { text-align: center; margin-bottom: 20px; color: #111827; }

    label { font-weight: 600; margin-bottom: 5px; display: block; }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      margin-bottom: 15px;
      transition: .3s;
      font-size: 14px;
    }

    input:focus {
      border-color: #3b82f6;
      outline: none;
      box-shadow: 0 0 0 3px rgba(59,130,246,0.3);
    }

    .password-container {
      position: relative;
    }

    .toggle-password {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 18px;
      color: #6b7280;
      user-select: none;
    }

    button {
      background: linear-gradient(135deg, #6366f1, #3b82f6);
      border: none;
      padding: 12px;
      width: 100%;
      color: white;
      font-size: 15px;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
      transition: .2s ease;
    }

    button:hover {
      transform: translateY(-2px);
      background: linear-gradient(135deg, #4f46e5, #2563eb);
    }

    .error { color: #ef4444; text-align: center; margin-bottom: 10px; font-weight: 500; }

    .login-link {
      margin-top: 15px;
      text-align: center;
    }

    .login-link a {
      text-decoration: none;
      color: #3b82f6;
      font-weight: bold;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body>

<div class="signup-card">
  <h1>Registrati</h1>

  <?php
  if (isset($_GET['error'])) {
      echo '<p class="error">' . htmlspecialchars($_GET['error']) . '</p>';
  }
  ?>

  <form action="signup_process.php" method="post">

    <label>Username</label>
    <input type="text" name="username" required>

    <label>Password</label>
    <div class="password-container">
      <input type="password" name="password" id="password" required>
      <span class="toggle-password" onclick="togglePassword()">👁️</span>
    </div>

    <button type="submit">Crea account</button>
  </form>

  <div class="login-link">
    Hai già un account? <a href="login.php">Accedi</a>
  </div>
</div>

<script>
function togglePassword() {
  const pass = document.getElementById("password");
  pass.type = pass.type === "password" ? "text" : "password";
}
</script>

</body>
</html>
