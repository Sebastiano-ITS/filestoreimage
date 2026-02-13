<?php
// Configurazione del database (assicurati che sia corretta)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "file_manager";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

if(isset($_GET["id"])) {
    $id = $_GET["id"];

    $stmt = $conn->prepare("SELECT nome_salvato, tipo_file FROM files WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $filepath = "uploads/" . $row["nome_salvato"];

        if (file_exists($filepath)) {
            header('Content-Type: ' . $row["tipo_file"]);
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