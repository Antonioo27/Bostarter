<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Project;
use App\Models\LogModel;

class HomeCreatorController extends Controller
{

    public function viewFormNewProject()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "login");
            exit();
        }

        $this->view('addProject'); // Mostra il form per aggiungere un nuovo progetto
    }


    public function addNewProject()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "login");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $log = new LogModel();

            // Recupera i dati dal form
            $nome = $_POST['nome'];
            $descrizione = $_POST['descrizione'];
            $email = $_SESSION['user']['email'];
            $data_limite = $_POST['data_limite'];
            $budget = $_POST['budget'];

            $fotoArray = [];

            if (!empty($_FILES['foto']['name'][0])) {
                foreach ($_FILES['foto']['tmp_name'] as $tmpName) {
                    if ($tmpName) {
                        $fotoArray[] = file_get_contents($tmpName);
                    }
                }
            }

            $project = new Project();
            $result = $project->addNewProject($nome, $descrizione, $email, $data_limite, $budget);

            if ($result) {
                foreach ($fotoArray as $foto) {
                    $project->addNewFotoProject($foto, $nome);
                }
                header("Location: " . URL_ROOT);
                $log->saveLog("PROGETTO", "Progetto aggiunto con successo", ["email_utente" => $email, "nome_progetto" => $nome]);
                exit();
            } else {
                $log->saveLog("PROGETTO", "ERRORE : Progetto non inserito", ["email_utente" => $email, "nome_progetto" => $nome]);
                echo "Errore durante l'inserimento del progetto.";
            }
        }
    }
}
