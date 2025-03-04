<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: src/controllers/login.php");
    exit();
}
?>
<h1>Benvenuto nella Home</h1>