<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Admin;
use App\Models\LogModel;

class AdminController extends Controller
{
    public function handleAuthentication()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $log = new LogModel();
            $email = $_POST['email'];
            $codiceSicurezza = $_POST['codiceSicurezza'];
            $password = $_POST['password'];

            $admin = new Admin();
            $loggedInAdmin = $admin->authenticate($email, $codiceSicurezza, $password);

            if ($loggedInAdmin) {
                session_start();
                $_SESSION['admin'] = [
                    'email' => $loggedInAdmin['Email'],
                    'password' => $loggedInAdmin['Password'],
                    'nome' => $loggedInAdmin['Nome'],
                    'cognome' => $loggedInAdmin['Cognome'],
                    'nickname' => $loggedInAdmin['Nickname']
                ];
                $_SESSION['user'] = [
                    'email' => $loggedInAdmin['Email'],
                    'password' => $loggedInAdmin['Password'],
                    'nome' => $loggedInAdmin['Nome'],
                    'cognome' => $loggedInAdmin['Cognome'],
                    'nickname' => $loggedInAdmin['Nickname']
                ];

                $competenze = $this->ottieniCompetenze();
                $log->saveLog("AUTENTICAZIONE", "Login amministratore effettuato con successo", ["admin_email" => $email]);

                $this->view('admin_dashboard', ['competenze' => $competenze]); // Cambiato a '/' per la Home
            } else {
                $log->saveLog("AUTENTICAZIONE", "Errore autenticazione amministratore", ["admin_email" => $email]);
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

        $competenze = $this->ottieniCompetenze();
        $this->view('admin_dashboard', ['competenze' => $competenze]); // Mostra il pannello di amministrazione solo se l'amministratore è loggato
    }

    public function aggiungiCompetenza()
    {

        session_start();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $log = new LogModel();
            $nomeCompetenza = $_POST['competenza'];
            $emailAdmin = $_SESSION['admin']['email']; // Ottieni l'email dell'admin loggato

            $admin = new Admin();
            $result = $admin->addCompetence($nomeCompetenza, $emailAdmin);

            if ($result) {
                header("Location: " . URL_ROOT . "admin/dashboard");
                $log->saveLog("COMPETENZA", "Competenza aggiunta con successo", ["nome_competenza" => $nomeCompetenza]);
                exit();
            } else {
                $log->saveLog("COMPETENZA", "ERRORE : Competenza non aggiunta", ["nome_competenza" => $nomeCompetenza]);
                echo "Errore durante l'aggiunta della competenza.";
            }
        }
    }

    public function rimuoviCompetenza()
    {
        session_start();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $log = new LogModel();
            $nomeCompetenza = $_POST['competenza'];
            $emailAdmin = $_SESSION['admin']['email']; // Ottieni l'email dell'admin loggato

            $admin = new Admin();
            $result = $admin->removeCompetence($nomeCompetenza, $emailAdmin);

            if ($result) {
                header("Location: " . URL_ROOT . "admin/dashboard");
                $log->saveLog("COMPETENZA", "Competenza rimossa con successo", ["nome_competenza" => $nomeCompetenza]);
                exit();
            } else {
                $log->saveLog("COMPETENZA", "ERRORE : Competenza non rimossa", ["nome_competenza" => $nomeCompetenza]);
                echo "Errore durante la rimozione della competenza.";
            }
        }
    }

    public function ottieniCompetenze()
    {
        $admin = new Admin();
        $competenze = $admin->getCompetences();

        return $competenze;
    }
}
