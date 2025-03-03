<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: register.php");
    exit();
}
?>
<h1>Benvenuto nella Home</h1>