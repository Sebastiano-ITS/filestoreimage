<?php
session_start();
require 'config.php';

// Utente loggato?
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$user_id = $_SESSION["id"];
$username = $_SESSION["username"];

// Conta i file dell'utente
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM files WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$total_files = $result['total'];
$stmt->close();

// Messaggi cambio password
$msg = "";
if (isset($_GET['success'])) $msg = "<p class='msg success'>Password cambiata con successo</p>";
if (isset($_GET['error']))   $msg = "<p class='msg error'>Errore: password attuale errata</p>";
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profilo Utente</title>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body {
    font-family: "Segoe UI", sans-serif;
    background: #f3f4f6;
    margin: 0;
    padding: 0;
}

/* Contenitore principale */
.profile-container {
    max-width: 600px;
    margin: 40px auto;
    background: #fff;
    padding: 25px;
    border-radius: 14px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
}

/* Intestazione profilo */
.profile-header {
    text-align: center;
    margin-bottom: 25px;
}

.profile-header i {
    font-size: 70px;
    color: #4f46e5;
    margin-bottom: 10px;
}

.profile-header h2 {
    margin: 0;
}

.profile-info {
    margin: 20px 0;
    background: #eef2ff;
    padding: 15px;
    border-left: 6px solid #4f46e5;
    border-radius: 8px;
}

.profile-info p {
    font-size: 16px;
    margin: 8px 0;
}

/* Form cambio password */
form {
    margin-top: 25px;
}

form label {
    font-weight: bold;
}

form input {
    width: 100%;
    padding: 10px;
    margin-top: 6px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 15px;
    outline: none;
}

form input:focus {
    border-color: #4f46e5;
}

/* Bottone cambio password */
button {
    width: 100%;
    margin-top: 15px;
    padding: 12px;
    background: #4f46e5;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: background .2s;
}

button:hover {
    background: #4338ca;
}

/* Messaggi */
.msg {
    padding: 12px;
    margin-bottom: 15px;
    border-radius: 8px;
    font-weight: bold;
    text-align: center;
}
.msg.success { background: #d1fae5; color: #065f46; border-left: 5px solid #10b981; }
.msg.error   { background: #fee2e2; color: #991b1b; border-left: 5px solid #ef4444; }
</style>
</head>

<body>

<?php include "navbar.php"; ?>

<div class="profile-container">

    <div class="profile-header">
        <i class="fa-solid fa-circle-user"></i>
        <h2><?php echo htmlspecialchars($username); ?></h2>
    </div>

    <?php echo $msg; ?>

    <div class="profile-info">
        <p><strong>👤 Username:</strong> <?php echo htmlspecialchars($username); ?></p>
        <p><strong>📂 File caricati:</strong> <?php echo $total_files; ?></p>
    </div>

    <h3>Cambia Password</h3>
    <form action="profile_update_password.php" method="POST">
        <label>Password attuale:</label>
        <input type="password" name="old_password" required>

        <label>Nuova password:</label>
        <input type="password" name="new_password" required>

        <button type="submit">Aggiorna Password</button>
    </form>
</div>

</body>
</html>
