<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    public function handleRegister()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Logica per la registrazione dell'utente
            $nome = $_POST['nome'];
            $cognome = $_POST['cognome'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $annoNascita = $_POST['annoNascita'];
            $luogoNascita = $_POST['luogoNascita'];
            $nickname = $_POST['nickname'];

            $user = new User();
            $result = $user->register($nome, $cognome, $email, $password, $annoNascita, $luogoNascita, $nickname);

            if ($result) {
                echo "Registrazione completata con successo!";
                $this->redirect('login');
            } else {
                echo "Errore nella registrazione.";
            }
        } else {
            // Mostra il form di registrazione (GET)
            $this->view('register');
        }
    }

    public function handleLogin()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = new User();
            $loggedInUser = $user->login($email, $password);

            if ($loggedInUser) {
                session_start();
                $_SESSION['user'] = $loggedInUser;
                $this->redirect(''); // Cambiato a '/' per la Home
            } else {
                echo "Credenziali errate.";
            }
        } else {
            $this->view('login');
        }
    }

    public function handleLogout()
    {
        session_start();

        // Distrugge la sessione
        session_unset();
        session_destroy();

        // Reindirizza alla pagina di login
        $this->redirect('login');
    }
}
