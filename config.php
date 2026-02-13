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


?>