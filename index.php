<?php
require_once __DIR__ . '/config/db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prova</title>
</head>

<body>
    <form method="post" action="index.php">
        <h1>Registrazione</h1>
        <input type="text" id="email" placeholder="Email" name="email" maxlength="30" required>
        <input type="text" id="nome" placeholder="Nome" name="nome" maxlength="30" required>
        <input type="text" id="cognome" placeholder="Cognome" name="cognome" maxlength="30" required>
        <input type="password" id="password" placeholder="Password" name="password" required>
        <input type="number" id="annoNascita" name="annoNascita" required>
        <input type="text" id="luogoNascita" placeholder="Luogo di Nascita" name="luogoNascita" maxlength="30" required>
        <input type="text" id="nickname" placeholder="Nickname" name="nickname" maxlength="30" required>
        <button type="submit" name="register">Registrati</button>
    </form>


</body>

</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $cognome = mysqli_real_escape_string($conn, $_POST["cognome"]);
    $nickname = mysqli_real_escape_string($conn, $_POST["nickname"]);
    $annoNascita = mysqli_real_escape_string($conn, $_POST["annoNascita"]);
    $luogoNascita = mysqli_real_escape_string($conn, $_POST["luogoNascita"]);
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $query = "CALL inserisciUtente('$email', '$hashed_password', '$annoNascita', '$cognome', '$nome', '$luogoNascita', '$nickname')";

    if ($conn->query($query) === TRUE) {
        echo "Registrazione avvenuta con successo";
    } else {
        echo "Errore nella registrazione: " . $conn->error;
    }

    $conn->close();
}
?>