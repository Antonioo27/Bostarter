<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\LogModel;

class AuthController extends Controller
{
    public function handleRegister()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $log = new LogModel();
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
                $log->saveLog("AUTENTICAZIONE", "Registrazione effettuata con successo", ["user_email" => $email]);
                $this->redirect('login');
            } else {
                $log->saveLog("AUTENTICAZIONE", "Errore nella registrazione", ["user_email" => $email]);
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
            $log = new LogModel();
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = new User();
            $loggedInUser = $user->login($email, $password);

            if ($loggedInUser) {
                session_start();
                $_SESSION['user'] = [
                    'email' => $loggedInUser['Email'],
                    'password' => $loggedInUser['Password'],
                    'nome' => $loggedInUser['Nome'],
                    'cognome' => $loggedInUser['Cognome'],
                    'nickname' => $loggedInUser['Nickname']
                ];
                $log->saveLog("AUTENTICAZIONE", "Login effettuato con successo", ["user_email" => $email]);
                $this->redirect(''); // Cambiato a '/' per la Home
            } else {
                $log->saveLog("AUTENTICAZIONE", "Credenziali login errate", ["user_email" => $email]);
                echo "Credenziali errate.";
            }
        } else {
            $this->view('login');
        }
    }

    public function handleLogout()
    {
        session_start();

        $log = new LogModel();
        $log->saveLog("AUTENTICAZIONE", "Logout effettuato con successo", ["user_email" => $_SESSION['user']['email']]);
        // Distrugge la sessione
        session_unset();
        session_destroy();
        // Reindirizza alla pagina di login
        $this->redirect('login');
    }
}
