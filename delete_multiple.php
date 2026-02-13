<?php
// Configurazione del database
$servername = "localhost";
$username = "root"; // Sostituisci con il tuo username MySQL
$password = "NuovaPassword";     // Sostituisci con la tua password MySQL
$dbname = "file_manager"; // Sostituisci con il nome del tuo database

// Crea una connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la connessione
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

if (isset($_POST["selected_files"]) && is_array($_POST["selected_files"])) {
    $file_ids_to_delete = $_POST["selected_files"];
    $deleted_count = 0;
    $errors = [];

    // Prepara una query per selezionare i nomi dei file da eliminare
    $stmt_select = $conn->prepare("SELECT nome_salvato FROM files WHERE id = ?");

    // Prepara una query per eliminare i record dal database
    $stmt_delete = $conn->prepare("DELETE FROM files WHERE id = ?");

    foreach ($file_ids_to_delete as $id) {
        if (is_numeric($id)) {
            // Recupera il nome del file dal database
            $stmt_select->bind_param("i", $id);
            $stmt_select->execute();
            $result_select = $stmt_select->get_result();

            if ($result_select->num_rows == 1) {
                $row = $result_select->fetch_assoc();
                $nome_file_salvato = $row["nome_salvato"];
                $filepath = "uploads/" . $nome_file_salvato;

                // Elimina il record dal database
                $stmt_delete->bind_param("i", $id);
                if ($stmt_delete->execute()) {
                    // Elimina il file dal server
                    if (file_exists($filepath)) {
                        if (unlink($filepath)) {
                            $deleted_count++;
                        } else {
                            $errors[] = "Errore nell'eliminazione del file dal server: " . htmlspecialchars($nome_file_salvato);
                        }
                    } else {
                        $errors[] = "File non trovato sul server: " . htmlspecialchars($nome_file_salvato);
                    }
                } else {
                    $errors[] = "Errore nell'eliminazione del record dal database (ID: " . $id . "): " . $conn->error;
                }
            } else {
                $errors[] = "File non trovato nel database (ID: " . $id . ").";
            }
        } else {
            $errors[] = "ID del file non valido: " . htmlspecialchars($id);
        }
    }

    $stmt_select->close();
    $stmt_delete->close();

    $message = "";
    if ($deleted_count > 0) {
        $message .= "Eliminati con successo " . $deleted_count . " file.<br>";
    }
    if (!empty($errors)) {
        $message .= "Si sono verificati i seguenti errori:<br>";
        foreach ($errors as $error) {
            $message .= "- " . $error . "<br>";
        }
    }

    // Reindirizza l'utente alla pagina di download con un messaggio
    $redirect_url = 'download.html';
    if (!empty($message)) {
        $redirect_url .= '?message=' . urlencode($message);
    }
    header("Location: " . $redirect_url);
    exit();

} else {
    // Se non sono stati selezionati file
    header("Location: download.html?error=" . urlencode("Nessun file selezionato per l'eliminazione."));
    exit();
}

$conn->close();
?>