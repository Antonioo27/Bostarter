<?php
require_once __DIR__ . '/../database/dbconnector.php';
require_once __DIR__ . '/../models/utente.php'; // Importa la classe utente    

include 'header.php';

use models\utente;



?>


<body>
    <form action="login.php" method="POST">
        <h1>Accedi</h1>
        <h3>Email </h3>
        <input type="text" id="email" placeholder="Email" name="email" maxlength="30" required>
        <h3>Password </h3>
        <input type="password" id="password" placeholder="Password" name="password" required>
        <button type="submit" name="login">Accedi</button>
    </form>

    <p> Sei nuovo su Bostarter? <a href="register.php">Registrati</a>
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

    echo "Password hashata dal DB: " . $hashed_password . "<br>";
    echo "Password inserita: " . $password . "<br>";

    // Verifica la password
    if (password_verify($password, $hashed_password)) {
        echo "Password verificata con successo!<br>";

        $_SESSION["user"] = $email;
        header("Location: ../../home.php");
        exit();
    } else {
        echo "Email o password errati.";
    }
}

?>