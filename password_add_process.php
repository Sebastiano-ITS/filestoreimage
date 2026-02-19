<?php
session_start();

// Se non loggato → redirect
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require 'config.php';

$user_id = $_SESSION["id"];

// Controllo POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $service = trim($_POST["service"]);
    $username = trim($_POST["username"]);
    $password_plain = trim($_POST["password"]);

    if ($service === "" || $username === "" || $password_plain === "") {
        header("Location: password_add.php?error=Campi+vuoti");
        exit;
    }

    // --- CIFRATURA PASSWORD ---
    $cipher = "AES-256-CBC";
    $key = ENCRYPT_KEY;

    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

    $encrypted_password = openssl_encrypt(
        $password_plain,
        $cipher,
        $key,
        0,
        $iv
    );

    // Salvo password + IV (serve per decifrare)
    $final_password = base64_encode($encrypted_password . "::" . base64_encode($iv));

    // Salvataggio nel DB
    $stmt = $conn->prepare("
        INSERT INTO passwords (user_id, service, username, password_encrypted)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param("isss", $user_id, $service, $username, $final_password);

    if ($stmt->execute()) {
        header("Location: password_add.php?success=Password+salvata");
        exit;
    } else {
        header("Location: password_add.php?error=Errore+inserimento+DB");
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>
