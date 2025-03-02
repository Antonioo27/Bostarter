<?php
$host = "localhost"; // Server MySQL (in XAMPP è localhost)
$username = "root"; // Utente predefinito di MySQL su XAMPP
$password = ""; // In XAMPP la password di root è vuota di default
$db = "BOSTARTER"; // Sostituiscilo con il tuo database

// Creazione connessione
$db_connection = new mysqli($db_host, $db_user, $db_password, $db);

// Controlla la connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

echo "Connessione riuscita!";
