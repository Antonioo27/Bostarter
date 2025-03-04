<?php
require_once __DIR__ . '/../database/dbconnector.php';
require_once __DIR__ . '/../models/utente.php'; // Importa la classe utente    

include 'header.php';

use models\utente;



?>


<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="row d-flex flex-column justify-content-center align-items-center" style="background-color: white; width: 60%; height: 70%;">
            <div class="col-lg-12  h-100  d-flex flex-column justify-content-center align-items-center p-3">
                <h1 style="margin-bottom: 2rem;">Accedi</h1>
                <form action="login.php" method="POST" class="d-flex w-100 h-100 flex-column justify-content-between align-items-center">
                    <div>
                        <div>
                            <p>Email </p>
                            <input type="text" id="email" placeholder="Email" name="email" maxlength="30" required>
                        </div>
                    </div>
                    <div>
                        <div>
                            <p>Password </p>
                            <input type="password" id="password" placeholder="Password" name="password" required>
                        </div>
                    </div>
                    <button type="submit" name="login">Accedi</button>
                    <p> Sei nuovo su Bostarter? <a href="register.php">Registrati</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];

    // Recupera la password hashata dal database
    $hashed_password = utente::autenticaUtente($email);
    $hashed_password = trim($hashed_password);
    // Debug per vedere cosa viene restituito
    if ($hashed_password === null) {
        die("Errore: Nessuna password trovata per questa email.");
    }


    // Verifica la password
    if (password_verify($password, $hashed_password)) {
        echo "Password verificata con successo!<br>";

        $_SESSION["user"] = $email;
        header("Location: home.php");
        exit();
    } else {
        echo "Email o password errati.";
    }
}

?>