<?php
session_start();

// Configurazione del database
require 'config.php';

// Verifica login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$user_id = $_SESSION["id"]; // ID utente loggato
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestione File</title>
  <link rel="stylesheet" href="style_download.css">

    <style>
        /* Base */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Segoe UI", sans-serif;
}

body {
  background: #f3f4f6;
  color: #111827;
  display: flex;
  flex-direction: column;
}

/* Navbar */
.navbar {
  background: linear-gradient(135deg, #4f46e5, #3b82f6);
  padding: 15px 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: white;
}

.navbar h1 {
  font-size: 20px;
  font-weight: 600;
}

.nav-links a {
  margin-left: 12px;
  padding: 9px 14px;
  border-radius: 8px;
  text-decoration: none;
  font-weight: bold;
  transition: background 0.3s ease, transform 0.2s ease;
}

.home-btn {
  background: #10b981;
  color: white;
}

.home-btn:hover {
  background: #059669;
  transform: translateY(-2px);
}

.logout-btn {
  background: #ef4444;
  color: white;
}

.logout-btn:hover {
  background: #dc2626;
  transform: translateY(-2px);
}

/* Contenuto */
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 40px 20px;
}

.page-title {
  text-align: center;
  font-size: 1.8em;
  margin-bottom: 25px;
  color: #1f2937;
}

/* Messaggi */
.msg {
  max-width: 900px;
  margin: 10px auto;
  padding: 12px;
  border-radius: 6px;
  font-weight: 500;
}

.msg.success {
  background: #d1fae5;
  border-left: 6px solid #10b981;
  color: #065f46;
}

.msg.error {
  background: #fee2e2;
  border-left: 6px solid #ef4444;
  color: #991b1b;
}

.msg.info {
  background: #e0f2fe;
  border-left: 6px solid #3b82f6;
  color: #1e40af;
}

/* Lista file */
.file-list {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  list-style: none;
  padding: 0;
  justify-content: center;
}

.file-item {
  background: #fff;
  border-radius: 12px;
  padding: 15px;
  width: 230px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.file-item input[type="checkbox"] {
  position: absolute;
  top: 10px;
  left: 10px;
  transform: scale(1.3);
  cursor: pointer;
}

.file-preview {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 140px;
  overflow: hidden;
  margin-bottom: 12px;
}

.file-preview img,
.file-preview embed {
  max-width: 100%;
  max-height: 130px;
  border-radius: 6px;
}

.file-icon {
  font-size: 50px;
}

.file-name {
  font-weight: bold;
  text-align: center;
  margin-bottom: 10px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  width: 100%;
}

/* Azioni */
.file-actions {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
  justify-content: center;
}

.download-btn,
.delete-btn {
  padding: 8px 14px;
  border-radius: 6px;
  text-decoration: none;
  font-size: 0.9em;
  font-weight: bold;
  color: white;
}

.download-btn { background: #3b82f6; }
.download-btn:hover { background: #2563eb; }

.delete-btn { background: #ef4444; }
.delete-btn:hover { background: #dc2626; }

/* Eliminazione multipla */
.actions {
  margin-top: 25px;
  text-align: center;
}

.actions button {
  background: #ef4444;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: bold;
  cursor: pointer;
  transition: transform 0.2s ease, background 0.3s ease;
}

.actions button:hover {
  background: #dc2626;
  transform: translateY(-2px);
}
</style>

</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
<h2 class="page-title">I tuoi File</h2>

<?php

if (isset($_GET["delete_id"]) && is_numeric($_GET["delete_id"])) {
    $id = $_GET["delete_id"];

    // Verifica che il file appartenga all’utente
    $stmt = $conn->prepare("SELECT nome_salvato FROM files WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $row = $res->fetch_assoc();
        $filepath = "uploads/" . $row["nome_salvato"];

        // Elimina dal DB
        $del = $conn->prepare("DELETE FROM files WHERE id = ? AND user_id = ?");
        $del->bind_param("ii", $id, $user_id);

        if ($del->execute()) {
            if (file_exists($filepath)) unlink($filepath);
            echo "<p class='msg success'>File eliminato con successo.</p>";
        } else {
            echo "<p class='msg error'>Errore eliminazione file.</p>";
        }
        $del->close();
    } else {
        echo "<p class='msg error'>Non puoi eliminare questo file.</p>";
    }
    $stmt->close();
}

// ---------------------------
// 🔴 Eliminazione multipla
// ---------------------------
if (isset($_POST["selected_files"])) {
    $ids = $_POST["selected_files"];
    $count = 0;

    foreach ($ids as $id) {
        if (!is_numeric($id)) continue;

        // Verifica proprietà file
        $stmt = $conn->prepare("SELECT nome_salvato FROM files WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows === 1) {
            $row = $res->fetch_assoc();
            $filepath = "uploads/" . $row["nome_salvato"];

            $del = $conn->prepare("DELETE FROM files WHERE id = ? AND user_id = ?");
            $del->bind_param("ii", $id, $user_id);

            if ($del->execute()) {
                if (file_exists($filepath)) unlink($filepath);
                $count++;
            }
            $del->close();
        }
        $stmt->close();
    }

    if ($count > 0) echo "<p class='msg success'>Eliminati $count file.</p>";
}

// ---------------------------
// 📥 Recupera SOLO i file dell’utente
// ---------------------------
$stmt = $conn->prepare("SELECT id, nome_file, tipo_file FROM files WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<form method="post" action="download.php" onsubmit="return confirm(\'Eliminare i file selezionati?\')">';
    echo '<ul class="file-list">';

    while ($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $nome = htmlspecialchars($row["nome_file"]);
        $tipo = $row["tipo_file"];

        if ($tipo === 'application/pdf') {
            $preview = "<embed src='visualizza_file.php?id=$id' type='application/pdf'>";
        } elseif (strpos($tipo, 'image/') === 0) {
            $preview = "<img src='visualizza_file.php?id=$id'>";
        } else {
            $preview = "<span class='file-icon'>📄</span>";
        }

        echo "<li class='file-item'>
                <input type='checkbox' name='selected_files[]' value='$id'>
                <div class='file-preview'>$preview</div>
                <div class='file-name'>$nome</div>
                <div class='file-actions'>
                  <a href='download_process.php?id=$id' class='download-btn'>Scarica</a>
                  <a href='download.php?delete_id=$id' class='delete-btn'
                     onclick='return confirm(\"Eliminare questo file?\")'>Elimina</a>
                </div>
              </li>";
    }

    echo '</ul>';
    echo '<div class="actions"><button type="submit">Elimina Selezionati</button></div>';
    echo '</form>';
} else {
    echo "<p class='msg info'>Non hai caricato ancora nessun file.</p>";
}

$stmt->close();
$conn->close();
?>
</div>
</body>
</html>
