<?php
session_start();
require "config.php";

if (!isset($_SESSION["loggedin"])) {
    header("location: login.php");
    exit;
}

$user_id = $_SESSION["id"];
$old = $_POST["old_password"];
$new = $_POST["new_password"];

// Recupera password attuale
$stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Verifica password
if (!password_verify($old, $user["password"])) {
    header("Location: profile.php?error=1");
    exit;
}

// Aggiorna con la nuova password
$new_hash = password_hash($new, PASSWORD_DEFAULT);
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
$stmt->bind_param("ss", $new_hash, $user_id);
$stmt->execute();
$stmt->close();

header("Location: profile.php?success=1");
exit;
