<?php
session_start();

// Configurazione del database
require 'config.php';

// Verifica se l'utente è loggato. Se no, reindirizza alla pagina di login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Gestione File</title>
  <link rel="stylesheet" href="style_download.css">
</head>
<body>
  <!-- Navbar -->
   <?php include 'navbar.php'; ?>


  <div class="container">
    <h2 class="page-title">Anteprima e Download</h2>

    <?php
    // Eliminazione singola
    if (isset($_GET["delete_id"]) && is_numeric($_GET["delete_id"])) {
        $id_da_eliminare = $_GET["delete_id"];
        $stmt = $conn->prepare("SELECT nome_salvato FROM files WHERE id = ?");
        $stmt->bind_param("i", $id_da_eliminare);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $filepath = "uploads/" . $row["nome_salvato"];

            $del = $conn->prepare("DELETE FROM files WHERE id = ?");
            $del->bind_param("i", $id_da_eliminare);

            if ($del->execute()) {
                if (file_exists($filepath)) unlink($filepath);
                echo "<p class='msg success'>File eliminato con successo.</p>";
            } else {
                echo "<p class='msg error'>Errore nell'eliminazione dal database.</p>";
            }
            $del->close();
        } else {
            echo "<p class='msg error'>File non trovato.</p>";
        }
        $stmt->close();
    }

    // Eliminazione multipla
    if (isset($_POST["selected_files"])) {
        $ids = $_POST["selected_files"];
        $count = 0;
        foreach ($ids as $id) {
            if (is_numeric($id)) {
                $stmt = $conn->prepare("SELECT nome_salvato FROM files WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $res = $stmt->get_result();
                if ($res->num_rows === 1) {
                    $row = $res->fetch_assoc();
                    $filepath = "uploads/" . $row["nome_salvato"];
                    $del = $conn->prepare("DELETE FROM files WHERE id = ?");
                    $del->bind_param("i", $id);
                    if ($del->execute()) {
                        if (file_exists($filepath)) unlink($filepath);
                        $count++;
                    }
                    $del->close();
                }
                $stmt->close();
            }
        }
        if ($count > 0) echo "<p class='msg success'>Eliminati $count file.</p>";
    }

    // Recupera file
    $sql = "SELECT id, nome_file, tipo_file FROM files";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<form method="post" action="download.php" onsubmit="return confirm(\'Sei sicuro di voler eliminare i file selezionati?\')">';
        echo '<ul class="file-list">';
        while ($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $nome = htmlspecialchars($row["nome_file"]);
            $tipo = $row["tipo_file"];
            $preview = '';

            if ($tipo === 'application/pdf') {
                $preview = "<embed src='visualizza_file.php?id=$id' type='application/pdf'>";
            } elseif (strpos($tipo, 'image/') === 0) {
                $preview = "<img src='visualizza_file.php?id=$id' alt='$nome'>";
            } else {
                $preview = "<span class='file-icon'>📄</span>";
            }

            echo "<li class='file-item'>
              <input type='checkbox' name='selected_files[]' value='$id'>
              <div class='file-preview'>$preview</div>
              <div class='file-name'>$nome</div>
              <div class='file-actions'>
                <a href='download_process.php?id=$id' class='download-btn'>Scarica</a>
                <a href='download.php?delete_id=$id' class='delete-btn' onclick='return confirm(\"Sei sicuro di voler eliminare questo file?\")'>Elimina</a>
              </div>
            </li>";
        }
        echo '</ul>';
        echo '<div class="actions"><button type="submit">Elimina Selezionati</button></div>';
        echo '</form>';
    } else {
        echo "<p class='msg info'>Nessun file caricato.</p>";
    }

    $conn->close();
    ?>
  </div>
</body>
</html>
