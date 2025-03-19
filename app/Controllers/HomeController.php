<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Project;
use App\Models\LogModel;

class HomeController extends Controller
{
    public function index()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "login");
            exit();
        }
        $progetti = $this->getProgetti();
        $this->view('home', ['progetti' => $progetti]); // Mostra la home solo se l'utente è loggato
    }

    public function getProgetti()
    {
        $project = new Project();
        $rows = $project->getProjects(); // Recupera i dati dal Model

        $progetti = [];

        foreach ($rows as $row) {
            $nomeProgetto = $row['Nome'];

            // Se il progetto non è già stato aggiunto, lo inizializziamo
            if (!isset($progetti[$nomeProgetto])) {
                $progetti[$nomeProgetto] = [
                    'Nome' => $row['Nome'],
                    'Descrizione' => $row['Descrizione'],
                    'Email_Creatore' => $row['Email_Creatore'],
                    'Data_Limite' => $row['Data_Limite'],
                    'Budget' => $row['Budget'],
                    'Totale_Finanziamenti' => $row['Totale_Finanziamenti'] ?? 0,
                    'Foto_Progetto' => []
                ];
            }

            if (!empty($row['Codice_Foto'])) {
                $progetti[$nomeProgetto]['Foto_Progetto'][] = "data:image/jpeg;base64," . base64_encode($row['Codice_Foto']);
            }
        }

        return array_values($progetti);
    }



    public function aggiungiProgetto()
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
