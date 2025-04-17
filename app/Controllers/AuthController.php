<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Creator;
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

                $role = $user->getRole($email);

                session_start();
                $_SESSION['user'] = [
                    'email' => $loggedInUser['Email'],
                    'password' => $loggedInUser['Password'],
                    'nome' => $loggedInUser['Nome'],
                    'cognome' => $loggedInUser['Cognome'],
                    'nickname' => $loggedInUser['Nickname'],
                    'role' => $role,
                ];

                if ($role == 2) {
                    $log->saveLog("AUTENTICAZIONE", "Login Creatore effettuato con successo", ["user_email" => $email]);
                    $this->redirect(''); // Cambiato a '/' per la Home
                } else if($role == 1) {
                    $log->saveLog("AUTENTICAZIONE", "Login Amministratore effettuato con successo", ["user_email" => $email]);
                    $_SESSION['admin'] = [
                        'email' => $loggedInUser['Email'],
                        'password' => $loggedInUser['Password'],
                        'nome' => $loggedInUser['Nome'],
                        'cognome' => $loggedInUser['Cognome'],
                        'nickname' => $loggedInUser['Nickname'],
                        'role' => $role['Ruolo'],
                    ];
                    $this->redirect(''); // Cambiato a '/' per la Home
                }   
                else {
                    $log->saveLog("AUTENTICAZIONE", "Login effettuato con successo", ["user_email" => $email]);
                    $this->redirect(''); // Cambiato a '/' per la Home
                }
            } else {
                $log->saveLog("AUTENTICAZIONE", "Credenziali login errate", ["user_email" => $email]);
                $this->view('login', ['error' => 'Email o password errati.']);
            }
        } else {
            $this->view('login');
        }
    }

    public function handleRegisterCreator()
    {
        session_start();

        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['email'])) {
            echo "Errore: nessuna sessione attiva o email non trovata.";
            return;
        }
        $log = new LogModel();
        $creator = new Creator();

        $emailCreatore = $_SESSION['user']['email'];

        $result = $creator->register($emailCreatore);

        if ($result) {
            $_SESSION['user']['is_creator'] = true;
            $log->saveLog("AUTENTICAZIONE", "Registrazione creatore effettuata con successo", ["user_email" => $emailCreatore]);
            $this->redirect('');
        } else {
            $log->saveLog("AUTENTICAZIONE", "Errore nella registrazione del creatore", ["user_email" => $emailCreatore]);
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
