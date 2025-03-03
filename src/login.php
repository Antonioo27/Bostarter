<?php
require_once __DIR__ . '/config/db.php';
?>

<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <form action="login.php" method="POST">
            <h1>Accedi</h1>
            <h3>Email </h3>
            <input type="text" id="email" placeholder="Email" name="email" maxlength="30" required>
            <h3>Password </h3>
            <input type="password" id="password" placeholder="Password" name="password" required>
            <button type="submit" name="login">Accedi</button>
        </form>

        <p> Sei nuovo su Bostarter? <a href="register.php">Registrati</a><p>
    </body>
</html>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"];

    $query = "CALL autenticaUtente('$email')";
    $result = $conn->query($query);

    if($result && $row = $result->fetch_assoc()){
        
        $hashed_password_db = $row["Password"];

        if(password_verify($password, $hashed_password)){
            echo "Accesso effettuato";


           
        } else {
            echo "Email o password errati";
        }
    } else {
        echo "Email non trovata";
    }

    $conn->close();
}
?>
