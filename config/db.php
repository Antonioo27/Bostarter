<?php
$db_host = "localhost"; // Server MySQL (in XAMPP è localhost)
$db_user = "root"; // Utente predefinito di MySQL su XAMPP
$db_password = ""; // In XAMPP la password di root è vuota di default
$db = "BOSTARTER"; // Sostituiscilo con il tuo database

// Creazione connessione
$conn = new mysqli($db_host, $db_user, $db_password, $db);

// Controlla la connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
