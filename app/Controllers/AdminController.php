<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Admin;

class AdminController extends Controller
{
    public function handleAuthentication()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $codiceSicurezza = $_POST['codiceSicurezza'];

            $admin = new Admin();
            $loggedInAdmin = $admin->authenticate($email, $codiceSicurezza);

            if ($loggedInAdmin) {
                session_start();
                $_SESSION['admin'] = $loggedInAdmin;
                $_SESSION['user'] = $loggedInAdmin; // 🔹 TEST: Permette all'amministratore di accedere alla home
                $this->redirect('admin/dashboard'); // Cambiato a '/' per la Home
            } else {
                echo "Credenziali errate.";
            }
        } else {
            $this->view('admin_login');
        }
    }

    public function dashboard()
    {
        session_start();

        if (!isset($_SESSION['user']) || !isset($_SESSION['admin'])) {
            // Se l'amministratore non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "admin");
            exit();
        }

        $this->view('admin_dashboard'); // Mostra il pannello di amministrazione solo se l'amministratore è loggato
    }
}
