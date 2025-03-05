<?php
require_once __DIR__ . '/../database/dbconnector.php';
require_once __DIR__ . '/../models/utente.php'; // Importa la classe utente    

include 'header.php';

use models\utente;



?>


<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4 rounded-3" style="width: 100%; max-width: 400px;">
            <h2 class="text-center mb-4">Accedi</h2>
            <form action="login.php" method="POST">
                <div class="row g-3">
                    <div class="col-lg-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" class="form-control" name="email" required>
                    </div>
                    <div class="col-lg-12">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" class="form-control" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100 rounded-3">Accedi</button>
                </div>
            </form>
            <p class="mt-3 text-center">
                Sei nuovo su Bostarter? <a href="register.php">Registrati</a>
            </p>
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