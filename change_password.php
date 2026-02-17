<?php
session_start();
require "config.php";

if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["id"];
$old = hash('sha256', $_POST["old_password"]);
$new = hash('sha256', $_POST["new_password"]);

// Verifica vecchia password
$stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$real = $stmt->get_result()->fetch_assoc()["password"];
$stmt->close();

if ($old !== $real) {
    header("Location: profile.php?error=Password errata");
    exit;
}

// Aggiorna password
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
$stmt->bind_param("si", $new, $user_id);
$stmt->execute();
$stmt->close();

header("Location: profile.php?success=Password aggiornata");
exit;
?>
