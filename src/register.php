<?php
require_once __DIR__ . '/../config/db.php';
?>

<?php include 'header.php'; ?>

<body>

    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="row w-50 h-100 d-flex flex-column justify-content-center align-items-center h-50">
            <div class="col-lg-12  h-50 d-flex flex-column justify-content-center align-items-center">
                <h1 style="margin-bottom: 2rem;">Registrazione</h1>
                <form action="register.php" method="POST" class="d-flex w-100 h-100 flex-column justify-content-between align-items-center">
                    <div>
                        <input type="text" id="email" placeholder="Email" name="email" maxlength="30" required>
                        <input type="text" id="nome" placeholder="Nome" name="nome" maxlength="30" required>
                    </div>
                    <div>
                        <input type="text" id="cognome" placeholder="Cognome" name="cognome" maxlength="30" required>
                        <input type="password" id="password" placeholder="Password" name="password" required>
                    </div>
                    <div>
                        <input type="number" id="annoNascita" name="annoNascita" required>
                        <input type="text" id="luogoNascita" placeholder="Luogo di Nascita" name="luogoNascita" maxlength="30" required>
                    </div>
                    <div>
                        <input type="text" id="nickname" placeholder="Nickname" name="nickname" maxlength="30" required>
                    </div>
                    <button type="submit" name="register">Registrati</button>
                </form>
            </div>
        </div>
    </div>
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