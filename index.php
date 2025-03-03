<?php
require_once __DIR__ . '/config/db.php';

// Esegui una query di esempio
$sql = "SELECT * FROM UTENTE";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prova</title>
</head>

<body>
    <form method="post" action="/php/register.php">
        <h1>Registrazione</h1>
        <input type="text" id="username" placeholder="Username" name="username" maxlength="50" required>
        <input type="password" id="password" placeholder="Password" name="password" required>
        <button type="submit" name="register">Registrati</button>
    </form>


</body>

</html>