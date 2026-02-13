<?php
session_start();

// Verifica se l'utente è loggato. Se no, reindirizza alla pagina di login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Configurazione del database
require 'config.php';

if(isset($_GET["id"])) {
    $id = $_GET["id"];

    // Recupera le informazioni del file dal database
    $stmt = $conn->prepare("SELECT nome_file, nome_salvato, tipo_file FROM files WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $filepath = "uploads/" . $row["nome_salvato"];

        if (file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: ' . $row["tipo_file"]);
            header('Content-Disposition: attachment; filename="' . $row["nome_file"] . '"');
            header('Content-Length: ' . filesize($filepath));
            header('Cache-Control: public');
            header('Pragma: public');
            ob_clean();
            flush();
            readfile($filepath);
            exit;
        } else {
            echo "File non trovato sul server.";
        }
    } else {
        echo "File non trovato nel database.";
    }
    $stmt->close();
}

$conn->close();
?>