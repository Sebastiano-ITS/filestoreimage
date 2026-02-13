<?php
session_start();

// Verifica login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Connessione DB
require 'config.php';

// ID utente loggato
$user_id = $_SESSION["id"];

if (isset($_POST["submit"]) && isset($_FILES["files"])) {
    $target_dir = "uploads/";
    $total_files = count($_FILES["files"]["name"]);
    $upload_success_count = 0;
    $upload_error_messages = [];

    for ($i = 0; $i < $total_files; $i++) {

        $original_filename = basename($_FILES["files"]["name"][$i]);
        $tmp_name = $_FILES["files"]["tmp_name"][$i];

        // Se nessun file selezionato, salta
        if (empty($tmp_name)) {
            continue;
        }

        // Preparazione nuovo nome
        $new_name = uniqid() . "_" . $original_filename;
        $target_file = $target_dir . $new_name;
        $file_mime = $_FILES["files"]["type"][$i];
        $file_size = $_FILES["files"]["size"][$i];

        // Controllo dimensione max 10MB
        if ($file_size > 10000000) {
            $upload_error_messages[] = "Il file " . htmlspecialchars($original_filename) . " è troppo grande.";
            continue;
        }

        // Spostamento file
        if (move_uploaded_file($tmp_name, $target_file)) {

            // Salvataggio nel DB COMPRENSIVO DI user_id
            $stmt = $conn->prepare("
                INSERT INTO files (user_id, nome_file, nome_salvato, tipo_file)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->bind_param("sssi", $user_id, $original_filename, $new_name, $file_mime);

            if ($stmt->execute()) {
                $upload_success_count++;
            } else {
                $upload_error_messages[] = "Errore DB per " . htmlspecialchars($original_filename);
                unlink($target_file); // Rimuove file se DB fallisce
            }

            $stmt->close();
        } else {
            $upload_error_messages[] = "Errore nel caricamento di " . htmlspecialchars($original_filename);
        }
    }

    $conn->close();

    // Redirect alla pagina download con messaggi
    $query = http_build_query([
        'ok' => $upload_success_count,
        'errors' => urlencode(implode("|", $upload_error_messages))
    ]);

    header("Location: download.php?$query");
    exit;
}
?>
