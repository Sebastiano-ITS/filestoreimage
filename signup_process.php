<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Controllo se username esiste già
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("location: signup.php?error=Username già esistente");
        exit;
    }

    // Hash SHA256 (come nel login)
    $hashed_password = hash('sha256', $password);

    // Inserimento nuovo utente
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        header("location: login.php?success=Registrazione completata");
        exit;
    } else {
        header("location: signup.php?error=Errore durante la registrazione");
        exit;
    }

    $stmt->close();
}

$conn->close();
?>
