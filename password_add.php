<?php
session_start();
require "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// INVIO FORM
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_SESSION['username'];
    $service = $_POST['service'];
    $password_plain = $_POST['password'];

    // Cifra la password
    $cipher = "AES-256-CBC";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
    $password_enc = openssl_encrypt($password_plain, $cipher, $encryption_key, 0, $iv);
    $password_enc = base64_encode($password_enc . "::" . $iv);

    $stmt = $conn->prepare("INSERT INTO passwords (username, service, password_enc) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $service, $password_enc);
    $stmt->execute();

    header("Location: password_view.php?msg=Password salvata");
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<title>Nuova Password</title>
<style>
    /* PAGINA AGGIUNTA PASSWORD */
.password-add-container {
    max-width: 450px;
    margin: 40px auto;
    padding: 25px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}

.password-add-container h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
    color: #333;
}

/* FORM */
.password-add-container label {
    font-weight: 600;
    color: #333;
}

.password-add-container input {
    width: 100%;
    padding: 12px;
    margin-top: 6px;
    margin-bottom: 15px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 16px;
    transition: 0.2s;
}

.password-add-container input:focus {
    border-color: #007bff;
    outline: none;
}

/* BOTTONE */
.btn-submit {
    width: 100%;
    padding: 12px;
    background: #28a745;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 18px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.2s;
}

.btn-submit:hover {
    background: #218838;
}
</style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="password-add-container">
    <h2>Aggiungi Nuova Password</h2>

    <form action="password_add_process.php" method="POST">
        <label for="service">Servizio / Sito</label>
        <input type="text" name="service" id="service" required>

        <label for="username">Username / Email</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Password</label>
        <input type="text" name="password" id="password" required>

        <button type="submit" class="btn-submit">Salva Password</button>
    </form>
</div>

</body>
</html>
