<?php
session_start();
// Unset tutte le variabili di sessione
$_SESSION = array();

// Distrugge la sessione
session_destroy();

// Reindirizza alla pagina di login
header("location: login.php");
exit;
?>