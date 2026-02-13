<?php
session_start();

require 'config.php';

// ... (Configurazione del database) ...

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepara la query per cercare l'utente e la sua password hashata
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Hasha la password inserita dall'utente con SHA256 e confrontala con l'hash nel database
        $hashed_password = hash('sha256', $password);
        if ($hashed_password === $row["password"]) {
            // Login riuscito: imposta le variabili di sessione
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $row["id"];
            $_SESSION["username"] = $row["username"];

            // Reindirizza alla pagina protetta
            header("location: dashboard.php");
        } else {
            // Password non valida
            header("location: login.php?error=Password non valida");
        }
    } else {
        // Utente non trovato
        header("location: login.php?error=Utente non trovato");
    }

    $stmt->close();
}

$conn->close();
?>