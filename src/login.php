<?php
require_once __DIR__ . '/config/db.php';
?>

<form action="login.php" method="POST">
    <h1>Accedi</h1>
    <h3>Email </h3>
    <input type="text" id="email" placeholder="Email" name="email" maxlength="30" required>
    <h3>Password </h3>
    <input type="password" id="password" placeholder="Password" name="password" required>
    <button type="submit" name="login">Accedi</button>
</form>

<p> Sei nuovo su Bostarter? <a href="register.php">Registrati</a>
<p>