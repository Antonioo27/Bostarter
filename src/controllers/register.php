<?php
require_once __DIR__ . '/../database/dbconnector.php';
require_once __DIR__ . '/../models/utente.php'; // Importa la classe utente

include 'header.php';

use models\utente;

?>


<body>

    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="row w-50 h-100 d-flex flex-column justify-content-center align-items-center h-50">
            <div class="col-lg-12  h-50  d-flex flex-column justify-content-center align-items-center">
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


    $nome = htmlspecialchars($_POST["nome"], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
    $password = trim(htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8'));
    $cognome = htmlspecialchars($_POST["cognome"], ENT_QUOTES, 'UTF-8');
    $nickname = htmlspecialchars($_POST["nickname"], ENT_QUOTES, 'UTF-8');
    $annoNascita = (int) htmlspecialchars($_POST["annoNascita"], ENT_QUOTES, 'UTF-8');
    $luogoNascita = htmlspecialchars($_POST["luogoNascita"], ENT_QUOTES, 'UTF-8');
    $hashed_password = hash('sha512', $password);

    echo $password;
    $success = utente::inserisciUtente($email, $hashed_password, $nome, $cognome, $annoNascita, $luogoNascita, $nickname);

    if ($success) {
        echo "Registrazione avvenuta con successo!";
        // Puoi anche fare un redirect alla pagina di login
        // header("Location: login.php");
        // exit();
    } else {
        echo "Errore nella registrazione.";
    }
}
?>